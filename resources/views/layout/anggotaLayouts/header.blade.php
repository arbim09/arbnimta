   
   <!-- Header -->
<div class="header-bar header-fixed header-app header-bar-detached">
    <a data-bs-toggle="offcanvas" data-bs-target="#menu-main" href="#"><i class="bi bi-list color-theme"></i></a>
    @if(auth()->check())
        <a href="#" class="header-title color-theme">{{ auth()->user()->name }}</a>
        <a  href="#" data-toggle="modal" data-target="#logoutModal" data-backdrop="false">
            <i class="bi bi-box-arrow-left"></i>
        </a>
    @else
        <a href="#" class="header-title color-theme">Login Terlebih Dahulu!</a>
    @endif
</div>




  





    

