<?php

class Discuss extends Eloquent {

    protected $table = 'discuss';

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function comments()
    {
        return $this->hasMany('DiscussComment');
    }

    public static function getRecommend()
    {
        return self::where('recommended', '=', 1)->get();
    }

}