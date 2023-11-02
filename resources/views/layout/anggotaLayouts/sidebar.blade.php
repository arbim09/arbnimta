<!-- Main Sidebar-->
<div id="menu-main" data-menu-active="nav-homes" style="width:320px;"
    class="offcanvas offcanvas-start offcanvas-detached rounded-m">
    @if (auth()->check())
        <div class="bg-theme mx-3 rounded-m shadow-m mt-3 mb-3">
            <div class="d-flex px-2 pb-2 pt-2">
                <div>
                    @php
                        $foto_profil = auth()->user()->foto_profil ? asset('images/profil/') . '/' . auth()->user()->foto_profil : asset('images/profil/user.png');
                    @endphp
                    <a href="#"><img id="image-data" class="img-fluid rounded-s img-center" src="{{ $foto_profil }}"
                            width="45" class="rounded-s" alt="img"></a>
                </div>
                <div class="ps-2 align-self-center">
                    @if (auth()->check())
                        <h5 class="ps-1 mb-0 line-height-xs pt-1 mb-1">{{ auth()->user()->name }}</h5>
                        <p class="ps-1 mb-0 font-400 opacity-100" style="position: right;">
                            Total Point: {{ auth()->user()->point }}
                            @if (auth()->user()->badge)
                                @if (auth()->user()->badge === 'Gold Badge')
                                    <img src="{{ asset('/images/badge/medalGold.png') }}" alt="Gold Badge"
                                        class="badge-image"
                                        style="width: 40px; height: 40px; position: absolute; top: 25px; right: 30px;">
                                @elseif (auth()->user()->badge === 'Silver Badge')
                                    <img src="{{ asset('images/badge/medalSilver.png') }}" alt="Silver Badge"
                                        class="badge-image"
                                        style="width: 40px; height: 40px; position: absolute; top: 25px; right: 30px;">
                                @elseif (auth()->user()->badge === 'Bronze Badge')
                                    <img src="{{ asset('images/badge/medalBronze.png') }}" alt="Bronze Badge"
                                        class="badge-image"
                                        style="width: 40px; height: 40px; position: absolute; top: 25px; right: 30px;">
                                @endif
                            @endif
                        </p>
                    @else
                        <h5 class="ps-1 mb-0 line-height-xs pt-1">Login Terlebih Dahulu</h5>
                    @endif
                </div>

            </div>
        </div>

        <span class="menu-divider">NAVIGATION</span>
        <div class="menu-list">
            <div class="card card-style rounded-m p-3 py-2 mb-0">
                <a href="{{ route('profil.index') }}"><i
                        class="gradient-blue shadow-bg shadow-bg-xs bi bi-person-fill"></i><span>Profil</span><i
                        class="bi bi-chevron-right"></i></a>
                <a href="{{ route('camera') }}" id="nav-comps"><i
                        class="gradient-red shadow-bg shadow-bg-xs bi bi-clock-fill"></i><span>Absensi</span><i
                        class="bi bi-chevron-right"></i></a>
                {{-- <a href="{{ route('form-pendaftaran', $events->id) }}" id="nav-comps"><i
                        class="gradient-green shadow-bg shadow-bg-xs bi bi-person-plus"></i><span>Pendaftaran
                        Event</span></a> --}}
                <br>
                <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                    @csrf
                    <button type="submit" class="btn-full btn bg-blue-dark">
                        <i class=" shadow-bg shadow-bg-xs bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
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
