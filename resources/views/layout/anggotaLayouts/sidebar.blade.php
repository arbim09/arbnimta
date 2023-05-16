          <!-- Main Sidebar-->
          <div id="menu-main" data-menu-active="nav-homes" style="width:280px;" class="offcanvas offcanvas-start offcanvas-detached rounded-m">
            @if(auth()->check())
            <div class="bg-theme mx-3 rounded-m shadow-m mt-3 mb-3">
                <div class="d-flex px-2 pb-2 pt-2">
                    <div>
                        <a href="#"><img src="{{asset('/anggotaTemplate/images/pictures/7s.jpg')}}" width="45" class="rounded-s" alt="img"></a>
                    </div>
                    <div class="ps-2 align-self-center">
                        @if(auth()->check())
                        
                        <h5 class="ps-1 mb-0 line-height-xs pt-1">{{ auth()->user()->name }}</h5>
                        <h6 class="ps-1 mb-0 font-400 opacity-100">{{ auth()->user()->role }}</h6>
                        @else
                        <h5 class="ps-1 mb-0 line-height-xs pt-1">Login Terlebih Dahulu</h5>
                        @endif
                    </div>
                </div>
            </div>
        
            <span class="menu-divider">NAVIGATION</span>
            <div class="menu-list">
                <div class="card card-style rounded-m p-3 py-2 mb-0">
                    <a href="#" id="nav-homes"><i class="gradient-blue shadow-bg shadow-bg-xs bi bi-person-fill"></i><span>Profil</span><i class="bi bi-chevron-right"></i></a>
                    <a href="#" id="nav-comps"><i class="gradient-red shadow-bg shadow-bg-xs bi bi-gear-fill"></i><span>Absensi</span><i class="bi bi-chevron-right"></i></a>
                    <a href="#" id="nav-pages"><i class="gradient-green shadow-bg shadow-bg-xs bi bi-heart-fill"></i><span>Site Pages</span><i class="bi bi-chevron-right"></i></a>
                    <a href="#" id="nav-media"><i class="gradient-yellow shadow-bg shadow-bg-xs bi bi-image-fill"></i><span>Media Styles</span><i class="bi bi-chevron-right"></i></a>
                    <a href="#" id="nav-mails"><i class="gradient-magenta shadow-bg shadow-bg-xs bi bi-envelope-fill"></i><span>Contact</span><i class="bi bi-chevron-right"></i></a>
                </div>
            </div>
            @else
            <div style="display: flex; flex-direction: column; align-items: center; margin-top: 400px;">
                <a href="#" class="header-title color-theme">Login Terlebih Dahulu!</a>
                <div class="col-4">
                    <a href="{{ route('login') }}" class="btn-full btn border-green-dark color-green-dark">Login!</a>
                </div>
            </div>
            @endif
        </div>