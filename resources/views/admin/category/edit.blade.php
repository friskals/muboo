@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Vertical Layouts</h4>

<!-- Edit Category -->
<div class="row">
  <div class="col-xl">
    <div class="card col-md-4 mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Edit Category</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{route('categories.update', $category->id)}}">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">Name</label>
            <input type="text" name="name" class="form-control" id="basic-default-fullname" value="{{$category->name}}"/>
         
          </div>
          <div class="mb-3">
            <label for="category-status" class="form-label">Catexgory</label>
            <select class="form-select" name="status" id="category-status" aria-label="Category">
              <option @if($category->status == 'Inactive') selected @endif value="Inactive">Inactive</option>
              <option @if($category->status == 'Active') selected @endif value="Active">Active</option>
            </select>
          </div>
          @if($errors->any())
          <div class="mb-3">
            @foreach($errors->all() as $error)
            <p>{{$error}}</p>
            @endforeach
          </div>
          @endif
          <button type="submit" class="btn btn-primary">Edit</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection