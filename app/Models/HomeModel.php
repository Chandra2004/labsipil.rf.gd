<?php

namespace TheFramework\Models;

use Exception;
use TheFramework\App\Database;
use TheFramework\App\QueryBuilder;
use TheFramework\App\Model;

class HomeModel extends Model
{
    private $database;
    protected $table = 'users';
    protected $primaryKey = 'uid';

    public function Status()
    {
        $this->database = Database::getInstance();
        return $this->database ? 'success' : 'failed';
    }

    public function GetAllUsers()
    {
        return $this->query()
            ->table($this->table)
            ->orderBy('updated_at', 'DESC')
            ->get();
    }

    public function InformationUser($uid)
    {
        return $this->find($uid);
    }

    public function CreateUser($data)
    {
        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            // cek nama
            $exists = $this->query()
                ->table($this->table)
                ->where('name', '=', $data['name'])
                ->first();

            if ($exists) {
                return 'name_exist';
            }

            // cek email
            $exists = $this->query()
                ->table($this->table)
                ->where('email', '=', $data['email'])
                ->first();

            if ($exists) {
                return 'email_exist';
            }

            // insert
            $insertUser = $this->query()
                ->table($this->table)
                ->insert($data);

            $db->commit();
            return $insertUser;
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public function UpdateUser($data, $uid)
    {
        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            $exists = $this->query()
                ->table($this->table)
                ->where('uid', '=', $uid)
                ->first();

            if (!$exists) {
                $db->rollBack();
                return 'not_found';
            }

            $updateUser = $this->query()
                ->table($this->table)
                ->where('uid', '=', $uid)
                ->update($data);

            if (!$updateUser) {
                $db->rollBack();
                return false;
            }

            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public function DeleteUser($uid)
    {
        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            $deleteUser = $this->delete($uid);

            $db->commit();
            return $deleteUser;
        } catch (Exception $e) {
            $db->rollBack();
            return $e;
        }
    }
}
