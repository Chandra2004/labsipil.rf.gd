<?php
    namespace TheFramework\Models;

    use TheFramework\App\CacheManager;
    use TheFramework\App\Database;
    use TheFramework\App\Config;
    use TheFramework\App\Logging;
    use Defuse\Crypto\Crypto;
    use Defuse\Crypto\Key;
    use Exception;
use TheFramework\Helpers\Helper;

    class HomeModel extends Database {
        private $db;


        public function __construct() {
            $this->db = Database::getInstance();
        }

        public function StatusDatabase() {
            try {
                Database::getInstance();
                return 'success';
            } catch (Exception $e) {
                echo "Gagal konek DB: " . $e->getMessage();
            }            
        }

        public function GetUserData() {
            $this->db->query("
                SELECT * FROM users
            ");
            return $this->db->resultSet();
        }

        public function CreateUser($name, $email, $profilePicture) {
            $this->db->query("
                INSERT INTO users (uid, name, email, profile_picture)
                VALUES (:uid, :name, :email, :profile_picture)
            ");

            $this->db->bind(':uid', Helper::generateUUID(10));
            $this->db->bind(':name', $name);
            $this->db->bind(':email', $email);
            $this->db->bind(':profile_picture', $profilePicture);

            return $this->db->execute();
        }

        public function UpdateUser($uid, $name, $email, $profilePicture = null) {
            $query = "
                UPDATE users SET name = :name, email = :email, profile_picture = :profile_picture,
                updated_at = CURRENT_TIMESTAMP WHERE uid = :uid
            ";
            $this->db->query($query);
            $this->db->bind(':name', $name);
            $this->db->bind(':email', $email);
            $this->db->bind(':profile_picture', $profilePicture);
            $this->db->bind(':uid', $uid);
            return $this->db->execute();
        }        

        public function DeleteUser($uid) {
            $this->db->query("
                SELECT COUNT(*) as count FROM users 
                WHERE uid = :uid
            ");
            $this->db->bind(':uid', $uid);
            $result = $this->db->single();
        
            if (!$result || $result['count'] === 0) {
                return 'id_not_match';
            }
        
            $this->db->query("
                DELETE FROM users WHERE uid = :uid
            ");
            $this->db->bind(':uid', $uid);
            return $this->db->execute();
        }

        public function InformationUser($uid) {
            $this->db->query("
                SELECT * FROM users WHERE uid = :uid
            ");
            $this->db->bind('uid', $uid);
            $data = $this->db->single();
            return $data;
        }
    }
?>