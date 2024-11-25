@extends('layout')

@section('main')
<div class="container">
    <h1>الفواتير</h1>
    <form method="GET" action="{{ route('bills.index') }}" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="البحث عن طريق اسم العميل" value="{{ request('search') }}">
    </form>
    <a href="{{ route('bills.create') }}" class="btn btn-primary mb-3">إنشاء فاتورة</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم العميل</th>
                <th>هاتف العميل</th>
                <th>السعر الإجمالي</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bills as $bill)
                <tr>
                    <td>{{ $bill->id }}</td>
                    <td>{{ $bill->customer_name }}</td>
                    <td>{{ $bill->customer_phone }}</td>
                    <td>${{ $bill->total_price }}</td>
                    <td>
                        <a href="{{ route('bills.show', $bill->id) }}" class="btn btn-info btn-sm">عرض</a>
                        <form action="{{ route('bills.destroy', $bill->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $bills->links() }}
</div>
@endsection
