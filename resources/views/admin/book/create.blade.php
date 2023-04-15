@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Vertical Layouts</h4>

<!-- Create Update -->
<div class="row">
  <div class="col-xl">
    <div class="card col-md-4 mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Create Book</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{route('books.store')}}" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label class="form-label" for="title">Title</label>
            <input type="text" name="title" class="form-control" placeholder="Tinker Bell" />
          </div>
          <div class="mb-3">
            <label class="form-label">Author </label>
            <input class="form-control" list="authorList" placeholder="Type to search...">
            <datalist id="authorList">
              @foreach($authors as $author)
              <option>{{$author->name}}</option>
              <input name='author_id' type="hidden" value="{{$author->id}}">
              @endforeach
            </datalist>
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">Category</label>
            <input class="form-control" list="categoryList" placeholder="Type to search...">
            <datalist id="categoryList">
              @foreach($categories as $category)
              <option>{{$category->name}}</option>
              <input name='category_id' type="hidden" value="{{$category->id}}">
              @endforeach
            </datalist>
          </div>
          <div class="mb-3">
            <label for="html5-datetime-local-input" class="form-label">Release date</label>
            <div class="col-md-10">
              <input class="form-control" name="released_date" type="date" value="2021-06-18T12:30:00" id="html5-datetime-local-input" />
            </div>
          </div>
          <div class="mb-3">
            <label for="excerptsTextArea" class="form-label">Excerpts</label>
            <textarea class="form-control" name="excerpts" id="excerptsTextArea" rows="3" placeholder="Best excerpt from this book"></textarea>
          </div>
          <div class="mb-3">
            <label for="formFile" class="form-label">Image</label>
            <input class="form-control" type="file" id="formFile" name="image">
          </div>
          @if($errors->any())
          <div class="mb-3">
            @foreach($errors->all() as $error)
            <p>{{$error}}</p>
            @endforeach
          </div>
          @endif
          <button type="submit" class="btn btn-primary">Create</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection