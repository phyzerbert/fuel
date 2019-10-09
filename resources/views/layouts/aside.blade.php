@php
    $page = config('site.page');
    $role = Auth::user()->role->slug;
@endphp
<nav class="sidebar sidebar-bunker">
    <div class="sidebar-header">
        <a href="{{route('home')}}" class="logo mx-auto"><span>Fuel</span></a>
    </div><!--/.sidebar header-->
    <hr class="my-0 bg-success">
    <div class="profile-element d-flex align-items-center flex-shrink-0">
        <div class="avatar online">
            <img src="@if (Auth::user()->picture != ''){{asset(Auth::user()->picture)}} @else {{asset('images/avatar128.png')}} @endif" class="img-fluid rounded-circle" alt="">
        </div>
        <div class="profile-text">
            <h6 class="m-0">{{Auth::user()->name}}</h6>
            <span>{{Auth::user()->role->name}}</span>
        </div>
    </div>
    <div class="sidebar-body">
        <nav class="sidebar-nav">
            <ul class="metismenu">
                <li class="@if($page == 'home') mm-active @endif"><a href="{{route('home')}}"><i class="fas fa-home mr-2"></i> Dashboard</a></li>  
                @php
                    $fuel_items = ['unloading', 'filling'];
                @endphp
                <li class="@if(in_array($page, $fuel_items)) mm-active @endif">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="fas fa-gas-pump mr-2"></i>
                        Fuel Management
                    </a>
                    <ul class="nav-second-level">
                        <li class="@if($page == 'unloading') mm-active @endif"><a href="{{route('unloading.index')}}">Unloading</a></li>
                        <li class="@if($page == 'filling') mm-active @endif"><a href="{{route('filling.index')}}">Filling</a></li>
                    </ul>
                </li> 
                <li class="@if($page == 'tank') mm-active @endif"><a href="{{route('tank.index')}}"><i class="fas fa-box mr-2"></i> Tanks</a></li>
                <li class="@if($page == 'vehicle') mm-active @endif"><a href="{{route('vehicle.index')}}"><i class="fas fa-car mr-2"></i> Vichles</a></li>
                <li class="@if($page == 'user') mm-active @endif"><a href="{{route('users.index')}}"><i class="fas fa-user mr-2"></i> Users</a></li>
                <li class="@if($page == 'driver') mm-active @endif"><a href="{{route('driver.index')}}"><i class="fas fa-user mr-2"></i> Drivers</a></li>
                @php
                    $setting_items = ['fuel', 'vehicle_type', 'location', 'city'];
                @endphp
                <li class="@if(in_array($page, $setting_items)) mm-active @endif">
                    <a class="has-arrow material-ripple" href="#">
                        <i class="fas fa-cog mr-2"></i>
                        Settings
                    </a>
                    <ul class="nav-second-level">
                        <li class="@if($page == 'fuel') mm-active @endif"><a href="{{route('fuel.index')}}">Fuel</a></li>
                        <li class="@if($page == 'vehicle_type') mm-active @endif"><a href="{{route('vehicle_type.index')}}">Type Of Vehicle</a></li>
                        <li class="@if($page == 'location') mm-active @endif"><a href="{{route('location.index')}}">Location</a></li>
                        <li class="@if($page == 'city') mm-active @endif"><a href="{{route('city.index')}}">City</a></li>
                    </ul>
                </li>          
            </ul>
        </nav>
    </div>
</nav>