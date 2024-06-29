<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        {{-- <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div> --}}
        <div class="sidebar-brand-text">&nbsp;&nbsp;{{ Auth::user()->name }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{Route::is('dashboard') ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    @can('rekap_presensi_user', PresensiController::class)
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item {{Route::is('presensi') ? 'active' : ''}}">
            {{-- <a class="nav-link" href="#"> --}}
            <a class="nav-link" href="{{ route('absen') }}">
                <i class="fas fa-fw fa-folder"></i>
                <span>Presensi</span>
            </a>
        </li>
    @endcan

    @can('slip_gaji_admin', SlipGajiController::class)
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('slip_gaji.index')}}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Slip Gaji Karyawan</span></a>
    </li>
    @endcan
    @can('slip_gaji_user', SlipGajiController::class)
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('slip_gaji.index')}}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Slip Gaji</span></a>
    </li>
    @endcan

    @can('create_user')
    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('creator.index')}}">
            <i class="fas fa-fw fa-table"></i>
            <span>Create User</span></a>
    </li>
    @endcan

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

</ul>
