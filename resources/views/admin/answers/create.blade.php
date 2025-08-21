@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Create Answer</h1>
        
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('answers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="question_id">Question</label>
                <select name="question_id" id="question_id" class="form-control @error('question_id') is-invalid @enderror">
                    <option value="">Select Question</option>
                    @foreach($questions as $question)
                        <option value="{{ $question->id }}" {{ old('question_id') == $question->id ? 'selected' : '' }}>{{ $question->Question_Text }}</option>
                    @endforeach
                </select>
                @error('question_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="Answer_Text">Answer Text</label>
                <textarea name="Answer_Text" id="Answer_Text" class="form-control @error('Answer_Text') is-invalid @enderror">{{ old('Answer_Text') }}</textarea>
                @error('Answer_Text')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="Iscorrect">Is Correct?</label>
                <select name="Iscorrect" id="Iscorrect" class="form-control @error('Iscorrect') is-invalid @enderror">
                    <option value="1" {{ old('Iscorrect') == '1' ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('Iscorrect') == '0' ? 'selected' : '' }}>No</option>
                </select>
                @error('Iscorrect')
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
            <button type="submit" class="btn btn-primary">Create Answer</button>
            <a href="{{ route('answers.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection