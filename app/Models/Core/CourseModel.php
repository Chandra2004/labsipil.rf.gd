<?php

namespace TheFramework\Models\Core;

use Exception;
use TheFramework\App\Database;
use TheFramework\App\Model;

class CourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'uid';

    public function Sessions()
    {
        return $this->hasMany(SessionModel::class, 'course_uid', 'uid');
    }

    public function Modules()
    {
        return $this->hasMany(ModuleModel::class, 'course_uid', 'uid');
    }

    private function courseExists($field, $value, $excludeUid = null)
    {
        $query = $this->query()->where($field, '=', $value);
        if ($excludeUid) $query->where('uid', '!=', $excludeUid);
        return $query->first();
    }

    public function CreateCourse($data)
    {
        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            if ($this->courseExists('code_course', $data['code_course'])) return 'code_exist';
            if ($this->courseExists('name_course', $data['name_course'])) return 'name_exist';

            $createCourse = $this->query()->table($this->table)->insert($data);

            $db->commit();
            return $createCourse;
        } catch (Exception $e) {
            $db->rollback();
            throw $e;
        }
        return false;
    }

    public function UpdateCourse($uid, $data)
    {
        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            if ($this->courseExists('code_course', $data['code_course'], $uid)) return 'code_exist';
            if ($this->courseExists('name_course', $data['name_course'], $uid)) return 'name_exist';

            $updateCourse = $this->query()
                ->table($this->table)
                ->where('uid', '=', $uid)
                ->update($data);

            $db->commit();
            return $updateCourse;
        } catch (Exception $e) {
            $db->rollback();
            throw $e;
        }
        return false;
    }

    public function DeleteCourse($data)
    {
        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            $deleteCourse = $this->query()
                ->table($this->table)
                ->where('uid', '=', $data['uid'])
                ->where('name_course', '=', $data['name_course'])
                ->delete();

            $db->commit();
            return $deleteCourse;
        } catch (Exception $e) {
            $db->rollback();
            throw $e;
        }
        return false;
    }
}