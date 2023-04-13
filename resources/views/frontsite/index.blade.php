@extends('frontsite/navbarLayout')

@section('title', 'Cards basic   - UI elements')

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/masonry/masonry.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">What's new?</h4>
 @foreach ($books as $book)
    <div class="row mb-3">
        <div class="col-sm-3"></div>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100">
            <img class="card-img-top" src="{{asset('assets/img/elements/2.jpg')}}" alt="Card image cap" />
            <div class="card-body">
                <h5 class="card-title">{{$book->title}}</h5>
                <p class="card-text">
                {{$book->excerpts}}
                </p>
                <a href="javascript:void(0)" class="btn btn-outline-primary">Go somewhere</a>
            </div>
            </div>
        </div>
    </div>
 @endforeach
@endsection
