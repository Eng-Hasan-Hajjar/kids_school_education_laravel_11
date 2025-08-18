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
            'sound' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
        ], [
            'quiz_id.required' => 'The quiz field is required.',
            'quiz_id.exists' => 'The selected quiz is invalid.',
            'Question_Text.required' => 'The question text is required.',
            'Question_Text.string' => 'The question text must be a string.',
            'sound.string' => 'The sound must be a string.',
            'sound.max' => 'The sound path must not exceed 255 characters.',
            'image.string' => 'The image must be a string.',
            'image.max' => 'The image path must not exceed 255 characters.',
        ]);

        try {
            Log::info('Attempting to create question', ['data' => $validatedData]);
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
            'sound' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
        ], [
            'quiz_id.required' => 'The quiz field is required.',
            'quiz_id.exists' => 'The selected quiz is invalid.',
            'Question_Text.required' => 'The question text is required.',
            'Question_Text.string' => 'The question text must be a string.',
            'sound.string' => 'The sound must be a string.',
            'sound.max' => 'The sound path must not exceed 255 characters.',
            'image.string' => 'The image must be a string.',
            'image.max' => 'The image path must not exceed 255 characters.',
        ]);

        try {
            Log::info('Attempting to update question', ['question_id' => $question->id, 'data' => $validatedData]);
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
            $question->delete();
            Log::info('Question deleted successfully', ['question_id' => $question->id]);
            return redirect()->route('questions.index')->with('success', 'Question deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to delete question', ['question_id' => $question->id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to delete question: ' . $e->getMessage());
        }
    }
}