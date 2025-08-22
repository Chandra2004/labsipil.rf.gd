<?php

namespace TheFramework\Http\Controllers;

use Exception;
use TheFramework\App\View;
use TheFramework\Helpers\Helper;
use TheFramework\Models\HomeModel;

class HomeController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function Index() {
        $notification = Helper::get_flash('notification');
        return View::render('interface.welcome', [
            'notification' => $notification,
            'status' => $this->HomeModel->StatusDatabase(),

            'title' => 'THE FRAMEWORK - Modern PHP Framework with Database Migrations & REST API'
        ]);
    }
    
    public function Users() {
        $notification = Helper::get_flash('notification');
        return View::render('interface.users', [
            'notification' => $notification,
            'title' => 'THE FRAMEWORK - User Management',
            'userData' => $this->HomeModel->GetUserData()
    
        ]);
    }

    public function CreateUser() {
        if (Helper::is_post() && Helper::is_csrf()) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $profilePicture = $_FILES['profile_picture'];

            if (empty($name) || empty($email)) {
                return Helper::redirect('/users', 'warning', 'Name and Email cannot be empty.', 5000);
            }

            $result = $this->ProcessImage($profilePicture);

            $errorMessage = [
                'required_image' => 'Image is required.',
                'failed_upload' => 'Image upload failed.',
                'failed_extension' => 'File extension not supported.',
                'failed_size' => 'File size is too large. Maximum 2MB.',
                'failed_mime' => 'Invalid MIME type.',
                'failed_read' => 'Failed to read image',
            ];

            $status  = 'success';
            $message = 'Upload berhasil.';
            $file    = $result;

            if (array_key_exists($result, $errorMessage)) {
                $status  = 'error';
                $message = $errorMessage[$result];
                $file    = null;
            }

            try {
                if ($file != null) {
                    $this->HomeModel->CreateUser($name, $email, $file);
                    return Helper::redirect('/users', 'success', 'User created successfully.', 5000);
                } else {
                    return Helper::redirect('/users', 'error', 'Error: ' . $message, 5000);
                }
            } catch (Exception $e) {
                return Helper::redirect('/users', 'error', 'Error: ' . $e->getMessage(), 5000);
            }

        } else {
            return Helper::redirect('/users', 'warning', 'Invalid request method.', 5000);
        }
    }

    public function UpdateUser(string $uid) {
        if(Helper::is_post() && Helper::is_csrf()) {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $profilePicture = $_FILES['profile_picture'] ?? null;
            $deleteProfilePicture = isset($_POST['delete_profile_picture']);

            if (empty($name) || empty($email)) {
                return Helper::redirect('/users/information/' . $uid, 'error', 'Name and Email cannot be empty');
            }

            try {
                $user = $this->HomeModel->InformationUser($uid);
                if (!$user) {
                    return Helper::redirect('/users', 'error', 'User not found', 5000);
                }

                $fileName = $user['profile_picture'];
                if ($deleteProfilePicture && $fileName) {
                    $uploadDir = ROOT_DIR . '/private-uploads/user-pictures/';
                    $filePath = $uploadDir . $fileName;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    $fileName = null;
                }

                if ($profilePicture && $profilePicture['error'] === UPLOAD_ERR_OK) {
                    $fileName = $this->processImage($profilePicture, $uid);
                    if ($fileName instanceof Exception) {
                        return Helper::redirect('/users/information/' . $uid, 'error', $fileName->getMessage());
                    }
                }
    
                $this->HomeModel->UpdateUser($uid, $name, $email, $fileName);
                return Helper::redirect('/users/information/' . $uid, 'success', 'User ' . $user['name'] . ' updated successfully', 5000);
    
            } catch (Exception $e) {
                return Helper::redirect('/users/information/' . $uid, 'error', 'Error: ' . $e->getMessage(), 20000);
            }
        }
    }

    public function DeleteUser(string $uid) {
        if (Helper::is_post() && Helper::is_csrf()) {
            if (empty($uid)) {
                return Helper::redirect('/users/information/' . $uid, 'error', 'UID tidak valid', 5000);
            }
    
            try {
                $user = $this->HomeModel->InformationUser($uid);
                if (!$user) {
                    return Helper::redirect('/users', 'error', 'User not found', 5000);
                }
    
                $result = $this->HomeModel->DeleteUser($uid);
    
                if ($result === 'id_not_match') {
                    return Helper::redirect('/users/information/' . $uid, 'error', 'ID user not match', 5000);
                }
                if ($result === false) {
                    return Helper::redirect('/users/information/' . $uid, 'error', 'Failed delete user', 5000);
                }
    
                if (!empty($user['profile_picture'])) {
                    $filePath = ROOT_DIR . '/private-uploads/user-pictures/' . $user['profile_picture'];
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
    
                return Helper::redirect('/users', 'success', 'User ' . $user['name'] . ' Success delete user', 5000);
    
            } catch (Exception $e) {
                return Helper::redirect('/users/information/' . $uid, 'error', 'Error: ' . $e->getMessage(), 20000);
            }
        }
    }    

    public function InformationUser(string $uid) {
        $notification = Helper::get_flash('notification');

        $userDetail = $this->HomeModel->InformationUser($uid);
        if (!$userDetail) return Helper::redirectToNotFound();

        View::render('interface.detail', [
            'title' => $userDetail['name'] . ' | THE FRAMEWORK - User Management',
            'notification' => $notification,

            'userData' => $this->HomeModel->getUserData()['users'] ?? [],
            'user' => $userDetail,
        ]);
    }
}