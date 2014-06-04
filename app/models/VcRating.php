<?php

class VcRating extends Eloquent {

    protected $table = 'vc_rating';

    public function getTableName()
    {
        return $this->table;
    }

}