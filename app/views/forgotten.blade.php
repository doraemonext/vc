<!DOCTYPE html>

<html>
    <head>
        <title>忘记密码</title>
        <meta charset="utf-8">
    </head>

    <body>
        @if (Session::has('success'))
            <p>{{ Session::get('success') }}</p>
        @else
            <p>{{ Session::get('error') }}</p>
            {{ Form::open(array('action' => 'AccountController@submitForgotten')) }}
                {{ Form::text('username', isset($username) ? $username : '') }}
                {{ Form::submit('提交') }}
            {{ Form::close() }}
        @endif
    </body>
</html>