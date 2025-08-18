@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Question</h1>
        
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('questions.update', $question->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="quiz_id">Quiz</label>
                <select name="quiz_id" id="quiz_id" class="form-control @error('quiz_id') is-invalid @enderror">
                    <option value="">Select Quiz</option>
                    @foreach($quizzes as $quiz)
                        <option value="{{ $quiz->id }}" {{ old('quiz_id', $question->quiz_id) == $quiz->id ? 'selected' : '' }}>{{ $quiz->Quiz_Title }}</option>
                    @endforeach
                </select>
                @error('quiz_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="Question_Text">Question Text</label>
                <textarea name="Question_Text" id="Question_Text" class="form-control @error('Question_Text') is-invalid @enderror">{{ old('Question_Text', $question->Question_Text) }}</textarea>
                @error('Question_Text')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="sound">Sound (Path)</label>
                <input type="text" name="sound" id="sound" class="form-control @error('sound') is-invalid @enderror" value="{{ old('sound', $question->sound) }}">
                @error('sound')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="image">Image (Path)</label>
                <input type="text" name="image" id="image" class="form-control @error('image') is-invalid @enderror" value="{{ old('image', $question->image) }}">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update Question</button>
            <a href="{{ route('questions.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection