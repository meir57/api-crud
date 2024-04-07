<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('app-name') App</title>
    <script src="{{ asset('js/auth.js') }}" type="module" defer></script>
    <script src="{{ asset('js/todo.js') }}" type="module" defer></script>
    <link href="{{ asset('css/todo.css') }}" rel="stylesheet" />
</head>
<body>
    @yield('todo')
</body>
</html>