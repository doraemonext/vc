<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

    protected function getRatingByVC($id)
    {
        $id = intval($id);
        $vc = Vc::findOrFail($id);

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
