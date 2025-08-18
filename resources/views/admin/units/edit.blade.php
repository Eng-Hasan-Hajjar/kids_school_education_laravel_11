@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Unit</h1>
        <form action="{{ route('units.update', $unit->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="Unit_Title">Unit Title</label>
                <input type="text" name="Unit_Title" class="form-control @error('Unit_Title') is-invalid @enderror" value="{{ old('Unit_Title', $unit->Unit_Title) }}">
                @error('Unit_Title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="section_id">Section</label>
                <select name="section_id" class="form-control @error('section_id') is-invalid @enderror">
                    <option value="">Select Section</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}" {{ old('section_id', $unit->section_id) == $section->id ? 'selected' : '' }}>{{ $section->Section_Title }}</option>
                    @endforeach
                </select>
                @error('section_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update Unit</button>
            <a href="{{ route('units.index') }}" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
@endsection