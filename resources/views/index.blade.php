@php
    $config = [
        'appName' => config('app.name'),
        'locale' => $locale = app()->getLocale(),
        'locales' => config('app.locales'),
        'githubAuth' => config('services.github.client_id'),
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Learning Dashboard</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css">

    <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}">
</head>
<body>
<div id="app"></div>

<script>
    window.config = @json($config);
</script>

<script src="{{ mix('dist/js/app.js') }}"></script>
</body>
</html>
