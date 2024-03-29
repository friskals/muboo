@extends('layouts/contentNavbarLayout')

@section('title', 'Category')

@section('content')
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Category
</h4>
<div class="mb-4">
    <button type="button" onclick="location.href='/admin/categories/create'" class="btn btn-success">Add</button>
</div>
<div class="card">
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Creatve At</th>
                    <th>Last Modified</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($categories as $category)
                <tr>
                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$category->name}}</strong></td>
                    <td>{{$category->slug}}</td>
                    <td>@if($category->status == 'Inactive')
                        <span class="badge bg-label-primary me-1">{{$category->status}}</span>
                        @else
                        <span class="badge bg-label-success me-1">{{$category->status}}</span>
                        @endif
                    </td>
                    <td>{{$category->created_at}}</td>
                    <td>{{$category->updated_at}}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{route('categories.edit', $category->id)}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                <a class="dropdown-item" href="{{route('categories.destroy', $category->id)}}" onclick="event.preventDefault();
                                document.getElementById('delete-form-{{ $category->id }}').submit();"><i class="bx bx-trash me-1"></i> Delete</a>
                                <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
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
@endsection