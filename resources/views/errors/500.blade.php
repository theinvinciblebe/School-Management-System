@extends('layout.main')

@section('title', __('Server Error'))

@section('content')
    <div class="text-center py-5">
        <h1 class="display-1 text-danger">500</h1>
        <h2 class="mb-4">{{ __('Something went wrong') }}</h2>
        <p class="text-muted">{{ __('We\'re working on it. Please try again later.') }}</p>
        <a href="{{ url('/') }}" class="btn btn-primary mt-3">{{ __('Go Home') }}</a>
    </div>
@endsection
