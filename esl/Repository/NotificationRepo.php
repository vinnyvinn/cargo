<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 2/11/18
 * Time: 4:01 AM
 */

namespace Esl\Repository;


use App\Notification;

class NotificationRepo
{
    public static function create()
    {
        return new self;
    }

    public function notification($title, $text, $link, $status = 0, $department_id = null, $user_id = null)
    {
        Notification::create([
            'title' => $title,
            'text' => $text,
            'link' => $link,
            'status' => $status,
            'department_id' => $department_id
        ]);

        return true;
    }

    public function success($message)
    {
        alert()->success($message,'Successful')->autoclose(5000);
        return $this;
    }

    public function warning($message)
    {
        alert()->warning($message,'Warning')->autoclose(5000);
        return $this;
    }
    public function error($message)
    {
        alert()->error($message,'Error')->autoclose(5000);
        return $this;
    }

    public function message($message, $title)
    {
        alert()->error($message,$title)->autoclose(5000);
        return $this;
    }
}