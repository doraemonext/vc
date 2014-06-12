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

}