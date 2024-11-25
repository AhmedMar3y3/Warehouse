@extends('layout')

@section('main')
    <div class="container">
        <h2>إضافة فئة</h2>

        <!-- رسالة النجاح -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">اسم الفئة</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <button type="submit" class="btn btn-primary">إضافة الفئة</button>
        </form>
    </div>
@endsection