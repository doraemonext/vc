<!DOCTYPE html>
<html>
    <head>
	<meta charset="utf-8">
    </head>
    <body>
	<h2>账户激活</h2>

	<div>请点击下面的链接激活您的账户 <a href="{{ URL::route('active') }}?id={{ $id }}&code={{ $code }}">链接</a></div>
    </body>
</html>
