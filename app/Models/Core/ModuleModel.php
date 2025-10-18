<?php
namespace TheFramework\Models\Core;

use Exception;
use TheFramework\App\Database;
use TheFramework\App\Model;

class ModuleModel extends Model
{
    protected $table = 'modules';
    protected $primaryKey = 'uid';

    public function Courses()
    {
        return $this->belongsTo(CourseModel::class, 'course_uid', 'uid');
    }

    public function CreateModule(array $data)
    {
        return $this->withTransaction(function() use ($data) {
            if ($this->existsModule($data['course_uid'], 'code_module', $data['code_module']))
                return 'code_exist';
            if ($this->existsModule($data['course_uid'], 'name_module', $data['name_module']))
                return 'name_exist';

            $latest = $this->query()
                ->where('course_uid', '=', $data['course_uid'])
                ->orderBy('created_at', 'DESC')
                ->first();

            if ($latest && $latest['date_module'] >= $data['date_module'])
                return 'time_exist';

            return $this->query()->table($this->table)->insert($data);
        });
    }

    public function UpdateModule(array $data)
    {
        return $this->withTransaction(function() use ($data) {
            $module = $this->findByUid($data['uid']);
            if (!$module) return 'module_not_exists';

            if ($this->existsOtherModule($data['uid'], 'code_module', $data['code_module']))
                return 'code_exist';
            if ($this->existsOtherModule($data['uid'], 'name_module', $data['name_module']))
                return 'name_exist';

            return $this->query()
                ->table($this->table)
                ->where('uid', '=', $data['uid'])
                ->update($data);
        });
    }

    public function DeleteModule(array $data)
    {
        return $this->withTransaction(function() use ($data) {
            return $this->query()
                ->table($this->table)
                ->where('uid', '=', $data['uid'])
                ->where('name_module', '=', $data['name_module'])
                ->delete();
        });
    }

    private function findByUid($uid)
    {
        return $this->query()->table($this->table)->where('uid', '=', $uid)->first();
    }

    private function existsModule($courseUid, $field, $value)
    {
        return $this->query()
            ->where('course_uid', '=', $courseUid)
            ->where($field, '=', $value)
            ->first();
    }

    private function existsOtherModule($uid, $field, $value)
    {
        return $this->query()
            ->where($field, '=', $value)
            ->where('uid', '!=', $uid)
            ->first();
    }

    private function withTransaction(callable $callback)
    {
        $db = Database::getInstance();
        try {
            $db->beginTransaction();
            $result = $callback();
            $db->commit();
            return $result;
        } catch (Exception $e) {
            $db->rollback();
            throw $e;
        }
    }
}
