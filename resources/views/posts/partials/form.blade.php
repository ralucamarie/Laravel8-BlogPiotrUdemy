<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input id="title" type="text" class="form-control" name="title"
        value="{{ old('title', optional($post ?? null)->title) }}">
</div>
@error('title')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

<div class="mb-3">
    <label for="content" class="form-label">Content</label>
    <textarea name="content" id="content" class="form-control" cols="30" rows="10">{{ old('content', optional($post ?? null)->content) }}
        </textarea>
</div>
<div class="mb-3">
    <label for="thumbnail" class="form-label">Title</label>
    <input id="thumbnail" type="file" class="form-control" name="thumbnail">
</div>
@errors()@enderrors
