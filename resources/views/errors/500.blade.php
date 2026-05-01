@extends('layout.main')

@section('title', 'Server Error')

@section('content')
    <div class="text-center py-5">
        <h1 class="display-1 text-danger">500</h1>
        <h2 class="mb-4">Something went wrong</h2>
        <p class="text-muted">We're working on it. Please try again later.</p>
        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Go Home</a>
    </div>
@endsection
