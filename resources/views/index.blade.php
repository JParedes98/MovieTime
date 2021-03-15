<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Movie Time</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Movie Time app">
    <meta name="title" content="Movie Time">
    <meta name="author" content="Jose Paredes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('/logo.png') }}">

    <!-- STYLES -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <router-view></router-view>
    </div>

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/67ee180fdd.js"></script>
    <script src="{{ asset('/js/app.js') }}"></script>
</body>

</html>