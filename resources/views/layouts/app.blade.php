<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="bg-dark">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            @guest
                <a class="navbar-brand" href="{{ url('/login') }}">
                    {{ __('Makro') }}
                </a>
            @else
                <a class="navbar-brand" href="{{ route('auth.user.index') }}">
                    {{ Auth::user()->name }}
                </a>
            @endguest
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="languages">
                        <a style="margin-left: 10px;margin-right: 10px;"
                           href="{{route('change_locale', ['locale' => 'ru'])}}">RU</a>
                        <a style="margin-left: 10px;margin-right: 10px;"
                           href="{{route('change_locale', ['locale' => 'uz'])}}">UZ</a>
                    </li>
                    <li class="pages">
                        <a style="margin-left: 10px;margin-right: 10px;" href="{{route('members')}}"
                           class="btn btn-primary">
                            @lang('main.members')</a>
                        @guest()
                            <a style="margin-left: 10px;margin-right: 10px;" href="{{route('login')}}"
                               class="btn btn-primary">@lang('main.login')</a>
                        @else
                            <form action="{{route('logout')}}" class="d-inline" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger">@lang('home.logout')</button>
                            </form>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
@yield('script')
@yield('style')
</html>
