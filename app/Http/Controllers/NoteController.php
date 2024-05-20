<?php

namespace App\Http\Controllers;

use App\Helpers\TaggingHelper;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $tags = array_values(TaggingHelper::getTags());

        return inertia(
            'Notes/index',
            [
                'filters' => $request->only([
                    'tag'
                ]),
                'tags' => $tags,
                'notes' => Note::orderByDesc('created_at')
                    ->paginate(10)
            ]
        );

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia(
            'Notes/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Create the note
        $note = $request->user()->notes()->create(
            $request->validate([
                'title' => 'required',
                'description' => 'required',
            ])
        );

        //Added Tags Logic Here

        // Retrieve the list of tags
        $this->extracted($note);


        // Handle cover photo upload if present
        if ($request->hasFile('cover_photo')) {
            $image = $request->file('cover_photo');
            $path = $image->store('images', 'public');
            $note->cover_photo = $path;
            $note->save();
        }

        return redirect()->route('notes.index')->with('success', 'NoteBook was created!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        return inertia(
            'Notes/Show',
            [
                'notes' => $note
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        return inertia(
            'Notes/Edit',
            [
                'notes' => $note
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {

        $note->update(
            $request->validate([
                'title' => 'required',
                'description' => 'required',

            ])
        );

        $this->extracted($note);

        if ($request->hasFile('cover_photo')) {
            $image = $request->file('cover_photo');
            $path = $image->store('images', 'public');
            $note->cover_photo = $path;
            $note->save();
        }


        return redirect()->route('notes.index')
            ->with('success', 'NoteBook was edited!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        // Delete cover photo from storage
        if ($note->cover_photo) {
            Storage::disk('public')->delete($note->cover_photo);
        }

        // Delete the note
        $note->deleteOrFail();

        return redirect()->back()
            ->with('success', 'NoteBook was deleted!');
    }

    /**
     * @param Note $note
     * @return void
     */
    public function extracted(Note $note): void
    {
        $tags = TaggingHelper::getTags();

        // Iterate through the tags and check for matches
        $tags_match = [];

        // Check if any keyword is found in the title or description
        foreach ($tags as $keyword => $tag) {
            if (stripos($note->title, $keyword) !== false || stripos($note->description, $keyword) !== false) {
                // Keyword found, add corresponding tag to the array
                $tags_match[] = $tag;
            }
        }

        // Assign tags to the note
        $note->tags = implode(',', $tags_match);
        $note->save();
    }

}
