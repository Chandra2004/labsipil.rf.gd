<?php

namespace TheFramework\Models\Core;

use Exception;
use TheFramework\App\Database;
use TheFramework\App\Model;
use TheFramework\Helpers\Helper;

class ParticipantModel extends Model
{
    protected $table = 'participants';
    protected $primaryKey = 'uid';

    public function Sessions()
    {
        return $this
            ->belongsTo(SessionModel::class, 'session_uid', 'uid');
    }

    public function User()
    {
        return $this
            ->belongsTo(UserModel::class, 'user_uid', 'uid')
            ->select(['uid', 'full_name', 'phone_number', 'email']);
    }

    public function Koordinator()
    {
        return $this
            ->belongsTo(UserModel::class, 'koordinator_uid', 'uid')
            ->select(['uid', 'full_name', 'phone_number', 'email']);
    }

    public function Asisten()
    {
        return $this
            ->belongsTo(UserModel::class, 'asisten_uid', 'uid')
            ->select(['uid', 'full_name', 'phone_number', 'email']);
    }

    public function Pembimbing()
    {
        return $this
            ->belongsTo(UserModel::class, 'pembimbing_uid', 'uid')
            ->select(['uid', 'full_name', 'phone_number', 'email']);
    }

    public function CreateParticipant($data)
    {
        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            $existsUser = $this
                ->query()
                ->table('users')
                ->where('uid', '=', $data['user_uid'])
                ->first();

            if (!$existsUser) {
                return 'user_not_exist';
            }

            $existsCourse = $this
                ->query()
                ->table('courses')
                ->where('uid', '=', $data['course_uid'])
                ->first();

            if (!$existsCourse) {
                return 'course_not_exist';
            }

            $existsSession = $this
                ->query()
                ->table('sessions')
                ->where('uid', '=', $data['session_uid'])
                ->first();

            if (!$existsSession) {
                return 'session_not_exist';
            }

            if ($existsSession['close_session'] < Helper::updateAt()) {
                return 'session_close';
            }

            $exists = $this
                ->query()
                ->where('user_uid', '=', $data['user_uid'])
                ->where('course_uid', '=', $data['course_uid'])
                ->first();

            if (!empty($exists)) {
                return 'exists';
            }

            $joinCount = $this->query()
                ->table($this->table)
                ->where('course_uid', '=', $data['course_uid'])
                ->where('session_uid', '=', $data['session_uid'])
                ->count();

            if ($joinCount >= $existsSession['kuota_session']) {
                return 'quota_full';
            }

            $facultyUid = $existsUser['faculty_uid'];
            $studyUid = $existsUser['study_uid'];

            $roleAsisten = $this
                ->query()
                ->table('roles')
                ->where('role_name', '=', 'Asisten')
                ->first();

            $rolePembimbing = $this
                ->query()
                ->table('roles')
                ->where('role_name', '=', 'Pembimbing')
                ->first();

            $asistens = $this
                ->query()
                ->table('users')
                ->where('faculty_uid', '=', $facultyUid)
                ->where('study_uid', '=', $studyUid)
                ->where('role_uid', '=', $roleAsisten['uid'])
                ->get();

            if (empty($asistens)) {
                return 'no_asisten_available';
            }

            $asistenLoad = [];
            foreach ($asistens as $a) {
                $count = $this
                    ->query()
                    ->table('participants')
                    ->where('asisten_uid', '=', $a['uid'])
                    ->count();

                $asistenLoad[$a['uid']] = $count;
            }
            $asistenUid = array_keys($asistenLoad, min($asistenLoad))[0];

            $pembimbings = $this
                ->query()
                ->table('users')
                ->where('faculty_uid', '=', $facultyUid)
                ->where('study_uid', '=', $studyUid)
                ->where('role_uid', '=', $rolePembimbing['uid'])
                ->get();

            if (empty($pembimbings)) {
                return 'no_pembimbing_available';
            }

            $pembimbingLoad = [];
            foreach ($pembimbings as $p) {
                $count = $this
                    ->query()
                    ->table('participants')
                    ->where('pembimbing_uid', '=', $p['uid'])
                    ->count();

                $pembimbingLoad[$p['uid']] = $count;
            }
            $pembimbingUid = array_keys($pembimbingLoad, min($pembimbingLoad))[0];

            $dataParticipant = [
                'uid' => $data['uid'],
                'user_uid' => $existsUser['uid'],
                'course_uid' => $existsCourse['uid'],
                'session_uid' => $existsSession['uid'],
                'koordinator_uid' => $existsCourse['author_course'],
                'asisten_uid' => $asistenUid,
                'pembimbing_uid' => $pembimbingUid
            ];

            $createParticipant = $this
                ->query()
                ->table($this->table)
                ->insert($dataParticipant);

            $db->commit();
            return $createParticipant;
        } catch (Exception $e) {
            $db->rollback();
            throw $e;
        }

        return false;
    }

    public function UpdateParticipant($data)
    {
        $db = Database::getInstance();

        try {
            $db->beginTransaction();

            $existsUid = $this
                ->query()
                ->where('uid', '=', $data['uid'])
                ->first();

            if (!$existsUid) return 'user_not_exist';

            // pastikan user valid
            // $existsUser = $this->query()->table('users')->where('uid', '=', $data['user_uid'])->first();
            // if (!$existsUser) return 'user_not_exist';

            // // pastikan pembimbing & asisten valid
            // $existsPembimbing = $this->query()->table('users')->where('uid', '=', $data['pembimbing_uid'])->first();
            // if (!$existsPembimbing) return 'pembimbing_not_exist';

            // $existsAsisten = $this->query()->table('users')->where('uid', '=', $data['asisten_uid'])->first();
            // if (!$existsAsisten) return 'asisten_not_exist';

            // // hanya kolom valid
            // $updateData = [
            //     'asisten_uid' => $data['asisten_uid'],
            //     'pembimbing_uid' => $data['pembimbing_uid'],
            //     'status' => $data['status'],
            // ];

            $updateParticipant = $this
                ->query()
                ->where('uid', '=', $data['uid'])
                ->update($data);

            if ($updateParticipant === 0) {
                $db->rollback();
                return false;
            }

            $db->commit();
            return $updateParticipant;
        } catch (Exception $e) {
            $db->rollback();
            throw $e;
        }
    }



    public function DeleteParticipant($data)
    {
        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            $exists = $this
                ->query()
                ->table('users')
                ->where('uid', '=', $data['user_uid'] ?? null)
                ->first();

            if (!$exists) {
                return 'user_not_exist';
            }

            $exists = $this
                ->query()
                ->table('courses')
                ->where('uid', '=', $data['course_uid'])
                ->first();

            if (!$exists) {
                return 'course_not_exist';
            }

            $exists = $this
                ->query()
                ->table('sessions')
                ->where('uid', '=', $data['session_uid'])
                ->first();

            if (!$exists) {
                return 'session_not_exist';
            }

            $exists = $this
                ->query()
                ->where('user_uid', '=', $data['user_uid'])
                ->where('course_uid', '=', $data['course_uid'])
                ->where('session_uid', '=', $data['session_uid'])
                ->first();

            if (empty($exists)) {
                return 'user_not_registered';
            }

            $deleteParticipant = $this
                ->query()
                ->table($this->table)
                ->where('uid', '=', $data['uid'])
                ->where('user_uid', '=', $data['user_uid'])
                ->delete();

            $db->commit();
            return $deleteParticipant;
        } catch (Exception $e) {
            $db->rollback();
            throw $e;
        }

        return false;
    }
}
