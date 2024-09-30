<body>
    <div class="row">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color:#f9f9f9;">
            <!-- Application Name -->
            <h5 id="application_name">UserRegistration</h5>

            <!-- Navbar content (This will remain visible without collapsing) -->
            <div class="navbar-nav ms-auto">
                <!-- Profile Dropdown Trigger (Image) -->
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('storage/' . Auth::user()->image) }}" class="rounded-circle" alt="Profile Image"
                            style="height: 40px; width: 40px;">
                    </a>

                    <!-- Dropdown Menu -->
                    <div class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="navbarDropdown" style="min-width: 250px;">
                        <!-- Profile Picture and Name -->
                        <div class="text-center">
                            <img src="{{ asset('storage/' . Auth::user()->image) }}" class="rounded-circle mb-2" alt="Profile Image"
                                style="height: 80px; width: 80px;">
                            <h6 class="mb-1">{{ get_user_name() }}</h6>
                        </div>

                        <!-- Divider -->
                        <hr class="dropdown-divider">

                        <!-- Profile Links -->
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('edit_user', current_user()) }}">
                            <span class="me-2" style="min-width: 20px;">
                                <i class="fa-solid fa-user-pen"></i>
                            </span>
                            Edit Profile
                        </a>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <span class="me-2" style="min-width: 20px;">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </span>
                            Logout
                        </a>
                    </div>
                </li>
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

                    <!-- Users -->
                    @if(is_admin())
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="#userCollapse" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('user_list') || request()->routeIs('user_pending_list') ? 'true' : 'false' }}" aria-controls="userCollapse">
                                <i class="fas fa-user"></i>
                                Users
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <div class="collapse {{ request()->routeIs('user_list') || request()->routeIs('user_register') || request()->routeIs('user_pending_list') ? 'show' : '' }}" id="userCollapse">
                                <a class="nav-link {{ request()->routeIs('user_list') || request()->routeIs('user_register') ? 'active' : '' }}" href="{{ route('user_list') }}">All Users</a>
                                {{-- <a class="nav-link {{ request()->routeIs('user_pending_list') && request()->request_list == 'pending' ? 'active' : '' }}" href="{{ route('user_pending_list', 'pending') }}">Pending Users</a>
                                <a class="nav-link {{ request()->routeIs('user_pending_list') && request()->request_list == 'rejected' ? 'active' : '' }}" href="{{ route('user_pending_list', 'rejected') }}">Rejected Users</a> --}}
                            </div>
                        </li>
                    @endif
                    
                    <!-- Company -->
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="#companyCollapse" data-bs-toggle="collapse"
                            aria-expanded="{{ request()->routeIs('company_list') || request()->routeIs('company_pending_list') || request()->routeIs('company_create') || request()->routeIs('company_details') ? 'true' : 'false' }}"
                            aria-controls="companyCollapse">
                            <i class="fa-solid fa-building"></i>
                            Company
                            <i class="fas fa-chevron-down"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('company_list') || request()->routeIs('company_pending_list') || request()->routeIs('company_create') || request()->routeIs('company_edit') || request()->routeIs('company_details') ? 'show' : '' }}"
                            id="companyCollapse">
                            <a class="nav-link {{ request()->routeIs('company_list') || request()->routeIs('company_create') || request()->routeIs('company_edit') || request()->routeIs('company_details') ? 'active' : '' }}" href="{{ route('company_list') }}">All Companies</a>
                            <a class="nav-link {{ request()->routeIs('company_pending_list') && request()->request_list == 'pending' ? 'active' : '' }}" href="{{ route('company_pending_list', 'pending') }}">Pending Companies</a>
                            <a class="nav-link {{ request()->routeIs('company_pending_list') && request()->request_list == 'rejected' ? 'active' : '' }}" href="{{ route('company_pending_list', 'rejected') }}">Rejected Companies</a>
                        </div>
                    </li>

                    <!-- Orders -->
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="#orderCollapse" data-bs-toggle="collapse"
                            aria-expanded="{{ request()->routeIs('order_list') || request()->routeIs('order_pending_list') || request()->routeIs('order_create') || request()->routeIs('order_details') ? 'true' : 'false' }}"
                            aria-controls="orderCollapse">
                            <i class="fa-solid fa-briefcase"></i>
                            Orders
                            <i class="fas fa-chevron-down"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('order_list') || request()->routeIs('order_pending_list') || request()->routeIs('order_create') || request()->routeIs('order_edit') || request()->routeIs('order_details') ? 'show' : '' }}"
                            id="orderCollapse">
                            <a class="nav-link {{ request()->routeIs('order_list') || request()->routeIs('order_create') || request()->routeIs('order_edit') || request()->routeIs('order_details') ? 'active' : '' }}" href="{{ route('order_list') }}">All Orders</a>
                            {{-- <a class="nav-link {{ request()->routeIs('order_pending_list') && request()->request_list == 'pending' ? 'active' : '' }}" href="{{ route('order_pending_list', 'pending') }}">Pending Orders</a>
                            <a class="nav-link {{ request()->routeIs('order_pending_list') && request()->request_list == 'rejected' ? 'active' : '' }}" href="{{ route('order_pending_list', 'rejected') }}">Rejected Orders</a> --}}
                        </div>
                    </li>

                    <!-- Customer -->
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center {{ request()->is('customer_list') || request()->is('customer_create') ? 'active' : '' }}" href="{{ route('customer_list') }}">
                           <i class="fa-solid fa-users"></i>
                            Customer
                        </a>
                    </li>

                     <!-- Others -->
                     <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="#othersCollapse" data-bs-toggle="collapse"
                            aria-expanded="{{ request()->routeIs('payment_type_list') || request()->routeIs('sales_type_list') || request()->routeIs('solution_list')  ? 'true' : 'false' }}"
                            aria-controls="othersCollapse">
                            <i class="fa-solid fa-circle-info"></i>
                            Others
                            <i class="fas fa-chevron-down"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('payment_type_list') || request()->routeIs('payment_type_create') || request()->routeIs('sales_type_list') || request()->routeIs('sales_type_create') || request()->routeIs('solution_list') || request()->routeIs('solution_create') || request()->routeIs('item_list') || request()->routeIs('item_create') ? 'show' : '' }}"
                            id="othersCollapse">
                            <a class="nav-link {{ request()->routeIs('payment_type_list') || request()->routeIs('payment_type_create') ? 'active' : '' }}" href="{{ route('payment_type_list') }}">Payment Types</a>
                            <a class="nav-link {{ request()->routeIs('sales_type_list') || request()->routeIs('sales_type_create') ? 'active' : '' }}" href="{{ route('sales_type_list') }}">Sales Types</a>
                            <a class="nav-link {{ request()->routeIs('solution_list') || request()->routeIs('solution_create') ? 'active' : '' }}" href="{{ route('solution_list') }}">Solutions</a>
                            <a class="nav-link {{ request()->routeIs('item_list') || request()->routeIs('item_create') ? 'active' : '' }}" href="{{ route('item_list') }}">Items</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-md-10" style="margin-top: 70px !important" id="mainContent">
            <div class="content">
        