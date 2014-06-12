<?php

class UserNotificationController extends BaseController {

    public function ajaxClear()
    {
        $id = intval(Input::get('id'));
        if ($id !== Sentry::getUser()->getId()) {
            return Response::json(array(
                'code' => 1001,
                'message' => '您没有删除该回复的权限',
            ));
        }

        $notification = Notification::where('user_id', '=', $id)->get();
        foreach ($notification as $n) {
            $n->is_new = 0;
            $n->save();
        }

        return Response::json(array(
            'code' => 0,
        ));
    }

}
