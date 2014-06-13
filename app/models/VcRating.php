<?php

class VcRating extends Eloquent {

    protected $table = 'vc_rating';

    public function getTableName()
    {
        return $this->table;
    }

    public function vc()
    {
        return $this->belongsTo('Vc');
    }

    public function category()
    {
        return $this->belongsTo('VcRatingCategory', 'vc_rating_category_id');
    }

}