<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction Escrow System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="display: flex; flex-direction: column; min-height: 100vh; margin: 0; background: #f8fafc; font-family: 'Inter', sans-serif;">

    @include('partials.header')

    <main style="padding: 40px 20px; flex: 1; max-width: 1200px; margin: 0 auto; width: 100%; box-sizing: border-box;">
        @yield('content')
    </main>

    @include('partials.footer')

</body>
</html>
