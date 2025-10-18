<?php

namespace TheFramework\Models\Core;

use Exception;
use TheFramework\App\Database;
use TheFramework\App\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'uid';

    public function AuthLogin($data)
    {
        $userLogin = $this->query()
            ->select(['users.*', 'roles.role_name AS role_name'])
            ->table($this->table)
            ->join('roles', 'users.role_uid', '=', 'roles.uid')
            ->where('email', '=', $data['identifier'])
            ->orWhere('student_staff_id', '=', $data['identifier'])
            ->first();

        if ($userLogin && $userLogin['status'] === '0') return 'status_failed';
        if ($userLogin && password_verify($data['password'], $userLogin['password'])) return $userLogin;
        return false;
    }

    private function checkIfExists($data, $excludeUid = null)
    {
        if (isset($data['student_staff_id'])) {
            $exists = $this->query()->where('student_staff_id', '=', $data['student_staff_id']);
            if ($excludeUid) $exists->where('uid', '!=', $excludeUid);
            if ($exists->first()) return 'npm_exist';
        }
    
        if (isset($data['phone_number'])) {
            $exists = $this->query()->where('phone_number', '=', $data['phone_number']);
            if ($excludeUid) $exists->where('uid', '!=', $excludeUid);
            if ($exists->first()) return 'phone_exist';
        }
    
        if (isset($data['email'])) {
            $exists = $this->query()->where('email', '=', $data['email']);
            if ($excludeUid) $exists->where('uid', '!=', $excludeUid);
            if ($exists->first()) return 'email_exist';
        }
    
        return null;
    }    

    public function CreateUser($data)
    {
        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            $exists = $this->checkIfExists($data);
            if ($exists) return $exists;

            $createUser = $this->query()->table($this->table)->insert($data);

            $db->commit();
            return $createUser;
        } catch (Exception $e) {
            $db->rollback();
            throw $e;
        }
    }

    public function UpdateUser($uid, $data)
    {
        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            $exists = $this->checkIfExists($data, $uid);
            if ($exists) return $exists;

            if (isset($data['faculty_uid'], $data['study_uid'])) {
                $faculty = $this->query()->table('faculties')->where('uid', '=', $data['faculty_uid'])->first();
                $study = $this->query()->table('program_studies')->where('uid', '=', $data['study_uid'])->first();
                if ($faculty['uid'] != $study['faculty_uid']) return 'dismatch';
            }

            $updateUser = $this->query()->table($this->table)->where('uid', '=', $uid)->update($data);

            $db->commit();
            return $updateUser;
        } catch (Exception $e) {
            $db->rollback();
            throw $e;
        }
    }
}
