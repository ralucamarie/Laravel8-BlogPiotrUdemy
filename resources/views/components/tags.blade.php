    <!-- It is not the man who has too little, but the man who craves more, that is poor. - Seneca -->
    <p>
        @foreach ($tags as $tag)
            <a href="{{ route('posts.tags.index', ['tag' => $tag->id]) }}"
                class="badge bg-success badge-lg">{{ $tag->name }}</a>
        @endforeach
    </p>
