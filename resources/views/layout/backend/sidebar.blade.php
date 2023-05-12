<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    @can('admin')
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin.dashboard')}}">
            <div class="sidebar-brand-icon">
                <img src="{{ asset('images/backend/logo-rtik.png')}}" height="42" width="42">
            </div>
            <div class="sidebar-brand-text mx-3">RTIK CIREBON</div>
        </a>
    @endcan
    @can('pengurus')
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('pengurus')}}">
            <div class="sidebar-brand-icon">
                <img src="{{ asset('images/backend/logo-rtik.png')}}" height="42" width="42">
            </div>
            <div class="sidebar-brand-text mx-3">RTIK CIREBON</div>
        </a>
    @endcan

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    @can('admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard Admin</span></a>
    </li>
    @endcan

    @can('pengurus')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('pengurus') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard Pengurus</span></a>
    </li>
    @elseCan('admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('pengurus') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>User Dashboard</span></a>
    </li>
    @endCan
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

 
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities1"
            aria-expanded="true" aria-controls="collapseUtilities1">
            <i class="fas fa-fw fa-table"></i>
            <span>Master Data</span>
        </a>
        <div id="collapseUtilities1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('admin')
                <a class="collapse-item" href="{{ route('admin.index') }}">Admin</a>
                <a class="collapse-item" href="{{ route('pengurus.index') }}">Pengurus</a>
                <a class="collapse-item" href="{{ route('anggota.index') }}">Anggota</a>
                @endcan
                @can('pengurus')
                <a class="collapse-item" href="{{ route('anggotas.index') }}">Anggota</a>
                @endcan
            </div>
        </div>
    </li>
    @can('admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Berita</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('posts.index') }}">Berita</a>
                <a class="collapse-item" href="{{ route('category.index') }}">Kategori</a>
            </div>
        </div>
    </li>
    @endcan

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
            aria-expanded="true" aria-controls="collapseThree">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Events</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('admin')
                <a class="collapse-item" href="{{ route('events.index') }}">Semua Event</a>
                <a class="collapse-item" href="{{ route('pelatihan.event') }}">Pelatihan</a>
                <a class="collapse-item" href="{{ route('acara.event') }}">Acara</a>
                <a class="collapse-item" href="{{ route('kegiatan.event') }}">Kegiatan</a>
                @endcan
                @can('pengurus')
                <a class="collapse-item" href="{{ route('event.index') }}">Semua Event</a>
                @endcan
            </div>
        </div>
    </li>
    @can('admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAbsensi"
            aria-expanded="true" aria-controls="collapseAbsensi">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Absensi</span>
        </a>
        <div id="collapseAbsensi" class="collapse" aria-labelledby="headingAbsensi"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Absensi Events:</h6>
                @can('admin')
                <a class="collapse-item" href="{{ route('absensi.index') }}">Data Absensi</a>
                <a class="collapse-item" href="{{ route('pelatihan.absensi') }}">Pelatihan</a>
                <a class="collapse-item" href="{{ route('acara.absensi') }}">Acara</a>
                <a class="collapse-item" href="{{ route('kegiatan.absensi') }}">Kegiatan</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan

    @can('admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('banners.index') }}">
            <i class="fas fa-fw fa-images"></i>
            <span>Banner</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('contact.index') }}">
            <i class="fas fa-fw fa-envelope"></i>
            <span>Pesan</span></a>
    </li>            
    @endcan

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePendaftaran"
            aria-expanded="true" aria-controls="collapsePendaftaran">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pendaftaran</span>
        </a>
        <div id="collapsePendaftaran" class="collapse" aria-labelledby="headingPendaftaran" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pendaftaran: </h6>
                @can('admin')
                <a class="collapse-item" href="{{ route('pelatihan.pendaftaran') }}">Pelatihan</a>
                <a class="collapse-item" href="{{ route('acara.pendaftaran') }}">Acara</a>
                <a class="collapse-item" href="{{ route('kegiatan.pendaftaran') }}">Kegiatan</a>
                @elseCan('pengurus')
                <a class="collapse-item" href="{{ route('login') }}">Pelatihan</a>
                <a class="collapse-item" href="{{ route('register') }}">Acara</a>
                <a class="collapse-item" href="{{ route('forgot-password') }}">Kegiatan</a>
                @endcan
            </div>
        </div>
    </li>

@can('admin')
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Pages</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Login Screens:</h6>
                    <a class="collapse-item" href="{{ route('login') }}">Login</a>
                    <a class="collapse-item" href="{{ route('register') }}">Register</a>
                    <a class="collapse-item" href="{{ route('forgot-password') }}">Forgot Password</a>
                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Other Pages:</h6>
                    <a class="collapse-item" href="{{ route('404-page') }}">404 Page</a>
                    <a class="collapse-item" href="{{ route('blank-page') }}">Blank Page</a>
                </div>
            </div>
        </li>
    
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('chart') }}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Charts</span></a>
        </li>
    
        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('tables') }}">
                <i class="fas fa-fw fa-table"></i>
                <span>Tables</span></a>
        </li>
    
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('profile') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Profile</span></a>
        </li> --}}
@endcan


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>