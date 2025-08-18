@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Create Quiz</h1>
        
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('quizzes.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="unit_id">Unit</label>
                <select name="unit_id" id="unit_id" class="form-control @error('unit_id') is-invalid @enderror">
                    <option value="">Select Unit</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->Unit_Title }}</option>
                    @endforeach
                </select>
                @error('unit_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="Quiz_Title">Quiz Title</label>
                <input type="text" name="Quiz_Title" id="Quiz_Title" class="form-control @error('Quiz_Title') is-invalid @enderror" value="{{ old('Quiz_Title') }}">
                @error('Quiz_Title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Create Quiz</button>
            <a href="{{ route('quizzes.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection