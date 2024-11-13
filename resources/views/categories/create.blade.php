@extends('layout')

@section('main')
    <div class="container">
        <h2>Add Category</h2>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Category</button>
        </form>
    </div>
@endsection