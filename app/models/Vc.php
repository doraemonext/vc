<?php

class Vc extends Eloquent {

    protected $table = 'vc';

    public function ratings()
    {
        return $this->hasMany('VcRating', 'vc_id');
    }

    public static function getRecommend()
    {
        return self::where('recommended', '=', 1)->get();
    }

    public static function getRecommendWithRating()
    {
        $vcs = self::where('recommended', '=', 1)->get();
        foreach ($vcs as $vc) {
            $vc->score = self::getRatingByVC($vc->id);
        }
        return $vcs;
    }

    public static function getListOrderByRating($paginateNumber = 0)
    {
        return self::orderBy('rating', 'DESC')->get();
    }

    public static function getListOrderByRatingWithRating($paginateNumber = 0)
    {
        $vcs = self::orderBy('rating', 'DESC')->get();
        foreach ($vcs as $vc) {
            $vc->score = self::getRatingByVC($vc->id);
        }
        return $vcs;
    }

    protected static function getRatingByVC($id)
    {
        $id = intval($id);
        $vc = self::findOrFail($id);

        $rating = $vc->ratings();
        $rating_category = VcRatingCategory::all();
        $score_result = array();
        $score_result[0] = 0.0;
        foreach ($rating_category as $category) {
            $total = DB::table($rating->getModel()->getTable())->where('vc_id', '=', $vc->id)->where('vc_rating_category_id', '=', $category->id)->sum('score');
            $count = DB::table($rating->getModel()->getTable())->where('vc_id', '=', $vc->id)->where('vc_rating_category_id', '=', $category->id)->count();
            if ($count > 0) {
                $score = $total / $count;
            } else {
                $score = 0.0;
            }
            $score_result[$category->id] = $score;
            $score_result[0] += $score;
        }
        $score_result[0] /= $rating_category->count();

        return $score_result;
    }

}