@extends('layout.main')

@section('title', __('Access Denied'))

@section('content')
    <div class="text-center py-5">
        <h1 class="display-1 text-warning">403</h1>
        <h2 class="mb-4">{{ __('Access Denied') }}</h2>
        <p class="text-muted">{{ __('You do not have permission to access this page.') }}</p>
        <a href="{{ url('/') }}" class="btn btn-primary mt-3">{{ __('Go Home') }}</a>
    </div>
@endsection
