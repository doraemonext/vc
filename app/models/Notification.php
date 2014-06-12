<?php

class Notification extends Eloquent {

    protected $table = 'notification';

    public function user()
    {
        return $this->belongsTo('User');
    }

    public static function getNotifications($id)
    {
        return Notification::where('user_id', '=', $id)->where('is_new', '=', 1)->orderBy('datetime', 'DESC')->get();
    }

    public static function insertNotification($user_id, $type, $content)
    {
        $notification = new Notification;
        $notification->user_id = $user_id;
        $notification->type = $type;
        $notification->is_new = 1;
        $notification->content = $content;
        $notification->datetime = date("Y-m-d H:i:s");
        $notification->save();
    }

}