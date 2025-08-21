@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Create Question</h1>
        
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="quiz_id">Quiz</label>
                <select name="quiz_id" id="quiz_id" class="form-control @error('quiz_id') is-invalid @enderror">
                    <option value="">Select Quiz</option>
                    @foreach($quizzes as $quiz)
                        <option value="{{ $quiz->id }}" {{ old('quiz_id') == $quiz->id ? 'selected' : '' }}>{{ $quiz->Quiz_Title }}</option>
                    @endforeach
                </select>
                @error('quiz_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="Question_Text">Question Text</label>
                <textarea name="Question_Text" id="Question_Text" class="form-control @error('Question_Text') is-invalid @enderror">{{ old('Question_Text') }}</textarea>
                @error('Question_Text')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="sound">Sound</label>
                <input type="file" name="sound" id="sound" class="form-control @error('sound') is-invalid @enderror" accept="audio/*">
                @error('sound')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Create Question</button>
            <a href="{{ route('questions.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection