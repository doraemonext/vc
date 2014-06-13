<?php

class Vote extends Eloquent {

    protected $table = 'vote';

    public function user()
    {
        return $this->belongsTo('User');
    }

    public static function insertVote($type, $object_id)
    {
        $user_id = Sentry::getUser()->getId();

        $user_latest = Vote::where('user_id', '=', $user_id)->where('type', '=', $type)->where('object_id', '=', $object_id)->orderBy('datetime', 'DESC')->take(1)->get();
        $ip_latest = Vote::where('author_ip', '=', Request::getClientIp())->where('type', '=', $type)->where('object_id', '=', $object_id)->orderBy('datetime', 'DESC')->take(1)->get();
        if ($user_latest->count() > 0 && strtotime($user_latest->first()->datetime) + 86400 > time()) {
            return false;
        }
        if ($ip_latest->count() > 0 && strtotime($ip_latest->first()->datetime) + 86400 > time()) {
            return false;
        }

        $vote = new Vote;
        $vote->user_id = $user_id;
        $vote->object_id = $object_id;
        $vote->type = $type;
        $vote->author_ip = Request::getClientIp();
        $vote->datetime = date("Y-m-d H:i:s");
        $vote->save();

        return true;
    }

}