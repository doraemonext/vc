<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminVcController extends BaseController {

    public function __construct() {
        View::composer(array('admin.vc'), function($view)
        {
            $view->with('user', Sentry::getUser());
        });
    }

    public function showVc()
    {
        $paginateNumber = 10;
        $input = Input::only('search', 'order_by', 'order');

        // 对排序关键字及顺序进行错误处理
        if (!is_null($input['search'])) {
            $input['search'] = addslashes($input['search']);
        }
        if (!is_null($input['order_by']) && $input['order_by'] !== 'datetime' && $input['order_by'] !== 'rating') {
            $input['order_by'] = 'datetime';
        }
        if (!is_null($input['order']) && $input['order'] !== 'positive' && $input['order'] !== 'negative') {
            $input['order'] = 'negative';
        }
        $input['order_by'] = is_null($input['order_by']) ? 'datetime' : $input['order_by'];
        $input['order'] = is_null($input['order']) ? 'negative' : $input['order'];

        // 在数据库中进行查询
        if (is_null($input['search'])) {
            if ($input['order'] === 'negative') {
                $vcs = Vc::orderBy($input['order_by'], 'DESC')->paginate($paginateNumber);
            } else {
                $vcs = Vc::orderBy($input['order_by'])->paginate($paginateNumber);
            }
        } else {
            if ($input['order'] === 'negative') {
                $vcs = Vc::where('name', 'LIKE', '%'.$input['search'].'%')->orderBy($input['order_by'], 'DESC')->paginate($paginateNumber);
            } else {
                $vcs = Vc::where('name', 'LIKE', '%'.$input['search'].'%')->orderBy($input['order_by'])->paginate($paginateNumber);
            }
        }

        return View::make('admin.vc')->with('input', $input)->with('vcs', $vcs);
    }

    public function ajaxDeleteVc($id = null)
    {
        $id = intval($id);

        try {
            $vc = Vc::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return Response::json(array(
                'code' => 1000,
                'message' => '您提供的ID无效',
            ));
        }

        $vc->delete();
        Session::flash('status', 'success');
        Session::flash('message', '您已成功删除该条VC记录');

        return Response::json(array(
            'code' => 0,
        ));
    }

}
