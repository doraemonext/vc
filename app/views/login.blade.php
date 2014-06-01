<!DOCTYPE html>

<html>
    <head>
        <title>登陆</title>
        <meta charset="utf-8">
    </head>

    <body>
        @if (Session::has('success'))
            <p>{{ Session::get('success') }}</p>
        @else
            <p>{{ Session::get('error') }}</p>
            {{ Form::open(array('action' => 'AccountController@submitLogin')) }}
                {{ Form::text('username', isset($username) ? $username : '') }}
                {{ Form::password('password') }}
                @if (isset($remember) && $remember === 'on')
                    {{ Form::checkbox('remember', 'on', true) }}
                @else
                    {{ Form::checkbox('remember', 'on') }}
                @endif
                {{ Form::submit('登陆') }}
            {{ Form::close() }}
        @endif
    </body>
</html>