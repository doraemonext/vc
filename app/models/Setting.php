<?php

class Setting extends Eloquent {

    protected $table = 'settings';

    public static function getSetting()
    {
        $setting = Setting::all();
        $result = array();
        foreach ($setting as $s) {
            $result[$s->title] = $s->value;
        }
        return $result;
    }

}