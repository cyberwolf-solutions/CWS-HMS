<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu  mt-3"
    style="border-radius: 10px; background-color: #20262a;border-style:none;
margin-left:50px;margin-right:auto">

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('super-index') }}">
                        <i class="ri-dashboard-2-line"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('super-user1') }}">
                        <i class="ri-account-circle-line"></i> <span>User Management</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('super-role') }}">
                        <i class="ri-dashboard-2-line"></i> <span>Role Management</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('super-branch') }}">
                        <i class="ri-dashboard-2-line"></i> <span>Branch Management</span>
                    </a>
                </li>

                <!-- Gray line divider -->
                {{-- <hr style="border-color: gray;"> --}}

                <!-- Fixed Logout at Bottom -->
                <div style="position: absolute; bottom: 10px;">
                    {{-- <hr style="border-color: gray;" style="width: 100%" > --}}
                    <a class="dropdown-item" href="javascript:void();"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bx bx-power-off font-size-16 align-middle me-1"></i>
                        <span key="t-logout">@lang('translation.logout')</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
