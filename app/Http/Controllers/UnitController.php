<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Models\Unit;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UnitController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        
        $query = Unit::query();
        
        // Filter by section_id if provided
        if ($request->has('section_id') && $request->section_id != '') {
            $query->where('section_id', $request->section_id);
        }

        $units = $query->with('section')->paginate(10);
        $sections = Section::all();

        return view('admin.units.index', compact('units', 'sections'));
    }

    public function create()
    {
        $sections = Section::all();
        return view('admin.units.create', compact('sections'));
    }

    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'Unit_Title' => 'required|max:255',
            'section_id' => 'required|exists:sections,id',
        ], [
            'Unit_Title.required' => 'The unit title is required.',
            'Unit_Title.max' => 'The unit title must not exceed 255 characters.',
            'section_id.required' => 'The section field is required.',
            'section_id.exists' => 'The selected section is invalid.',
        ]);

        try {
            Unit::create($validatedData);
            return redirect()->route('units.index')->with('success', 'Unit created successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the unit. Please try again.');
        }
    }

    public function show(Unit $unit)
    {
        $unit->load('section', 'lessons', 'quizzes');
        return view('admin.units.show', compact('unit'));
    }

    public function edit(Unit $unit)
    {
        $sections = Section::all();
        return view('admin.units.edit', compact('unit', 'sections'));
    }

    public function update(Request $request, Unit $unit)
    {
        
        $validatedData = $request->validate([
            'Unit_Title' => 'required|max:255',
            'section_id' => 'required|exists:sections,id',
        ], [
            'Unit_Title.required' => 'The unit title is required.',
            'Unit_Title.max' => 'The unit title must not exceed 255 characters.',
            'section_id.required' => 'The section field is required.',
            'section_id.exists' => 'The selected section is invalid.',
        ]);

        try {
            $unit->update($validatedData);
            return redirect()->route('units.index')->with('success', 'Unit updated successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the unit. Please try again.');
        }
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('units.index')->with('success', 'Unit deleted successfully.');
    }
}