<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('title','ERP System')</title>
</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

    @include('partials.sidebar')

    <div class="flex flex-col flex-1 overflow-hidden">

        @include('partials.navbar')
        @if(session('success'))

<div class="mb-4 mx-6 mt-4">

    <div class="bg-green-100 text-green-700 p-4 rounded">

        {{ session('success') }}

    </div>

</div>

@endif
        <main class="flex-1 overflow-y-auto p-6">

            @yield('content')

        </main>

        @include('partials.footer')

    </div>

</div>

</body>
</html>