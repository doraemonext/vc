<?php

class Category extends Eloquent {

    protected $table = 'category';

    public function showcases()
    {
        return $this->hasMany('Showcase');
    }

}