<?php

class Showcase extends Eloquent {

    protected $table = 'showcase';

    public function category()
    {
        return $this->belongsTo('ShowcaseCategory');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

}