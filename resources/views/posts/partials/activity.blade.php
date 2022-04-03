<div class="row">
    @component('components.card', [
        'title' => 'Most Commented',
        'subtitle' => 'What people are talking
        about.',
        ])
        @slot('items')
            @foreach ($mostCommented as $post)
                <li class="list-group-item">
                    <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                        {{ $post->title }}
                    </a>
                </li>
            @endforeach
        @endslot
    @endcomponent
</div>

<div class="row mt-4">
    @component('components.card', ['title' => 'Most Active', 'subtitle' => 'Users with most posts.'])
        @slot('items', collect($mostActive)->pluck('name'))
    @endcomponent
</div>

<div class="row mt-4">
    @component('components.card', [
        'title' => 'Most Active Last Month',
        'subtitle' => 'Users with most posts
        last month.',
        ])
        @slot('items', collect($mostActiveLastMonth)->pluck('name'))
    @endcomponent
</div>

</div>
