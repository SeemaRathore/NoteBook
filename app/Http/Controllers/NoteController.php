<?php

namespace App\Http\Controllers;

use App\Helpers\TaggingHelper;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;



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
    // NoteController@update method
    public function update(Request $request, Note $note)
    {
        $note->update($request->validate([
            'title' => 'required',
            'description' => 'required',
        ]));

        if ($request->hasFile('cover_photo')) {
            // Handle file upload if a new image is provided
            $image = $request->file('cover_photo');
            $path = $image->store('images', 'public');

            // If an existing image exists, delete it
            if ($note->cover_photo) {
                Storage::disk('public')->delete($note->cover_photo);
            }

            // Update cover photo attribute with the new image path
            $note->cover_photo = $path;
        }

        $note->save();

        $this->extracted($note);

        return redirect()->route('notes.index')->with('success', 'NoteBook was edited!');
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

    public function updateTagEnd(Request $request)
    {
        // Get the current timestamp
        $currentTime = Carbon::now();

        // Get the latest note added before the end of the current date
        $latestNote = Note::whereDate('created_at', '<=', $currentTime)
            ->latest()
            ->first();

        if ($latestNote) {
            // Update the tag_end column for the latest note with the current timestamp
            $latestNote->update(['tag_end' => $currentTime]);
            return response()->json(['message' => 'Tag_end column updated for the latest note added before the end of the day.']);
        } else {
            return response()->json(['message' => 'No notes found to update tag_end column.'], 404);
        }
    }

}
