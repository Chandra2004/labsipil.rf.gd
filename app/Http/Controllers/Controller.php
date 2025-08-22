<?php
namespace TheFramework\Http\Controllers;

use TheFramework\Models\HomeModel;

abstract class Controller {
    protected $HomeModel;

    public function __construct() {
        $this->HomeModel = new HomeModel();
    }

    public function ProcessImage($file, $uid = null) {
        if ($file['error'] === 4) {
            return 'required_image';
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return 'failed_upload';
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExtensions)) {
            return 'failed_extension';
        }

        $maxFileSize = 2 * 1024 * 1024;
        if ($file['size'] > $maxFileSize) {
            return 'failed_size';
        }

        $mime = mime_content_type($file['tmp_name']);
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/pjpeg', 'image/jpg'];
        if (!in_array($mime, $allowedMimeTypes)) {
            return 'failed_mime';
        }

    
        $uploadDir = ROOT_DIR . '/private-uploads/user-pictures/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid('img_') . '.webp';
        $targetPath = $uploadDir . $fileName;

        $source = null;
        try {
            if ($ext === 'jpg' || $ext === 'jpeg') {
                $source = @imagecreatefromjpeg($file['tmp_name']);
            } elseif ($ext === 'png') {
                $source = @imagecreatefrompng($file['tmp_name']);
            }

            if (!$source) {
                return 'failed_read';
            }

            $maxWidth = 800;
            $width = imagesx($source);
            $height = imagesy($source);

            if ($width > $maxWidth) {
                $newHeight = intval($height * ($maxWidth / $width));
                $resized = imagecreatetruecolor($maxWidth, $newHeight);
                imagecopyresampled($resized, $source, 0, 0, 0, 0, $maxWidth, $newHeight, $width, $height);
                imagedestroy($source);
                $source = $resized;
            }

            if ($ext === 'png') {
                imagealphablending($source, false);
                imagesavealpha($source, true);
            }

            imagewebp($source, $targetPath, 80);
            imagedestroy($source);

            if ($uid) {
                $HomeModel = $this->HomeModel;
                $old = $HomeModel->InformationUser($uid)['profile_picture'] ?? null;
                if ($old && file_exists($uploadDir . $old)) {
                    unlink($uploadDir . $old);
                }
            }

            return $fileName;
        } catch (\Exception $e) {
            if ($source) {
                imagedestroy($source);
            }
            return "Error processing image: " . $e->getMessage();
        }
    }
}
