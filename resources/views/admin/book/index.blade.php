@extends('layouts/contentNavbarLayout')

@section('title', 'Book')

@section('page-script')
    <script src="{{ asset('assets/js/book-setting-pages.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3">
        <span class="text-muted fw-light">Book</span>
    </h4>

    <form method="POST" action="{{ route('books.filter') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="bookId" class="form-label">Book ID</label>
                            <input type="text" name="id" class="form-control" id="bookId"
                                placeholder="Book ID" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title"
                                placeholder="Tinker Bell..." />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mb-4">
                <button type="submit" class="btn btn-info">Search</button>
    </form>
    <button type="button" onclick="location.href='/admin/books/create'" class="btn btn-success">Add</button>
    </div>
    </div>

    @if (Session::has('success'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('success') }}</p>
    @endif

    @if (isset($title))
        <h4 class="fw-bold py-3">
            <span class="fw-bold fw-light">{{ $title }}</span>
        </h4>
    @endif
    @if ($books->count() > 0)
        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Created At</th>
                            <th>Last Modified</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($books as $book)
                            <tr>
                                <td>{{ $book->id }}</td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->created_at }}</td>
                                <td>{{ $book->updated_at }}</td>
                                <td>{{ $book->status }}</td>

                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('books.edit', $book->id) }}"><i
                                                    class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a class="dropdown-item" href="{{ route('books.destroy', $book->id) }}"
                                                onclick="event.preventDefault();
                                document.getElementById('delete-form-{{ $book->id }}').submit();"><i
                                                    class="bx bx-trash me-1"></i> Delete</a>
                                            <form id="delete-form-{{ $book->id }}"
                                                action="{{ route('books.destroy', $book->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <a class="dropdown-item" href="{{ route('books.update.status') }}"
                                                onclick="event.preventDefault(); 
                                document.getElementById('update-status-form-{{ $book->id }}').submit();"><i
                                                    class="bx @if ($book->is_published) bxs-downvote @else bxs-upvote @endif">
                                                </i>
                                                @if ($book->is_published)
                                                    Unpublish
                                                @else
                                                    Publish
                                                @endif
                                            </a>
                                            <form id="update-status-form-{{ $book->id }}"
                                                action="{{ route('books.update.status') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                @method('PUT')
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

@endsection
