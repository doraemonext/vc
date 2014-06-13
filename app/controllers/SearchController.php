<?php

class SearchController extends BaseController {

    public function __construct()
    {
        View::composer(array(
            'front.search',
        ), function($view)
        {
            if (Sentry::check()) {
                $view->with('user', Sentry::getUser());
            }
            $view->with('config_upload', Config::get('upload'));
            $view->with('action_name', explode('@', Route::getCurrentRoute()->getActionName()));
            $view->with('setting', Setting::getSetting());
        });
    }

    public function showSearch()
    {
        $input = Input::only('q', 'type', 'page');
        $data = array();

        if ($input['q'] != addslashes(strip_tags($input['q'])) || $input['type'] != addslashes(strip_tags($input['type']))) {
            Session::flash('status', 'error');
            Session::flash('message', '您的搜索指令中含有非法字符');
            return Redirect::route('home');
        }
        $input['q'] = addslashes(strip_tags($input['q']));
        $input['type'] = addslashes(strip_tags($input['type']));
        $input['page'] = intval($input['page']);

        if (empty($input['q'])) {
            Session::flash('status', 'error');
            Session::flash('message', '您的搜索指令有误');
            return Redirect::route('home');
        }

        if ($input['type'] === 'vc') {
            $result = $this->getSearch($input['q'], 'vc');
        } elseif ($input['type'] === 'showcase') {
            $result = $this->getSearch($input['q'], 'showcase');
        } elseif ($input['type'] === 'news') {
            $result = $this->getSearch($input['q'], 'news');
        } elseif ($input['type'] === '') {
            $result = $this->getSearchAll($input['q']);
        } else {
            Session::flash('status', 'error');
            Session::flash('message', '您的搜索指令有误');
            return Redirect::route('home');
        }

        $data['q'] = $input['q'];
        $data['type'] = $input['type'];

        // 进行搜索结果分页
        $perPage = 10;
        $currentPage = $input['page'] - 1;
        $pagedData = array_slice($result, $currentPage * $perPage, $perPage);
        $data['paginator'] = Paginator::make($pagedData, count($result), $perPage);

        return View::make('front.search', $data);
    }

    protected function getSearch($q, $type)
    {
        if ($type == 'vc') {
            $data = Vc::where('name', 'LIKE', '%'.$q.'%')->orderBy('datetime', 'DESC')->get();
        } elseif ($type == 'showcase') {
            $data = Showcase::where('name', 'LIKE', '%'.$q.'%')->orderBy('datetime', 'DESC')->get();
        } elseif ($type == 'news') {
            $data = News::where('title', 'LIKE', '%'.$q.'%')->orderBy('datetime', 'DESC')->get();
        }
        $total = $data->count();

        $result = array();
        $i = 0;
        for ($i = 0; $i < $total; $i++) {
            array_push($result, $data[$i]->toArray());
            if ($type == 'vc') {
                $result[count($result)-1]['type'] = 'vc';
            } elseif ($type == 'showcase') {
                $result[count($result)-1]['type'] = 'showcase';
            } elseif ($type == 'news') {
                $result[count($result)-1]['type'] = 'news';
            }
        }

        return $result;
    }

    protected function getSearchAll($q)
    {
        $data = array();
        $data[0] = Vc::where('name', 'LIKE', '%'.$q.'%')->orderBy('datetime', 'DESC')->get();
        $data[1] = Showcase::where('name', 'LIKE', '%'.$q.'%')->orderBy('datetime', 'DESC')->get();
        $data[2] = News::where('title', 'LIKE', '%'.$q.'%')->orderBy('datetime', 'DESC')->get();
        $total = $data[0]->count() + $data[1]->count() + $data[2]->count();

        $result = array();
        $i = 0;
        $data_step = array(0, 0, 0);
        while ($i < $total) {
            $max_datetime = strtotime('1900-01-01 00:00:00');
            $max_pos = 0;

            for ($j = 0; $j < 3; $j++) {
                if ($data_step[$j] >= $data[$j]->count()) {
                    continue;
                }

                if (strtotime($data[$j][$data_step[$j]]->datetime) > $max_datetime) {
                    $max_datetime = strtotime($data[$j][$data_step[$j]]->datetime);
                    $max_pos = $j;
                }
            }

            array_push($result, $data[$max_pos][$data_step[$max_pos]]->toArray());
            if ($max_pos == 0) {
                $result[count($result)-1]['type'] = 'vc';
            } elseif ($max_pos == 1) {
                $result[count($result)-1]['type'] = 'showcase';
            } elseif ($max_pos == 2) {
                $result[count($result)-1]['type'] = 'news';
            }
            $data_step[$max_pos]++;
            $i++;
        }

        return $result;
    }

}
