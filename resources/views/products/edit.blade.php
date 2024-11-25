@extends('layout')

@section('main')
<div class="container">
    <h1>تعديل المنتج</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Name Field -->
        <div class="mb-3">
            <label for="name" class="form-label">الاسم</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Price Field -->
        <div class="mb-3">
            <label for="price" class="form-label">السعر</label>
            <input type="text" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}">
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Quantity Field -->
        <div class="mb-3">
            <label for="quantity" class="form-label">الكمية</label>
            <input type="text" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}">
            @error('quantity')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Description Field -->
        <div class="mb-3">
            <label for="description" class="form-label">الوصف</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <!-- Category Field -->
        <div class="mb-3">
            <label for="category_id" class="form-label">الفئة</label>
            <select name="category_id" class="form-control">
                <option value="">اختر الفئة</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-primary">تحديث</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">إلغاء</a>
    </form>
</div>
@endsection
