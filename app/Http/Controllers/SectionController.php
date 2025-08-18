<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SectionController extends Controller
{
    public function index(Request $request)
    {
        $sections = Section::query()->paginate(10);
        return view('admin.sections.index', compact('sections'));
    }

    public function create()
    {
        return view('admin.sections.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Section_Title' => 'required|string|max:255',
            'Section_Description' => 'required|string',
        ], [
            'Section_Title.required' => 'The section title is required.',
            'Section_Title.string' => 'The section title must be a string.',
            'Section_Title.max' => 'The section title must not exceed 255 characters.',
            'Section_Description.required' => 'The section description is required.',
            'Section_Description.string' => 'The section description must be a string.',
        ]);

        try {
            Log::info('Attempting to create section', ['data' => $validatedData]);
            $section = Section::create($validatedData);
            Log::info('Section created successfully', ['section_id' => $section->id]);
            return redirect()->route('sections.index')->with('success', 'Section created successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to create section', ['error' => $e->getMessage(), 'data' => $validatedData]);
            return redirect()->back()->with('error', 'Failed to create section: ' . $e->getMessage());
        }
    }

    public function show(Section $section)
    {
        $section->load('units', 'users');
        return view('admin.sections.show', compact('section'));
    }

    public function edit(Section $section)
    {
        return view('admin.sections.edit', compact('section'));
    }

    public function update(Request $request, Section $section)
    {
        $validatedData = $request->validate([
            'Section_Title' => 'required|string|max:255',
            'Section_Description' => 'required|string',
        ], [
            'Section_Title.required' => 'The section title is required.',
            'Section_Title.string' => 'The section title must be a string.',
            'Section_Title.max' => 'The section title must not exceed 255 characters.',
            'Section_Description.required' => 'The section description is required.',
            'Section_Description.string' => 'The section description must be a string.',
        ]);

        try {
            Log::info('Attempting to update section', ['section_id' => $section->id, 'data' => $validatedData]);
            $section->update($validatedData);
            Log::info('Section updated successfully', ['section_id' => $section->id]);
            return redirect()->route('sections.index')->with('success', 'Section updated successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to update section', ['section_id' => $section->id, 'error' => $e->getMessage(), 'data' => $validatedData]);
            return redirect()->back()->with('error', 'Failed to update section: ' . $e->getMessage());
        }
    }

    public function destroy(Section $section)
    {
        try {
            Log::info('Attempting to delete section', ['section_id' => $section->id]);
            $section->delete();
            Log::info('Section deleted successfully', ['section_id' => $section->id]);
            return redirect()->route('sections.index')->with('success', 'Section deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed to delete section', ['section_id' => $section->id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to delete section: ' . $e->getMessage());
        }
    }
}