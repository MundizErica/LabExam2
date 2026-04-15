@extends('layouts.app')

@section('title', '404 – Page Not Found')
@section('page-title', 'Error 404')

@section('content')
<div class="text-center py-5">
    <div style="font-size:5rem; color:#e0e0e0; font-weight:700; line-height:1;">404</div>
    <h4 class="fw-semibold mt-3 mb-2">Page Not Found</h4>
    <p class="text-muted mb-4">The page you're looking for doesn't exist or has been moved.</p>
    <a href="{{ route('dashboard') }}" class="btn btn-brand px-4">
        <i class="bi bi-house me-2"></i>Back to Dashboard
    </a>
</div>
@endsection
