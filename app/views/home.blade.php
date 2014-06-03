@if (!Sentry::check())
<a href="{{ route('login') }}">登陆</a>
<a href="{{ route('register') }}">注册</a>
<a href="{{ route('forgotten') }}">忘记密码</a>
@else
<p>{{ Sentry::getUser()->username }}</p>
<a href="{{ route('logout') }}">注销</a>
@if (Sentry::getUser()->inGroup(Sentry::findGroupByName('admin')))
<a href="{{ route('admin.home') }}">管理</a>
@endif
@endif