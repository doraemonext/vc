<?php

class VcComment extends Eloquent {

    protected $table = 'vc_comment';

    public function vc()
    {
        return $this->belongsTo('Vc');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

}