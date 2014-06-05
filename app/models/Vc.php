<?php

class Vc extends Eloquent {

    protected $table = 'vc';

    public function ratings()
    {
        return $this->hasMany('VcRating', 'vc_id');
    }

}