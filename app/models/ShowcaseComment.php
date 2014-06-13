<?php

class ShowcaseComment extends Eloquent {

    protected $table = 'showcase_comment';

    public function showcase()
    {
        return $this->belongsTo('Showcase');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

}