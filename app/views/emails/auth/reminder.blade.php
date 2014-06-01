<!DOCTYPE html>
<html>
    <head>
	<meta charset="utf-8">
    </head>
    <body>
	<h2>重置您的密码</h2>

	<div>
            请点击下面的链接重置您的密码：<a href="{{ URL::route('forgotten_reset') }}?id={{ $id }}&code={{ $code }}">{{ URL::route('forgotten_reset') }}?id={{ $id }}&code={{ $code }}</a>
	</div>
    </body>
</html>
