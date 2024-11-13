@extends('layout')
@section('main')

  <div class="container">
        <h2>All Categories</h2>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <!-- Button to Create a new Medication -->
        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add Category</a>

        <!-- Table to list all medications -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> <!-- View icon -->
                            </a>
                            <!-- Delete Button -->
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>                           
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No Categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection