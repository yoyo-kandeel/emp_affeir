@extends('layouts.master')
@section('title', 'قائمة المنشآت')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>قائمة المنشآت</h2>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>اللوجو</th>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>الهاتف</th>
                <th>العنوان</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($organizations as $org)
            <tr>
                <td style="width:70px;">
                    @if($org->logo)
                        <img src="{{ asset('storage/'.$org->logo) }}" 
                             alt="Logo" 
                             style="width:50px; height:50px; object-fit:cover; border-radius:5px;">
                    @else
                        ---
                    @endif
                </td>
                <td>{{ $org->name }}</td>
                <td>{{ $org->email ?? '-' }}</td>
                <td>{{ $org->phone ?? '-' }}</td>
                <td>{{ $org->address ?? '-' }}</td>
                <td>
                    <a href="{{ route('organizations.edit', $org->id) }}" 
                       class="btn btn-sm btn-warning" 
                       title="تعديل المنشأة">
                       <i class="fas fa-edit"></i> تعديل
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">لا توجد منشآت</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $organizations->links() }}
</div>
@endsection
