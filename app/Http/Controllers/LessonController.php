<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Lesson;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LessonController extends Controller
{

    public function index(Request $request)
    {
       // $this->authorize('viewAny', Lesson::class);
        
        $query = Lesson::query();
        
        // Filter by unit_id if provided
        if ($request->has('unit_id') && $request->unit_id != '') {
            $query->where('unit_id', $request->unit_id);
        }

        $lessons = $query->with('unit')->paginate(10);
        $units = Unit::all();

        return view('admin.lessons.index', compact('lessons', 'units'));
    }

    public function create()
    {
      //  $this->authorize('create', Lesson::class);
        $units = Unit::all();
        return view('admin.lessons.create', compact('units'));
    }

    public function store(Request $request)
    {
      //  $this->authorize('create', Lesson::class);
        
        $validatedData = $request->validate([
            'Lesson_Title' => 'required|max:255',
            'unit_id' => 'required|exists:units,id',
        ], [
            'Lesson_Title.required' => 'The lesson title is required.',
            'Lesson_Title.max' => 'The lesson title must not exceed 255 characters.',
            'unit_id.required' => 'The unit field is required.',
            'unit_id.exists' => 'The selected unit is invalid.',
        ]);

        try {
            Lesson::create($validatedData);
            return redirect()->route('lessons.index')->with('success', 'Lesson created successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the lesson. Please try again.');
        }
    }

    public function show(Lesson $lesson)
    {
       // $this->authorize('view', $lesson);
        $lesson->load('unit', 'contents');
        return view('admin.lessons.show', compact('lesson'));
    }

    public function edit(Lesson $lesson)
    {
      //  $this->authorize('update', $lesson);
        $units = Unit::all();
        return view('admin.lessons.edit', compact('lesson', 'units'));
    }

    public function update(Request $request, Lesson $lesson)
    {
      //  $this->authorize('update', $lesson);
        
        $validatedData = $request->validate([
            'Lesson_Title' => 'required|max:255',
            'unit_id' => 'required|exists:units,id',
        ], [
            'Lesson_Title.required' => 'The lesson title is required.',
            'Lesson_Title.max' => 'The lesson title must not exceed 255 characters.',
            'unit_id.required' => 'The unit field is required.',
            'unit_id.exists' => 'The selected unit is invalid.',
        ]);

        try {
            $lesson->update($validatedData);
            return redirect()->route('lessons.index')->with('success', 'Lesson updated successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the lesson. Please try again.');
        }
    }

    public function destroy(Lesson $lesson)
    {
     //   $this->authorize('delete', $lesson);
        $lesson->delete();
        return redirect()->route('lessons.index')->with('success', 'Lesson deleted successfully.');
    }
}
