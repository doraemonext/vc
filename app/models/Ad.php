<?php

class Ad extends Eloquent {

    protected $table = 'ad';

    public function position()
    {
        return $this->belongsTo('AdPosition');
    }

}