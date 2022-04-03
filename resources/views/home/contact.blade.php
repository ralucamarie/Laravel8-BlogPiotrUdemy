@extends('layouts.app')

@section('title','Contact')

@section('content')

<h1>Contact Page</h1>
@can('home.secret')
    <p>
        <a href="{{ route('secret') }}">
            Go to special contact details
        </a>
    </p>
@endcan

@endsection