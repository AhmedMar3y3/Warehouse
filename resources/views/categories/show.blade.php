@extends('layout')

@section('main')
<div class="container">
    <h2>الفئة: {{ $category->name }}</h2>
    
    <a href="{{ route('categories.index') }}" class="btn btn-secondary mb-3">العودة إلى الفئات</a>

    <!-- قائمة المنتجات في هذه الفئة -->
    <h3>المنتجات في {{ $category->name }}</h3>

    @if($category->products->isEmpty())
        <p>لم يتم العثور على منتجات في هذه الفئة.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>الاسم</th>
                    <th>السعر</th>
                    <th>الكمية</th>
                    <th>الوصف</th>
                </tr>
            </thead>
            <tbody>
                @foreach($category->products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
