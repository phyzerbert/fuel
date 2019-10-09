<nav class="navbar-custom-menu navbar navbar-expand-lg m-0">
        <div class="sidebar-toggle-icon" id="sidebarCollapse">
            sidebar toggle<span></span>
        </div><!--/.sidebar toggle icon-->
        <div class="d-flex flex-grow-1">
            <ul class="navbar-nav flex-row align-items-center ml-auto">
                <li class="nav-item dropdown user-menu">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="typcn typcn-user-add-outline"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" >
                        <div class="dropdown-header d-sm-none">
                            <a href="#" class="header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                        </div>
                        <a href="{{ route('profile') }}" class="dropdown-item"><i class="typcn typcn-user-outline"></i> My Profile</a>
                        <a href="{{ route('logout') }}" class="dropdown-item"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" 
                        ><i class="typcn typcn-key-outline"></i> Sign Out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div><!--/.dropdown-menu -->
                </li>
            </ul><!--/.navbar nav-->
            <div class="nav-clock">
                <div class="time">
                    <span class="time-hours"></span>
                    <span class="time-min"></span>
                    <span class="time-sec"></span>
                </div>
            </div><!-- nav-clock -->
        </div>
    </nav>