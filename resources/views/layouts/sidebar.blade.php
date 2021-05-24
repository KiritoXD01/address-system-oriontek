<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    @if(!empty(App\Models\Business::first()->logo))
        <img alt="" src="{{ App\Models\Business::first()->logo }}" style="width: 80%;" class="mx-auto my-3" />
    @else
        <img alt="" src="{{ asset('img/logo.jpeg') }}" style="width: 80%;" class="mx-auto my-3" />
    @endif
    <!-- Divider -->
    <hr class="sidebar-divider my-3">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Nav Item - Users -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('business.index') }}">
            <i class="fas fa-fw fa-building"></i>
            <span>@lang('messages.business')</span>
        </a>
    </li>

    <!-- Nav Item - Users -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>@lang('messages.users')</span>
        </a>
    </li>

    <!-- Nav Item - Users -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('client.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>@lang('messages.clients')</span>
        </a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
