<!DOCTYPE html>

<html>
    <head>
        <title>激活账户</title>
        <meta charset="utf-8">
    </head>

    <body>
        @if (isset($success))
            <p>{{ $success }}</p>
        @else
            <p>{{ $error }}</p>
        @endif
    </body>
</html>