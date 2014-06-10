<?php

class AdPosition extends Eloquent {

    protected $table = 'ad_position';

    public function ad()
    {
        return $this->hasMany('Ad');
    }

}