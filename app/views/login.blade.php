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
                <input type="text" name="username" value="{{ $username or '' }}" />
                <input type="password" name="password" />
                <input type="submit" />
            {{ Form::close() }}
        @endif
    </body>
</html>