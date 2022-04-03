@extends('layouts.app')

@section('content')
    @csrf

    @method('PUT')

    <div class="row">
        <div class="col-4">
            <img src="{{ $user->image ? $user->image->url() : '' }}" alt="" class="img-thumbnail  mb-3">

        </div>
        <div class="col-8">
            <h3>{{ $user->name }}</h3>
            @commentForm(['route'=>route('users.comments.store', ['user'=>$user->id])])
            @endcommentForm

            @commentsList(['comments'=>$user->commentsOn])
            @endcommentsList
        </div>

    </div>
@endsection
