@extends('layout.anggotaLayouts.main')
@section('title')
  <title>Dashboard</title>
@endsection
@push('css')
@endpush
@section('content')

<div class="content text-center">
  <div class="card card-style">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
      <div class="carousel-indicators">
        @foreach($banners as $key => $banner)
          @if($banner->is_show == true)
            <button type="button" data-bs-target="#carouselExampleControls" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $key+1 }}"></button>
          @endif
        @endforeach
      </div>
      <div class="carousel-inner">
        @foreach($banners as $key => $banner)
          @if($banner->is_show == true)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
              <img class="d-block w-100" src="{{ asset('/images/banners/'.$banner->image) }}" alt="{{ $banner->name }}" style="width: 300px; height: 200px;">
            </div>
          @endif
        @endforeach
      </div>
    </div>
  </div>
</div>

<div class="divider mx-3 mt-2 mb-4"></div>
<div class="card card-style">
  <div class="content px-2 text-center">
    <h5 class="mb-1 font-12 color-highlight font-700 text-uppercase">Berita</h5>
    <h2>Berita Terkini</h2>
    <br>
    <div class="divider mx-3 mt-2 mb-4"></div>
    <div id="beritaContainer" class="row text-center row-cols-3 mb-n1">
      <!-- Konten berita awal -->
      @foreach($berita as $brt)
        <a class="col" data-gallery="gallery-1" href="{{ route('berita.show', $brt->slug) }}" title="{{ $brt->title }}">
          <img src="{{ asset('/images/posts/'.$brt->image) }}" class="preload-img img-fluid rounded-m" alt="img">
          <p>{{ substr($brt->title, 0, 10) }}...</p>
        </a>
      @endforeach
    </div>
    
    <br>
    
    @if($berita->hasMorePages())
    <div class="text-center">
      <a href="{{ route('load-more-berita') }}" id="loadMoreButton" class="btn-full btn gradient-blue">Lihat Lainnya</a>
    </div>
    @else
    <div class="text-center">
      <p>Tidak ada berita lain yang tersedia.</p>
      <script>
        document.getElementById('loadMoreButton').style.display = 'none';
      </script>
    </div>
    @endif
  </div>
</div>
{{-- <div class="content">
  <div class="card p-5">
    <div class="content px-2 text-center">
      <h5 class="mb-1 font-12 color-highlight font-700 text-uppercase">Berita</h5>
      <h2>Berita Terkini</h2>
      <br>
      <div class="divider mx-3 mt-2 mb-4"></div>
      <div id="beritaContainer" class="row text-center row-cols-3 mb-n1">
        <!-- Konten berita awal -->
        @foreach($berita as $brt)
          <a class="col" data-gallery="gallery-1" href="{{ route('berita.show', $brt->slug) }}" title="{{ $brt->title }}" data-is-loaded="true">
            <img src="{{ asset('/images/posts/'.$brt->image) }}" class="preload-img img-fluid rounded-m" alt="img">
            <p>{{ substr($brt->title, 0, 10) }}...</p>
          </a>
        @endforeach
      </div>
      
      <br>
      
      @if($berita->hasMorePages())
      <div class="text-center">
        <a href="{{ route('load-more-berita') }}" id="loadMoreButton" class="btn-full btn gradient-blue">Lihat Lainnya</a>
      </div>
      @else
      <div class="text-center">
        <p>Tidak ada berita lain yang tersedia.</p>
        <script>
          document.getElementById('loadMoreButton').style.display = 'none';
        </script>
      </div>
      @endif
    </div>
  </div>
</div> --}}

@endsection

@push('js')
{{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  var currentPage = 1;
  var loadMoreButton = document.getElementById('loadMoreButton');
  var beritaContainer = document.getElementById('beritaContainer');

  loadMoreButton.addEventListener('click', function(e) {
  e.preventDefault();
  currentPage++;

  var xhr = new XMLHttpRequest();
  xhr.open('GET', "{{ route('load-more-berita') }}" + "?page=" + currentPage, true);

  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = xhr.responseText;
      var parser = new DOMParser();
      var newBerita = parser.parseFromString(response, 'text/html').querySelector('#beritaContainer');
      beritaContainer.innerHTML += newBerita.innerHTML;
    }
  };

  xhr.send();
});
</script>

{{-- <script>
  var currentPage = 1;
  var loadMoreButton = $('#loadMoreButton');
  var beritaContainer = $('#beritaContainer');
  var isLoading = false;
  var totalPages = {{ $berita->lastPage() }};

  function loadMoreBerita() {
  if (isLoading) return;
  isLoading = true;
    $.ajax({
      url: "{{ route('load-more-berita') }}",
      method: 'GET',
      data: { page: currentPage },
      success: function(response) {
        if (response.html.trim() !== '') {
          beritaContainer.append(response.html);
          currentPage++;
        }

        isLoading = false;

        if (currentPage <= totalPages) {
          loadMoreButton.show();
        } else {
          loadMoreButton.hide();
        }
      }
    });
  }
  loadMoreButton.on('click', function(e) {
    e.preventDefault();
    loadMoreBerita();
  });
</script> --}}
@endpush