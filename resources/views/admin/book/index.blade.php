@extends('layouts/contentNavbarLayout')

@section('title', 'Book')

@section('page-script')
<script src="{{asset('assets/js/book-setting-pages.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3">
    <span class="text-muted fw-light">Book
</h4>

<div class="mb-4">
    <button type="button" id="addBook" class="btn btn-success">Add</button>
</div>
<div class="card">
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @if(!$books->isEmpty())
                @foreach($books as $book)
                <tr>
                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$book->name}}</strong></td>
                    <td>{{$book->created_at}}</td>
                    <td>{{$book->updated_at}}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{route('books.edit', $book->id)}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                <a class="dropdown-item" href="{{route('books.destroy', $book->id)}}" onclick="event.preventDefault();
                                document.getElementById('delete-form-{{ $book->id }}').submit();"><i class="bx bx-trash me-1"></i> Delete</a>
                                <form id="delete-form-{{ $book->id }}" action="{{ route('books.destroy', $book->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection