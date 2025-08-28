<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name')}}</title>
        
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        @vite(entrypoints: 'resources/css/app.css')
    </head>

    <body class="flex flex-col h-screen max-w-7xl max-h-[1200px] mx-auto overflow-auto bg-gradient-to-l from-violet-200 to-stone-200 bg-cover bg-center">

        <x-header/>
        
        <main class="flex-grow">{{ $slot }}</main>

        <x-footer/>

    </body>
</html>
