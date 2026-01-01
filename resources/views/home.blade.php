<!DOCTYPE html>
<html>
<head>
    <title>Escrow System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="p-10">
    <h1 class="text-2xl font-bold">Transaction Escrow System</h1>

    @auth
        <a href="/dashboard">Dashboard</a>
    @else
        <a href="/login">Login</a>
        <a href="/register">Register</a>
    @endauth
</body>
</html>
