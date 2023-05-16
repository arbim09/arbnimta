@foreach($berita->items() as $brt)
  <a class="col" data-gallery="gallery-1" href="{{ route('berita.show', $brt->slug) }}" title="{{ $brt->title }}">
    <img src="{{ asset('/images/posts/'.$brt->image) }}" class="preload-img img-fluid rounded-m" alt="img">
    <p>{{ substr($brt->title, 0, 10) }}...</p>
  </a>
@endforeach