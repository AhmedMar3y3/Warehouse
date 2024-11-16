@extends('layout')
@section('main')
<div class="container">
    <h1>Bills</h1>
    <form method="GET" action="{{ route('bills.index') }}" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Search by customer name" value="{{ request('search') }}">
    </form>
    <a href="{{ route('bills.create') }}" class="btn btn-primary mb-3">Create Bill</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer Name</th>
                <th>Customer Phone</th>
                <th>Total Price</th>
                <th>Actions</th>
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
                        <a href="{{ route('bills.show', $bill->id) }}" class="btn btn-info btn-sm">View</a>
                        <form action="{{ route('bills.destroy', $bill->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $bills->links() }}
</div>
@endsection