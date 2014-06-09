<?php

class NewsComment extends Eloquent {

    protected $table = 'news_comment';

    public function news()
    {
        return $this->belongsTo('News');
    }

}