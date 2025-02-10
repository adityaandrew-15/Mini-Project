<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        @if (!request()->is('admin-home'))
            <!-- Navbar hanya tampil di halaman selain admin-home -->
            <nav class="navbar navbar-expand-md navbar-light bg-secondary shadow-sm">

                <div class="container">

                    <a class="navbar-brand" href="{{ url('/home') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Navbar -->
                            <!-- Container wrapper -->
                            <div class="container-fluid">
                                <!-- Navbar brand -->

                                <!-- Collapsible wrapper -->
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <!-- Left links -->
                                    <ul class="navbar-nav me-auto d-flex flex-row mt-3 mt-lg-0">
                                        <li class="nav-item text-center mx-2 mx-lg-1">
                                            <a class="nav-link " aria-disabled="true"
                                                href="{{ route('dokter.index') }}">
                                                dokter
                                            </a>
                                        </li>
                                        <li class="nav-item text-center mx-2 mx-lg-1">
                                            <a class="nav-link " aria-disabled="true"
                                                href="{{ route('pasien.index') }}">
                                                pasien
                                            </a>
                                        </li>
                                        <li class="nav-item text-center mx-2 mx-lg-1">
                                            <a class="nav-link " aria-disabled="true"
                                                href="{{ route('rekam_medis.index') }}">
                                                rekam medis
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                                <!-- Collapsible wrapper -->
                            </div>
                            <!-- Container wrapper -->
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>

            </nav>
        @endif


        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
