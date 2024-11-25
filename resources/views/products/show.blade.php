@extends('layout')

@section('main')
<div class="container">
    <h1>تفاصيل المنتج</h1>
    <div class="mb-3">
        <h4>الاسم:</h4> <span>{{ $product->name }}</span>
    </div>
    <div class="mb-3">
        <h4>السعر:</h4> <span>{{ $product->price }}</span>
    </div>
    <div class="mb-3">
        <h4>الكمية:</h4> <span>{{ $product->quantity }}</span>
    </div>
    <div class="mb-3">
        <h4>الوصف:</h4> <span>{{ $product->description }}</span>
    </div>
</div>
  
<a href="{{ route('products.index') }}" class="btn btn-secondary">العودة إلى القائمة</a>
</div>
@endsection
