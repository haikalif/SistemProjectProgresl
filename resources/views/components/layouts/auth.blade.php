<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Login' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    {{ $slot }}
</body>
</html>
