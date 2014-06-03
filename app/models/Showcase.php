<?php

class Showcase extends Eloquent {

    protected $table = 'showcase';

    public function category()
    {
        return $this->belongsTo('Category');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

}