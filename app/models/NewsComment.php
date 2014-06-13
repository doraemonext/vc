<?php

class NewsComment extends Eloquent {

    protected $table = 'news_comment';

    public function news()
    {
        return $this->belongsTo('News');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

}