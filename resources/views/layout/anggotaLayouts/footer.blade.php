<div id="footer-bar" class="footer-bar footer-bar-detached">
    <a href="index-pages.html"><i class="bi bi-heart-fill font-15"></i><span>Pages</span></a>
    <a href="index-components.html"><i class="bi bi-star-fill font-17"></i><span>Features</span></a>
    <a href="{{ route('home') }}" class="{{ Request::is('/') ? 'active-nav' : '' }}"><i class="bi bi-house-fill font-16"></i><span>Home</span></a>
    <a href="#"><i class="bi bi-image font-16"></i><span>Media</span></a>
    <a href="{{ route('show.formContact') }}" class="{{ Request::is('form-contact') ? 'active-nav' : '' }}"><i class="bi bi-envelope-fill font-16"></i><span>Kontak</span></a>
</div>