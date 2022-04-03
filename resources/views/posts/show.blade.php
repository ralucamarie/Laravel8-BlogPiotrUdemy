@extends('layouts.app')

@section('title', $posts->title)



@section('content')
    <div class="row">
        <div class="col-8">
            @if ($posts->image)
                <div
                    style="background-image: url('{{ $posts->image->url() }}');min-height: 300px; color:white; text-align:center; background-attachment:fixed;">

                    <h1 style="padding-top:100px; text-shadow: 1px 2px #000">
                    @else
                        <h1>
            @endif

            {{ $posts->title }}

            @if (now()->diffInMinutes($posts->created_at) < 20)
                <x-badge type='success' message="Brand new Post!" />
            @endif

            @if ($posts->image)
                </h1>
        </div>
    @else
        </h1>
        @endif

        <p>{{ $posts->content }}</p>
        <x-updated date="{{ $posts->created_at->diffForHumans() }}" name="{{ $posts->user->name }}"
            userId="{{ $posts->user->id }}" />
        <x-updated date="{{ $posts->updated_at->diffForHumans() }}" name="" userId="">Updated </x-updated>

        @tags(['tags'=>$posts->tags])@endtags

        <p>Currently read by {{ $counter }} people</p>
        <h4>Comments</h4>

        @commentForm(['route'=>route('posts.comments.store', ['post'=>$posts->id])])
        @endcommentForm

        @commentsList(['comments'=>$posts->comments])
        @endcommentsList
    </div>

    <div class="col-4">
        <div class="container">
            @include('posts.partials.activity')
        </div>
    </div>
    </div>

@endsection
