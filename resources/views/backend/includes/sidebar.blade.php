<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                @lang('menus.backend.sidebar.general')
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/dashboard')) }}" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon icon-speedometer"></i> @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>
            @if(Auth()->user()->roles->first()->name === 'administrator')
                <li class="nav-item">
                    <a class="nav-link {{ active_class(Active::checkUriPattern('admin/parking')) }}" href="{{ route('admin.parking.index') }}">
                        <i class="nav-icon test"></i> Parking
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/appointment')) }}" href="{{ route('admin.appointment.index') }}">
                    <i class="nav-icon test"></i> Appointments
                </a>
            </li>
        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->
