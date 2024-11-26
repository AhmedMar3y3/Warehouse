@extends('layout')
@section('main')

    <div class="container">
                <h2>جميع الفئات</h2>

                <!-- رسالة النجاح -->
                @if(session('success'))
                        <div class="alert alert-success">
                                {{ session('success') }}
                        </div>
                @endif
                <!-- زر لإنشاء فئة جديدة -->
                <a href="{{ route('categories.create') }}" class="btn mb-3" style="background-color: #0e123e; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='white'; this.style.color='#0e123e';" onmouseout="this.style.backgroundColor='#0e123e'; this.style.color='white';">إضافة فئة</a>

                <!-- جدول لعرض جميع الفئات -->
                <table class="table table-bordered">
                        <thead>
                                <tr>
                                        <th>ID</th>
                                        <th>الاسم</th>
                                        <th>الإجراءات</th>
                                </tr>
                        </thead>
                        <tbody>
                                @forelse ($categories as $category)
                                        <tr>
                                                <td>{{ $category->id }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>
                                                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info btn-sm">
                                                                <i class="fas fa-eye"></i> <!-- أيقونة العرض -->
                                                        </a>
                                                        <!-- زر الحذف -->
                                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذه الفئة؟');" style="display: inline;">
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
                                                <td colspan="3" class="text-center">لم يتم العثور على فئات.</td>
                                        </tr>
                                @endforelse
                        </tbody>
                </table>
        </div>
@endsection