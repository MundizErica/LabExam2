@extends('layouts.app')

@section('title', '500 – Server Error')
@section('page-title', 'Error 500')

@section('content')
<div class="text-center py-5">
    <div style="font-size:5rem; color:#e0e0e0; font-weight:700; line-height:1;">500</div>
    <h4 class="fw-semibold mt-3 mb-2">Server Error</h4>
    <p class="text-muted mb-4">Something went wrong on our end. Please try again later.</p>
    <a href="{{ route('dashboard') }}" class="btn btn-brand px-4">
        <i class="bi bi-house me-2"></i>Back to Dashboard
    </a>
</div>
@endsection
