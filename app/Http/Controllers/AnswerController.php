<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnswerController extends Controller
{
    public function index(Request $request)
    {
        $answers = Answer::query()->with('question')->paginate(10);
        return view('admin.answers.index', compact('answers'));
    }

    public function create()
    {
        $questions = Question::all();
        return view('admin.answers.create', compact('questions'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'Answer_Text' => 'required|string',
            'Iscorrect' => 'required|boolean',
            'sound' => 'nullable|mimes:mp3,wav,ogg,m4a|max:10240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'question_id.required' => 'The question field is required.',
            'question_id.exists' => 'The selected question is invalid.',
            'Answer_Text.required' => 'The answer text is required.',
            'Answer_Text.string' => 'The answer text must be a string.',
            'Iscorrect.required' => 'The correct status is required.',
            'Iscorrect.boolean' => 'The correct status must be true or false.',
            'sound.mimes' => 'The sound must be an audio file of type: mp3, wav, ogg, m4a.',
            'sound.max' => 'The sound file must not exceed 10MB.',
            'image.image' => 'The image must be an image file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image file must not exceed 2MB.',
        ]);

        try {
            Log::info('Attempting to create answer', ['data' => $validatedData]);

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

            $answer = Answer::create($validatedData);
            Log::info('Answer created successfully', ['answer_id' => $answer->id]);
            return redirect()->route('answers.index')->with('success', 'Answer created successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to create answer', ['error' => $e->getMessage(), 'data' => $validatedData]);
            return redirect()->back()->with('error', 'Failed to create answer: ' . $e->getMessage());
        }
    }

    public function show(Answer $answer)
    {
        $answer->load('question');
        return view('admin.answers.show', compact('answer'));
    }

    public function edit(Answer $answer)
    {
        $questions = Question::all();
        return view('admin.answers.edit', compact('answer', 'questions'));
    }

    public function update(Request $request, Answer $answer)
    {
        $validatedData = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'Answer_Text' => 'required|string',
            'Iscorrect' => 'required|boolean',
            'sound' => 'nullable|mimes:mp3,wav,ogg,m4a|max:10240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'question_id.required' => 'The question field is required.',
            'question_id.exists' => 'The selected question is invalid.',
            'Answer_Text.required' => 'The answer text is required.',
            'Answer_Text.string' => 'The answer text must be a string.',
            'Iscorrect.required' => 'The correct status is required.',
            'Iscorrect.boolean' => 'The correct status must be true or false.',
            'sound.mimes' => 'The sound must be an audio file of type: mp3, wav, ogg, m4a.',
            'sound.max' => 'The sound file must not exceed 10MB.',
            'image.image' => 'The image must be an image file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image file must not exceed 2MB.',
        ]);

        try {
            Log::info('Attempting to update answer', ['answer_id' => $answer->id, 'data' => $validatedData]);

            if ($request->hasFile('image')) {
                if ($answer->image && file_exists(public_path($answer->image))) {
                    unlink(public_path($answer->image));
                }
                $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('uploads/images'), $imageName);
                $validatedData['image'] = 'uploads/images/' . $imageName;
            }

            if ($request->hasFile('sound')) {
                if ($answer->sound && file_exists(public_path($answer->sound))) {
                    unlink(public_path($answer->sound));
                }
                $soundName = time() . '_' . uniqid() . '.' . $request->file('sound')->getClientOriginalExtension();
                $request->file('sound')->move(public_path('uploads/audios'), $soundName);
                $validatedData['sound'] = 'uploads/audios/' . $soundName;
            }

            $answer->update($validatedData);
            Log::info('Answer updated successfully', ['answer_id' => $answer->id]);
            return redirect()->route('answers.index')->with('success', 'Answer updated successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to update answer', ['answer_id' => $answer->id, 'error' => $e->getMessage(), 'data' => $validatedData]);
            return redirect()->back()->with('error', 'Failed to update answer: ' . $e->getMessage());
        }
    }

    public function destroy(Answer $answer)
    {
        try {
            Log::info('Attempting to delete answer', ['answer_id' => $answer->id]);

            if ($answer->image && file_exists(public_path($answer->image))) {
                unlink(public_path($answer->image));
            }

            if ($answer->sound && file_exists(public_path($answer->sound))) {
                unlink(public_path($answer->sound));
            }

            $answer->delete();
            Log::info('Answer deleted successfully', ['answer_id' => $answer->id]);
            return redirect()->route('answers.index')->with('success', 'Answer deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to delete answer', ['answer_id' => $answer->id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to delete answer: ' . $e->getMessage());
        }
    }
}