@auth
    <form action="{{ $route }}" method="POST">
        @csrf
        <div class="mb-3">
            <textarea name="content" id="content" class="form-control" cols="30" rows="10"></textarea>
        </div>
        <div class="d-grid gap-2">
            <input type="submit" value="Add comment" class="btn btn-primary btn-block">
        </div>
    </form>
    @errors()@enderrors
@else
    <a href="{{ route('login') }}">Sign in to post comments.</a>
@endauth
