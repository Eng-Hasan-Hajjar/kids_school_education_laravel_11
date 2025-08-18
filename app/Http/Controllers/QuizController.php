<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $quizzes = Quiz::query()->with('unit')->paginate(10);
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $units = Unit::all();
        return view('admin.quizzes.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'Quiz_Title' => 'required|string|max:255',
        ], [
            'unit_id.required' => 'The unit field is required.',
            'unit_id.exists' => 'The selected unit is invalid.',
            'Quiz_Title.required' => 'The quiz title is required.',
            'Quiz_Title.string' => 'The quiz title must be a string.',
            'Quiz_Title.max' => 'The quiz title must not exceed 255 characters.',
        ]);

        try {
            Log::info('Attempting to create quiz', ['data' => $validatedData]);
            $quiz = Quiz::create($validatedData);
            Log::info('Quiz created successfully', ['quiz_id' => $quiz->id]);
            return redirect()->route('quizzes.index')->with('success', 'Quiz created successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to create quiz', ['error' => $e->getMessage(), 'data' => $validatedData]);
            return redirect()->back()->with('error', 'Failed to create quiz: ' . $e->getMessage());
        }
    }

    public function show(Quiz $quiz)
    {
        $quiz->load('unit', 'questions');
        return view('admin.quizzes.show', compact('quiz'));
    }

    public function edit(Quiz $quiz)
    {
        $units = Unit::all();
        return view('admin.quizzes.edit', compact('quiz', 'units'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validatedData = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'Quiz_Title' => 'required|string|max:255',
        ], [
            'unit_id.required' => 'The unit field is required.',
            'unit_id.exists' => 'The selected unit is invalid.',
            'Quiz_Title.required' => 'The quiz title is required.',
            'Quiz_Title.string' => 'The quiz title must be a string.',
            'Quiz_Title.max' => 'The quiz title must not exceed 255 characters.',
        ]);

        try {
            Log::info('Attempting to update quiz', ['quiz_id' => $quiz->id, 'data' => $validatedData]);
            $quiz->update($validatedData);
            Log::info('Quiz updated successfully', ['quiz_id' => $quiz->id]);
            return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to update quiz', ['quiz_id' => $quiz->id, 'error' => $e->getMessage(), 'data' => $validatedData]);
            return redirect()->back()->with('error', 'Failed to update quiz: ' . $e->getMessage());
        }
    }

    public function destroy(Quiz $quiz)
    {
        try {
            Log::info('Attempting to delete quiz', ['quiz_id' => $quiz->id]);
            $quiz->delete();
            Log::info('Quiz deleted successfully', ['quiz_id' => $quiz->id]);
            return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to delete quiz', ['quiz_id' => $quiz->id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to delete quiz: ' . $e->getMessage());
        }
    }
}