<?php

class News extends Eloquent {

    protected $table = 'news';

    public function category()
    {
        return $this->belongsTo('NewsCategory', 'category_id');
    }

}