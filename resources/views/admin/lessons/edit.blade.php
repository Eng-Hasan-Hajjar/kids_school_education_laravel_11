@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Lesson</h1>
        <form action="{{ route('lessons.update', $lesson->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="Lesson_Title">Lesson Title</label>
                <input type="text" name="Lesson_Title" class="form-control @error('Lesson_Title') is-invalid @enderror" value="{{ old('Lesson_Title', $lesson->Lesson_Title) }}">
                @error('Lesson_Title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="unit_id">Unit</label>
                <select name="unit_id" class="form-control @error('unit_id') is-invalid @enderror">
                    <option value="">Select Unit</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ old('unit_id', $lesson->unit_id) == $unit->id ? 'selected' : '' }}>{{ $unit->Unit_Title }}</option>
                    @endforeach
                </select>
                @error('unit_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update Lesson</button>
            <a href="{{ route('lessons.index') }}" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
@endsection