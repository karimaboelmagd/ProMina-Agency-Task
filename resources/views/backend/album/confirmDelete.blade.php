<h1>Confirm Delete</h1>
<p>Album is not empty. Choose an action:</p>

<form method="POST" action="{{ route('albums.destroyWithPictures', $album) }}">
    @csrf
    @method('DELETE')
    <button type="submit">Delete All Pictures and Album</button>
</form>

<form method="POST" action="{{ route('albums.movePicturesForm', $album) }}">
    @csrf
    <label for="new_album_id">Move Pictures to:</label>
    <select name="new_album_id" id="new_album_id">
        @foreach($albums as $optionAlbum)
            <option value="{{ $optionAlbum->id }}">{{ $optionAlbum->name }}</option>
        @endforeach
    </select>
    <button type="submit">Move Pictures and Delete Album</button>
</form>
