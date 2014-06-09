<?php

class ShowcaseComment extends Eloquent {

    protected $table = 'showcase_comment';

    public function showcase()
    {
        return $this->belongsTo('Showcase');
    }

}