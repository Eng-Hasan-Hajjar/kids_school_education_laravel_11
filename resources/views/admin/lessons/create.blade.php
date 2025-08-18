@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Create Lesson</h1>
        <form action="{{ route('lessons.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="Lesson_Title">Lesson Title</label>
                <input type="text" name="Lesson_Title" class="form-control @error('Lesson_Title') is-invalid @enderror" value="{{ old('Lesson_Title') }}">
                @error('Lesson_Title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="unit_id">Unit</label>
                <select name="unit_id" class="form-control @error('unit_id') is-invalid @enderror">
                    <option value="">Select Unit</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->Unit_Title }}</option>
                    @endforeach
                </select>
                @error('unit_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3">Create Lesson</button>
        </form>
    </div>
@endsection