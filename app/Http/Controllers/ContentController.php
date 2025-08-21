<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $contents = Content::query()->with('lesson')->paginate(10);
        return view('admin.contents.index', compact('contents'));
    }

    public function create()
    {
        $lessons = Lesson::all();
        return view('admin.contents.create', compact('lessons'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'sound' => 'nullable|mimes:mp3,wav,ogg,m4a|max:10240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Text' => 'required|string',
        ], [
            'lesson_id.required' => 'The lesson field is required.',
            'lesson_id.exists' => 'The selected lesson is invalid.',
            'sound.mimes' => 'The sound must be an audio file of type: mp3, wav, ogg, m4a.',
            'sound.max' => 'The sound file must not exceed 10MB.',
            'image.image' => 'The image must be an image file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image file must not exceed 2MB.',
            'Text.required' => 'The content text is required.',
            'Text.string' => 'The content text must be a string.',
        ]);

        try {
            Log::info('Attempting to create content', ['data' => $validatedData]);

            if ($request->hasFile('image')) {
                $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('uploads/images'), $imageName);
                $validatedData['image'] = 'uploads/images/' . $imageName;
            }

            if ($request->hasFile('sound')) {
                $soundName = time() . '_' . uniqid() . '.' . $request->file('sound')->getClientOriginalExtension();
                $request->file('sound')->move(public_path('uploads/audios'), $soundName);
                $validatedData['sound'] = 'uploads/audios/' . $soundName;
            }

            $content = Content::create($validatedData);
            Log::info('Content created successfully', ['content_id' => $content->id]);
            return redirect()->route('contents.index')->with('success', 'Content created successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to create content', ['error' => $e->getMessage(), 'data' => $validatedData]);
            return redirect()->back()->with('error', 'Failed to create content: ' . $e->getMessage());
        }
    }

    public function show(Content $content)
    {
        $content->load('lesson');
        return view('admin.contents.show', compact('content'));
    }

    public function edit(Content $content)
    {
        $lessons = Lesson::all();
        return view('admin.contents.edit', compact('content', 'lessons'));
    }

    public function update(Request $request, Content $content)
    {
        $validatedData = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'sound' => 'nullable|mimes:mp3,wav,ogg,m4a|max:10240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Text' => 'required|string',
        ], [
            'lesson_id.required' => 'The lesson field is required.',
            'lesson_id.exists' => 'The selected lesson is invalid.',
            'sound.mimes' => 'The sound must be an audio file of type: mp3, wav, ogg, m4a.',
            'sound.max' => 'The sound file must not exceed 10MB.',
            'image.image' => 'The image must be an image file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image file must not exceed 2MB.',
            'Text.required' => 'The content text is required.',
            'Text.string' => 'The content text must be a string.',
        ]);

        try {
            Log::info('Attempting to update content', ['content_id' => $content->id, 'data' => $validatedData]);

            if ($request->hasFile('image')) {
                if ($content->image && file_exists(public_path($content->image))) {
                    unlink(public_path($content->image));
                }
                $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('uploads/images'), $imageName);
                $validatedData['image'] = 'uploads/images/' . $imageName;
            }

            if ($request->hasFile('sound')) {
                if ($content->sound && file_exists(public_path($content->sound))) {
                    unlink(public_path($content->sound));
                }
                $soundName = time() . '_' . uniqid() . '.' . $request->file('sound')->getClientOriginalExtension();
                $request->file('sound')->move(public_path('uploads/audios'), $soundName);
                $validatedData['sound'] = 'uploads/audios/' . $soundName;
            }

            $content->update($validatedData);
            Log::info('Content updated successfully', ['content_id' => $content->id]);
            return redirect()->route('contents.index')->with('success', 'Content updated successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to update content', ['content_id' => $content->id, 'error' => $e->getMessage(), 'data' => $validatedData]);
            return redirect()->back()->with('error', 'Failed to update content: ' . $e->getMessage());
        }
    }

    public function destroy(Content $content)
    {
        try {
            Log::info('Attempting to delete content', ['content_id' => $content->id]);

            if ($content->image && file_exists(public_path($content->image))) {
                unlink(public_path($content->image));
            }

            if ($content->sound && file_exists(public_path($content->sound))) {
                unlink(public_path($content->sound));
            }

            $content->delete();
            Log::info('Content deleted successfully', ['content_id' => $content->id]);
            return redirect()->route('contents.index')->with('success', 'Content deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to delete content', ['content_id' => $content->id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to delete content: ' . $e->getMessage());
        }
    }
}