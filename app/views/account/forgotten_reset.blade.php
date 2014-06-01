<!DOCTYPE html>

<html>
    <head>
        <title>重置密码</title>
        <meta charset="utf-8">
    </head>

    <body>
        @if (isset($success))
            <p>{{ $success }}</p>
            {{ Form::open(array('action' => 'AccountController@submitForgottenReset')) }}
                {{ Form::hidden('id', $id) }}
                {{ Form::hidden('code', $code) }}
                {{ Form::password('password') }}
                {{ Form::password('confirm_password') }}
                {{ Form::submit('重置') }}
            {{ Form::close() }}
        @elseif (isset($error))
            <p>{{ $error }}</p>
        @endif

        @if (Session::has('success'))
            <p>{{ Session::get('success') }}</p>
        @elseif (Session::has('error'))
            <p>{{ Session::get('error') }}</p>
        @endif
    </body>
</html>