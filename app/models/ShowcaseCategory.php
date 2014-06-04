<?php

class ShowcaseCategory extends Eloquent {

    protected $table = 'showcase_category';

    public function showcases()
    {
        return $this->hasMany('Showcase');
    }

}