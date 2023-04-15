@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')
 
<!-- Update Book -->
<div class="row">
  <div class="col-xl">
    <div class="card col-md-4 mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Update Book</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{route('books.update', $book->book_id)}}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label class="form-label" for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{$book->book_title}}"/>
          </div>
          <div class="mb-3">
            <label class="form-label">Author </label>
            <input class="form-control" list="authorList"  value="{{$book->author_name}}" >
            <datalist id="authorList">
              @foreach($authors as $author)
              <option>{{$author->name}}</option>
              <input name='author_id' type="hidden" value="{{$author->id}}" selected> 
              @endforeach
            </datalist>
          </div>
          <div class="mb-3">
            <label class="form-label" for="basic-default-fullname" >Category</label>
            <input class="form-control" list="categoryList" placeholder="Type to search..." value="{{$book->category}}">
            <datalist id="categoryList">
              @foreach($categories as $category)
              <option>{{$category->name}}</option>
              <input name='category_id' type="hidden" value="{{$category->id}}">
              @endforeach
            </datalist>
          </div>
          <div class="mb-3">
            <label for="html5-datetime-local-input" class="form-label">Datetime</label>
            <div class="col-md-10">
              <input class="form-control" name="released_date" type="date" value="{{$book->releasedDate}}" id="html5-datetime-local-input" />
            </div>
          </div>
          <div class="mb-3">
            <label for="excerptsTextArea" class="form-label">Excerpts</label>
            <textarea class="form-control" name="excerpts" id="excerptsTextArea" rows="3">{{$book->excerpts}}</textarea>
          </div>
          <div class="mb-3">
            <label for="formFile" class="form-label">Image</label>
             <img class="card-img-top" src="/storage/{{$book->image}}" alt="Card image cap"> 
            <input class="form-control" type="file" id="formFile" name="image">
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