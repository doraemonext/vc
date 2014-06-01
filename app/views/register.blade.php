<!DOCTYPE html>

<html>
    <head>
        <title>注册</title>
        <meta charset="utf-8">
    </head>

    <body>
        @if (Session::has('success'))
            <p>{{ Session::get('success') }}</p>
        @else
            <p>{{ Session::get('error') }}</p>
            {{ Form::open(array('action' => 'AccountController@submitRegister')) }}
                {{ Form::text('username', isset($username) ? $username : '') }}
                {{ Form::email('email', isset($email) ? $email : '') }}
                {{ Form::password('password') }}
                {{ Form::submit('注册') }}
            {{ Form::close() }}
        @endif
    </body>
</html>