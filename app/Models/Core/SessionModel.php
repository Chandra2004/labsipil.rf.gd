<?php

namespace TheFramework\Models\Core;

use Exception;
use TheFramework\App\Database;
use TheFramework\App\Model;
use TheFramework\Helpers\Helper;

class SessionModel extends Model
{
    protected $table = 'sessions';
    protected $primaryKey = 'uid';

    // Relationship Methods
    public function Courses()
    {
        return $this->belongsTo(CourseModel::class, 'course_uid', 'uid');
    }

    public function Participants()
    {
        return $this->hasMany(ParticipantModel::class, 'session_uid', 'uid');
    }

    // Centralized check for course existence
    private function courseExists($courseUid)
    {
        return $this->query()->table('courses')->where('uid', '=', $courseUid)->first();
    }

    // Centralized check for session existence by code
    private function sessionExistsByCode($codeSession)
    {
        return $this->query()->where('code_session', '=', $codeSession)->first();
    }

    // Centralized check for session existence by name in a specific course
    private function sessionExistsByName($nameSession, $courseUid = null)
    {
        $query = $this->query()->where('name_session', '=', $nameSession);
        if ($courseUid) {
            $query->where('course_uid', '=', $courseUid);
        }
        return $query->first();
    }

    // Check for overlapping sessions within the same course
    private function checkSessionOverlap($courseUid, $startSession, $endSession, $excludeUid = null)
    {
        $query = $this->query()->table($this->table)
            ->where('course_uid', '=', $courseUid)
            ->whereRaw(
                '(start_session < ? AND end_session > ?)',
                [
                    $endSession,
                    $startSession
                ]
            );

        if ($excludeUid) {
            $query->where('uid', '!=', $excludeUid);
        }

        return $query->first();
    }

    // Create Session
    public function CreateSession($data)
    {
        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            // Check if course exists
            if (!$this->courseExists($data['course_uid'])) {
                return 'course_not_exists';
            }

            // Check for code duplication
            if ($this->sessionExistsByCode($data['code_session'])) {
                return 'code_exist';
            }

            // Check for name duplication within the course
            if ($this->sessionExistsByName($data['name_session'], $data['course_uid'])) {
                return 'name_exist';
            }

            // Check for session overlap
            if ($this->checkSessionOverlap($data['course_uid'], $data['start_session'], $data['end_session'])) {
                return 'time_conflict';
            }

            // Insert new session
            $createSession = $this->query()->table($this->table)->insert($data);

            $db->commit();
            return $createSession;
        } catch (Exception $e) {
            $db->rollback();
            throw $e;
        }

        return false;
    }

    // Update Session
    public function UpdateSession($data)
    {
        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            // Check if session exists
            $session = $this->query()->table($this->table)->where('uid', '=', $data['uid'])->first();
            if (!$session) {
                return 'session_not_exists';
            }

            // Check for code duplication (excluding the current session)
            if ($this->sessionExistsByCode($data['code_session']) && $session['code_session'] !== $data['code_session']) {
                return 'code_exist';
            }

            // Check for session overlap (excluding the current session)
            if ($this->checkSessionOverlap($data['course_uid'], $data['start_session'], $data['end_session'], $data['uid'])) {
                return 'time_conflict';
            }

            // Update the session
            $updateSession = $this->query()->table($this->table)->where('uid', '=', $data['uid'])->update($data);

            $db->commit();
            return $updateSession;
        } catch (Exception $e) {
            $db->rollback();
            throw $e;
        }

        return false;
    }

    // Delete Session
    public function DeleteSession($data)
    {
        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            // Delete the session
            $deleteSession = $this->query()->table($this->table)->where('uid', '=', $data['uid'])->where('name_session', '=', $data['name_session'])->delete();

            $db->commit();
            return $deleteSession;
        } catch (Exception $e) {
            $db->rollback();
            throw $e;
        }

        return false;
    }
}