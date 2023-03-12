@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Vertical Layouts</h4>

<!-- Update Author -->
<div class="row">
  <div class="col-xl">
    <div class="card col-md-4 mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Update Author</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{route('authors.update', $author->id)}}">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">Name</label>
            <input type="text" name="name" class="form-control" id="basic-default-fullname"  value="{{$author->name}}"/>
          </div>
          @if($errors->any())
          <div class="mb-3">
            @foreach($errors->all() as $error)
            <p>{{$error}}</p>
            @endforeach
          </div>
          @endif
          <button type="submit" class="btn btn-primary">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection