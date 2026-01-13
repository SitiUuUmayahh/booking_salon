<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @hasSection('title')
        <title>@yield('title')</title>
    @else
        <title>Dsisi Salon</title>
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    @include('components.navbar')

    <div class="min-h-screen flex flex-col">
        <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 flex-1">
            @if(session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('status'))
                <div class="mb-4 rounded-md bg-blue-50 p-4 text-blue-700">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-md bg-red-50 p-4 text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        @include('components.footer')
    </div>

    @stack('scripts')
</body>
</html>
