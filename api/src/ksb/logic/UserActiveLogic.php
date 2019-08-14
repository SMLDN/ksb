<?php

namespace Ksb\Logic;

use Aloha\Utility\Time;
use Exception;
use Illuminate\Database\Capsule\Manager;
use Ksb\Model\User;
use Ksb\Model\UserActive;

class UserActiveLogic
{
    protected $db;

    /**
     * Construct
     *
     * @param AuthLogic $authLogic
     * @return void
     */
    public function __construct(Manager $db)
    {
        $this->db = $db;
    }

    /**
     * Kích hoạt tài khoản
     *
     * @param [type] $userId
     * @param [type] $activeToken
     * @return void
     */
    public function active($userId, $activeToken)
    {
        if ($userId == null || $activeToken == null) {
            return false;
        }

        $userActive = UserActive::find($userId);
        if ($userActive) {
            if ($userActive->activeToken == $activeToken && !Time::isTimeOver($userActive->tokenValidTime)) {
                $user = User::find($userId);
                if ($user) {
                    $this->db->getConnection()->beginTransaction();
                    try {
                        // kích hoạt thành công
                        $user->activeStatus = "1";
                        $user->save();
                        $userActive->delete();
                        $this->db->getConnection()->commit();
                        return true;
                    } catch (Exception $e) {
                        $this->db->getConnection()->rollback();
                        return false;
                    }
                }
            }
            // user không tồn tại này nọ
            $userActive->delete();
            return false;
        }
        // thông tin ảo
        return false;
    }
}
