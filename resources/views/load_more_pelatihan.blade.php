@foreach ($events as $event)
    <br>
    <a href="#">
        <div class="d-flex mb-3">
            <div class="align-self-center me-auto">
                <h5 class="font-500 font-15 pb-1">{{ substr($event->name, 0, 30) }}...</h5>
                <span
                    class="color-theme font-10 ps-2 opacity-50">{{ date('j F Y', strtotime($event->created_at)) }}</span>
            </div>
            <div class="align-self-start ms-auto">
                <img src="{{ asset('images/events/' . $event->image) }}" class="rounded-m ms-3" width="90">
            </div>
        </div>
    </a>
    <br>
    <div class="divider mb-3"></div>
@endforeach
