<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::query()->with('quiz')->paginate(10);
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $quizzes = Quiz::all();
        return view('admin.questions.create', compact('quizzes'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'Question_Text' => 'required|string',
            'sound' => 'nullable|mimes:mp3,wav,ogg,m4a|max:10240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'quiz_id.required' => 'The quiz field is required.',
            'quiz_id.exists' => 'The selected quiz is invalid.',
            'Question_Text.required' => 'The question text is required.',
            'Question_Text.string' => 'The question text must be a string.',
            'sound.mimes' => 'The sound must be an audio file of type: mp3, wav, ogg, m4a.',
            'sound.max' => 'The sound file must not exceed 10MB.',
            'image.image' => 'The image must be an image file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image file must not exceed 2MB.',
        ]);

        try {
            Log::info('Attempting to create question', ['data' => $validatedData]);

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

            $question = Question::create($validatedData);
            Log::info('Question created successfully', ['question_id' => $question->id]);
            return redirect()->route('questions.index')->with('success', 'Question created successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to create question', ['error' => $e->getMessage(), 'data' => $validatedData]);
            return redirect()->back()->with('error', 'Failed to create question: ' . $e->getMessage());
        }
    }

    public function show(Question $question)
    {
        $question->load('quiz', 'answers');
        return view('admin.questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        $quizzes = Quiz::all();
        return view('admin.questions.edit', compact('question', 'quizzes'));
    }

    public function update(Request $request, Question $question)
    {
        $validatedData = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'Question_Text' => 'required|string',
            'sound' => 'nullable|mimes:mp3,wav,ogg,m4a|max:10240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'quiz_id.required' => 'The quiz field is required.',
            'quiz_id.exists' => 'The selected quiz is invalid.',
            'Question_Text.required' => 'The question text is required.',
            'Question_Text.string' => 'The question text must be a string.',
            'sound.mimes' => 'The sound must be an audio file of type: mp3, wav, ogg, m4a.',
            'sound.max' => 'The sound file must not exceed 10MB.',
            'image.image' => 'The image must be an image file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image file must not exceed 2MB.',
        ]);

        try {
            Log::info('Attempting to update question', ['question_id' => $question->id, 'data' => $validatedData]);

            if ($request->hasFile('image')) {
                if ($question->image && file_exists(public_path($question->image))) {
                    unlink(public_path($question->image));
                }
                $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('uploads/images'), $imageName);
                $validatedData['image'] = 'uploads/images/' . $imageName;
            }

            if ($request->hasFile('sound')) {
                if ($question->sound && file_exists(public_path($question->sound))) {
                    unlink(public_path($question->sound));
                }
                $soundName = time() . '_' . uniqid() . '.' . $request->file('sound')->getClientOriginalExtension();
                $request->file('sound')->move(public_path('uploads/audios'), $soundName);
                $validatedData['sound'] = 'uploads/audios/' . $soundName;
            }

            $question->update($validatedData);
            Log::info('Question updated successfully', ['question_id' => $question->id]);
            return redirect()->route('questions.index')->with('success', 'Question updated successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to update question', ['question_id' => $question->id, 'error' => $e->getMessage(), 'data' => $validatedData]);
            return redirect()->back()->with('error', 'Failed to update question: ' . $e->getMessage());
        }
    }

    public function destroy(Question $question)
    {
        try {
            Log::info('Attempting to delete question', ['question_id' => $question->id]);

            if ($question->image && file_exists(public_path($question->image))) {
                unlink(public_path($question->image));
            }

            if ($question->sound && file_exists(public_path($question->sound))) {
                unlink(public_path($question->sound));
            }

            $question->delete();
            Log::info('Question deleted successfully', ['question_id' => $question->id]);
            return redirect()->route('questions.index')->with('success', 'Question deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to delete question', ['question_id' => $question->id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to delete question: ' . $e->getMessage());
        }
    }
}