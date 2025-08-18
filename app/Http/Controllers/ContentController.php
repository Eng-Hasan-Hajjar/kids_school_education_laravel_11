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
            'sound' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'Text' => 'required|string',
        ], [
            'lesson_id.required' => 'The lesson field is required.',
            'lesson_id.exists' => 'The selected lesson is invalid.',
            'sound.string' => 'The sound must be a string.',
            'sound.max' => 'The sound path must not exceed 255 characters.',
            'image.string' => 'The image must be a string.',
            'image.max' => 'The image path must not exceed 255 characters.',
            'Text.required' => 'The content text is required.',
            'Text.string' => 'The content text must be a string.',
        ]);

        try {
            Log::info('Attempting to create content', ['data' => $validatedData]);
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
            'sound' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'Text' => 'required|string',
        ], [
            'lesson_id.required' => 'The lesson field is required.',
            'lesson_id.exists' => 'The selected lesson is invalid.',
            'sound.string' => 'The sound must be a string.',
            'sound.max' => 'The sound path must not exceed 255 characters.',
            'image.string' => 'The image must be a string.',
            'image.max' => 'The image path must not exceed 255 characters.',
            'Text.required' => 'The content text is required.',
            'Text.string' => 'The content text must be a string.',
        ]);

        try {
            Log::info('Attempting to update content', ['content_id' => $content->id, 'data' => $validatedData]);
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
            $content->delete();
            Log::info('Content deleted successfully', ['content_id' => $content->id]);
            return redirect()->route('contents.index')->with('success', 'Content deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to delete content', ['content_id' => $content->id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to delete content: ' . $e->getMessage());
        }
    }
}