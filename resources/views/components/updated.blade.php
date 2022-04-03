    <!-- Because you are alive, everything is possible. - Thich Nhat Hanh -->
    <p class="text-muted">
        {{ empty(trim($slot)) ? 'Added' : $slot }} {{ $date }}
        @if (!empty(trim($name)))
            @if (isset($userId))
                by <a href="{{ route('users.show', ['user' => $userId]) }}">{{ $name }}</a>
            @else
                by {{ $name }}
            @endif
        @endif
    </p>
