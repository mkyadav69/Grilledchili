<div class="menu-sidebar__content js-scrollbar1">
    <nav class="navbar-sidebar">
        <ul class="list-unstyled navbar__list">

                <li class="{{ request()->is('/') ? 'active' : '' }} has-sub">
                    <a class="js-arrow" href="{{route('dashboard')}}">
                        <i class="fas  fa-home"></i>Dashboard</a>
                </li>

                <li class="{{ request()->is('show-trucks') ? 'active' : '' }} has-sub">
                    <a class="js-arrow" href="{{route('show_trucks')}}">
                        <i class="fas  fa-truck"></i>Trucks</a>
                </li>
          
                <li class="{{ request()->is('show-trucks-setting') ? 'active' : '' }} has-sub">
                    <a class="js-arrow" href="{{route('show_trucks_setting')}}">
                        <i class="fas fa-gear (alias)"></i>Trucks Setting</a>
                </li>
           
        </ul>
    </nav>
</div>
