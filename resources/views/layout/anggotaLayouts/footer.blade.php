<div id="footer-bar" class="footer-bar footer-bar-detached">
    <a href="{{ route('acara.anggota') }}" class="{{ Request::is('acara', 'acara/*') ? 'active-nav' : '' }}"><i
            class="bi bi-heart-fill font-15"></i><span>Acara</span></a>
    <a href="{{ route('pelatihan.anggota') }}"
        class="{{ Request::is('pelatihan', 'pelatihan/*') ? 'active-nav' : '' }}"><i
            class="bi bi-cup-fill"></i><span>Pelatihan</span></a>
    <a href="{{ route('home') }}" class="{{ Request::is('/') ? 'active-nav' : '' }}"><i
            class="bi bi-house-fill font-16"></i><span>Home</span></a>
    <a href="{{ route('kegiatan.anggota') }}" class="{{ Request::is('kegiatan', 'kegiatan/*') ? 'active-nav' : '' }}"><i
            class="bi bi-laptop font-16"></i><span>Kegiatan</span></a>
    <a href="{{ route('show.formContact') }}" class="{{ Request::is('form-contact') ? 'active-nav' : '' }}"><i
            class="bi bi-envelope-fill font-16"></i><span>Kontak</span></a>
</div>
