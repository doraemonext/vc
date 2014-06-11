<?php

class VcShowcase extends Eloquent {

    protected $table = 'vc_showcase';

    public function vc()
    {
        return $this->belongsTo('Vc');
    }

}