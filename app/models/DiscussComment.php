<?php

class DiscussComment extends Eloquent {

    protected $table = 'discuss_comment';

    public function discuss()
    {
        return $this->belongsTo('Discuss');
    }

    public function user() {
        return $this->belongsTo('User');
    }

}