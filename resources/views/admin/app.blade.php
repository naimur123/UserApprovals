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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.css">

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }



        .navbar {
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 1050;
            height: 60px;
        }

        .sidebar {
            min-width: 250px;
            max-width: 250px;
            transition: all 0.3s;
            height: 100vh;
            position: fixed;
            top: 60px;
            left: 0;
            z-index: 1040;
            padding-top: 60px;
        }

        .sidebar.collapsed {
            left: -250px;
        }

        .toggle-sidebar-btn {
            background: none;
            border: none;
            color: rgb(44, 41, 41);
            font-size: 1.5rem;
            cursor: pointer;
            position: absolute;
            top: 20px;
            z-index: 1050;
        }


        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -250px;
                top: 0;
                height: 100%;
                z-index: 1000;
            }

            .sidebar.collapsed {
                left: 0;
            }

            .flex-grow-1 {
                margin-top: 56px;
            }

            .navbar{
                height: 60px;
                width: 100%;
            }

            .toggle-sidebar-btn {
                top: 8px;
            }


        }

        @media (min-width: 769px) {
            .flex-grow-1 {
                padding: 20px;
                margin-left: 250px;
                transition: margin-left 0.3s;
            }

            .sidebar.collapsed ~ .flex-grow-1 {
                margin-left: 0;
            }

            .toggle-sidebar-btn {
                top: 8px;
                margin-left: 245px;
            }

            .sidebar {
                top: 0;
            }

            .navbar{
                height: 60px;
                width: 100%;
            }



        }


        .toast {
            font-weight: bold;
            font-size: 15px;
        }
        .nav-link{
            text-decoration: none;
            color: black;
        }

        .nav-item .nav-link {
            height: 50px;
            width: 100%;
            padding: 0 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 15px;
            position: relative;
            transition: background-color 0.3s ease;
        }

        .nav-item .nav-link i:first-child {
            margin-right: 10px;
            min-width: 20px;
        }

        .nav-item .nav-link i.fas.fa-chevron-down {
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        .nav-item .nav-link[aria-expanded="true"] i.fas.fa-chevron-down {
            transform: rotate(180deg);
        }

        .nav-item .nav-link:not([data-bs-toggle="collapse"]) i:first-child {
            margin-right: 10px;
            min-width: 20px;
        }

        .nav-item .nav-link:not([data-bs-toggle="collapse"]) {
            justify-content: flex-start;
        }

        .nav-item .nav-link.active {
            background-color: rgba(190, 240, 231, 0.4);
            border-left: 4px solid rgb(214, 238, 234);
        }

        .collapse .nav-link {
            padding-left: 60px;
            font-weight: 30px;
        }

        .nav-item {
            border-bottom: 1px solid #ccc;
        }

        .nav-item .nav-link:hover {
            background-color: #f3eeee;
            color: black;
        }

        .nav-item .nav-link:hover i {
            color: black;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
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
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @if(Auth::user())
        <div class="col-md-2">
            <button class="toggle-sidebar-btn" id="toggleSidebar"><i class="fas fa-bars"></i></button>
            <div class="sidebar border-right" style="background-color: #f9f9f9">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="#fundsCollapse" data-bs-toggle="collapse" aria-expanded="false" aria-controls="fundsCollapse">
                            <i class="fas fa-wallet"></i>
                            Users
                            <i class="fas fa-chevron-down"></i>
                        </a>
                        <div class="collapse" id="fundsCollapse">
                            <a class="nav-link" href="#">All Users</a>
                            <a class="nav-link" href="">Pending Users</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="#">
                            <i class="fas fa-cog"></i>
                            Settings
                        </a>
                    </li>
                  
                </ul>
            </div>
        </div>
        @endif

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- jQuery-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="module">
        $(document).ready(function() {
            $('#toggleSidebar').click(function() {
                $('.sidebar').toggleClass('collapsed');
                $('#mainContent').toggleClass('expanded');
            });
        });
    </script>
</body>
</html>
