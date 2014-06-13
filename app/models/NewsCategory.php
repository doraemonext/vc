<?php

class NewsCategory extends Eloquent {

    protected $table = 'news_category';

    public function news()
    {
        return $this->hasMany('News', 'category_id');
    }

}