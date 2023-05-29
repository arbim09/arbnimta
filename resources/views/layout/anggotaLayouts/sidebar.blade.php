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
                    <a href="{{route('profil.index')}}" ><i class="gradient-blue shadow-bg shadow-bg-xs bi bi-person-fill"></i><span>Profil</span><i class="bi bi-chevron-right"></i></a>
                    <a href="{{route('camera')}}" id="nav-comps"><i class="gradient-red shadow-bg shadow-bg-xs bi bi-clock-fill"></i><span>Absensi</span><i class="bi bi-chevron-right"></i></a>
                    <a href="#" id="nav-pages"><i class="gradient-green shadow-bg shadow-bg-xs bi bi-heart-fill"></i><span>Site Pages</span><i class="bi bi-chevron-right"></i></a>
                    <a href="#" id="nav-media"><i class="gradient-yellow shadow-bg shadow-bg-xs bi bi-image-fill"></i><span>Media Styles</span><i class="bi bi-chevron-right"></i></a>
                    <a href="#" id="nav-mails"><i class="gradient-magenta shadow-bg shadow-bg-xs bi bi-envelope-fill"></i><span>Contact</span><i class="bi bi-chevron-right"></i></a>
                    <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                        @csrf
                        <button type="button" class="btn rounded-sm btn-m gradient-green text-uppercase font-700 mt-4 mb-3 btn-full shadow-bg shadow-bg-s" data-bs-toggle="modal" data-bs-target="#logoutModal">
                          <i class=" shadow-bg shadow-bg-xs bi bi-box-arrow-right"></i>
                          <span>Logout</span>
                        </button>
                      
                        <!-- Modal Logout -->
                        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true" data-bs-backdrop="false">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <p>Apakah Anda yakin ingin logout?</p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Logout</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                </div>
            </div>
            @else
            <div style="display: flex; flex-direction: column; align-items: center; margin-top: 300px;">
              <a href="#" class="header-title color-theme">Sudah Punya Akun?</a>
              <div class="col-4">
                  <a href="{{ route('login') }}" class="btn-full btn border-green-dark color-green-dark">Login</a>
              </div>
              <a href="#" class="header-title color-theme">Belum punya akun?</a>
              <div class="col-4">
                  <a href="{{ route('register') }}" class="btn-full btn border-blue-dark color-green-dark">Daftar</a>
              </div>
          </div>
            @endif
        </div>