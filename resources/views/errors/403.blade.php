@extends('layout.main')

@section('title', 'Access Denied')

@section('content')
    <div class="text-center py-5">
        <h1 class="display-1 text-warning">403</h1>
        <h2 class="mb-4">Access Denied</h2>
        <p class="text-muted">You do not have permission to access this page.</p>
        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Go Home</a>
    </div>
@endsection
