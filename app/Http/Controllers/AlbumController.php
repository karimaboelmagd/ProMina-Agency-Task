<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $albums = Album::with('pictures')->latest()->get();
        return view('backend.album.index', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.album.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'pictures' => 'required|image|max:1999',
        ]);

        // Get filename with extension
        $filenameWithExt = $request->file('pictures')->getClientOriginalName();

        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        // Get just extension
        $extension = $request->file('pictures')->getClientOriginalExtension();

        // Filename to store
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;

        // Upload image
        $path = $request->file('pictures')->move(public_path('upload/album_pictures'), $fileNameToStore);

        // Create album
        $album = new Album;
        $album->name = $request->input('name');
        $album->pictures = $fileNameToStore;
        $album->save();


        return redirect()->route('album.index')->with('success', 'Album Created Successfully ');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $album=Album::findOrFail($id);
        if($album){

            return view('backend.album.edit', compact('album'));

        }else{
            return back()->with('error','Album Not Found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Album $album)
    {
        $request->validate([
            'name' => 'required',
        ]);

        // Update album details
        $album->name = $request->input('name');

        // Check if a new cover image is uploaded
        if ($request->hasFile('pictures')) {
            $request->validate([
                'pictures' => 'image|max:1999', // max size 1999KB
            ]);

            // Get filename with extension
            $filenameWithExt = $request->file('pictures')->getClientOriginalName();

            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // Get just extension
            $extension = $request->file('pictures')->getClientOriginalExtension();

            // Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            // Upload new image
            $path = $request->file('pictures')->move(public_path('upload/album_pictures'), $fileNameToStore);

            // Delete previous cover image if exists
            if (public_path('upload/album_pictures/' . $album->pictures)) {
                unlink(public_path('upload/album_pictures/' . $album->pictures));
            }

            // Update album cover image
            $album->pictures = $fileNameToStore;
        }
        $album->save();

        return redirect()->route('album.index')->with('success', 'Album Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {

        if ($album->pictures->isNotEmpty()) {
            return redirect()->route('albums.confirmDelete', $album);
        }

        $album->delete();

        return redirect()->route('album.index')->with('success', 'Album deleted successfully.');

    }

    // Additional Methods for Handling Album Pictures

    public function confirmDelete(Album $album)
    {
        $albums = Album::where('id', '!=', $album->id)->get();
        return view('album.confirmDelete', compact('album', 'albums'));    }

    public function movePictures(Request $request, Album $album)
    {
        $request->validate([
            'new_album_id' => 'required|exists:albums,id',
        ]);

        $newAlbum = Album::findOrFail($request->new_album_id);
        $album->pictures()->update(['album_id' => $newAlbum->id]);
        $album->delete();

        return redirect()->route('album.index')
            ->with('success', 'All pictures moved and album deleted successfully.');
    }
    public function movePicturesForm(Request $request, Album $album)
    {
        $request->validate([
            'new_album_id' => 'required|exists:albums,id',
        ]);

        return redirect()->route('albums.movePictures', [$album->id, 'new_album_id' => $request->new_album_id]);
    }


}
