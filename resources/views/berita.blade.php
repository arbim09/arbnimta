@extends('layout.anggotaLayouts.main')

@section('content')
<div id="page">
    <!-- Your Page Content Goes Here-->
    <div class="page-content">
		<div class="card card-style">
            <div class="card-body px-0 py-0">
    
                <h5 class="font-700 px-3 mb-3 mt-3 text-center">{{$posts->title}}</h5>
                <div class="divider mb-0 mx-3"></div>
                <br>
                <div class="list-group list-custom list-group-m rounded-xs list-group-flush px-3">
                    <img src="{{ asset('images/posts/'.$posts->image) }}" alt="{{ $posts->title }}" class="img-fluid" style="max-width: 100%; height: auto;">
                </div>
                <br>
                <div class="divider mb-0 mx-3"></div>
                <div class="list-group list-custom list-group-m rounded-xs list-group-flush px-3">
                    <br>
                    {!! html_entity_decode($posts->content) !!}
                </div>
            </div>
        </div>

    </div>
	<!-- End of Page Content-->
</div>
@endsection