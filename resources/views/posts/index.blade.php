@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
    <div class="row">
        <div class="col-8">
            @forelse ($posts as $post)
                <p>

                <h3>
                    @if ($post->trashed())
                        <del>
                    @endif
                    <a class="{{ $post->trashed() ? 'text-muted' : '' }}"
                        href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                    @if ($post->trashed())
                        </del>
                    @endif
                </h3>

                {{-- <p class="text-muted">
                    Added {{ $post->created_at->diffForHumans() }}
                    by {{ $post->user->name }}
                </p> --}}

                <x-updated date="{{ $post->created_at->diffForHumans() }}" name="{{ $post->user->name }}"
                    userId="{{ $post->user->id }}" />

                @tags(['tags'=>$post->tags])@endtags


                @if ($post->comments_count)
                    <p>{{ $post->comments_count }} comments</p>
                @else
                    <p>No comments yet!</p>
                @endif

                @auth
                    @can('update', $post)
                        <div class="d-inline">
                            <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">
                                Edit
                            </a>
                        </div>
                    @endcan


                    {{-- @cannot('delete', $post)
                    <p>You can't delete this post</p>
                @endcannot --}}

                    @if (!$post->trashed())
                        @can('delete', $post)
                            <form method="POST" class="d-inline"
                                action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                                @csrf
                                @method('DELETE')

                                <input type="submit" value="Delete!" class="btn btn-primary" />
                            </form>
                        @endcan
                    @endif
                @endauth
                </p>
            @empty
                <p>No blog posts yet!</p>
            @endforelse
        </div>

        <div class="col-4">
            <div class="container">
                @include('posts.partials.activity')
            </div>
        </div>
    @endsection('content')
