<body>
    <div class="row">
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color:#f9f9f9">
            <h5 id="application_name">UserRegistration</h5>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav" style="margin-left: 80%">
                    <!-- Profile image -->
                    <li class="nav-item" >
                        <img src="{{ asset('storage/' . Auth::user()->image) }}" class="rounded-circle" alt="Image"
                            style="height: 30px; width:30px">
                    </li>
                    <!-- Dropdown menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->full_name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="margin-left:20px !important">
                            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-2">
            <button class="toggle-sidebar-btn" id="toggleSidebar"><i class="fas fa-bars"></i></button>
            <div class="sidebar border-right" style="background-color: #f9f9f9">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center {{ request()->is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="#userCollapse" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('user_list') || request()->routeIs('user_pending_list') ? 'true' : 'false' }}" aria-controls="userCollapse">
                            <i class="fas fa-wallet"></i>
                            Users
                            <i class="fas fa-chevron-down"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('user_list') || request()->routeIs('user_pending_list') ? 'show' : '' }}" id="userCollapse">
                            <a class="nav-link {{ request()->routeIs('user_list') ? 'active' : '' }}" href="{{ route('user_list') }}">All Users</a>
                            <a class="nav-link {{ request()->routeIs('user_pending_list') && request()->request_list == 'pending' ? 'active' : '' }}" href="{{ route('user_pending_list', 'pending') }}">Pending Users</a>
                            <a class="nav-link {{ request()->routeIs('user_pending_list') && request()->request_list == 'rejected' ? 'active' : '' }}" href="{{ route('user_pending_list', 'rejected') }}">Rejected Users</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-md-10" style="margin-top: 70px !important" id="mainContent">
            <div class="content">
        