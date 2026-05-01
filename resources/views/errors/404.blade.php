@extends('layout.main')

@section('title', 'Page Not Found')

@section('content')
    <div class="text-center py-5">
        <h1 class="display-1 text-danger">404</h1>
        <h2 class="mb-4">Oops! Page Not Found</h2>
        <p class="text-muted">The page you're looking for doesn't exist.</p>
        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Go Home</a>
    </div>
@endsection
