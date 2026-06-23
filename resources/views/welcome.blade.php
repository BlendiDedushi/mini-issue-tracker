<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Mini Issue Tracker') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 px-4">
            <div class="w-full sm:max-w-md px-8 py-10 bg-white shadow-md overflow-hidden sm:rounded-lg text-center">
                <h1 class="text-xl font-semibold text-gray-800 leading-tight">
                    {{ __('Mini Issue Tracker') }}
                </h1>
                <p class="mt-3 text-sm text-gray-600 leading-relaxed">
                    {{ __('Manage projects, issues, tags, and comments with your team.') }}
                </p>

                @guest
                    <div class="mt-8 flex flex-col items-center gap-3">
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center px-6 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Log in') }}
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center justify-center px-6 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Register') }}
                            </a>
                        @endif
                    </div>
                @else
                    <div class="mt-8">
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center justify-center px-6 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Go to Dashboard') }}
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </body>
</html>
