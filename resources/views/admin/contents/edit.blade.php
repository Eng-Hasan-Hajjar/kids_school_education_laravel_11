@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Content</h1>
        
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('contents.update', $content->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="lesson_id">Lesson</label>
                <select name="lesson_id" id="lesson_id" class="form-control @error('lesson_id') is-invalid @enderror">
                    <option value="">Select Lesson</option>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}" {{ old('lesson_id', $content->lesson_id) == $lesson->id ? 'selected' : '' }}>{{ $lesson->Lesson_Title }}</option>
                    @endforeach
                </select>
                @error('lesson_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="sound">Sound</label>
                @if($content->sound)
                    <audio controls src="{{ asset($content->sound) }}"></audio>
                    <p>Current sound: {{ basename($content->sound) }}</p>
                @endif
                <input type="file" name="sound" id="sound" class="form-control @error('sound') is-invalid @enderror" accept="audio/*">
                @error('sound')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="image">Image</label>
                @if($content->image)
                    <img src="{{ asset($content->image) }}" width="200" alt="Current Image">
                    <p>Current image: {{ basename($content->image) }}</p>
                @endif
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="Text">Text</label>
                <textarea name="Text" id="Text" class="form-control @error('Text') is-invalid @enderror">{{ old('Text', $content->Text) }}</textarea>
                @error('Text')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update Content</button>
            <a href="{{ route('contents.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Content</h1>
        
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('contents.update', $content->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="lesson_id">Lesson</label>
                <select name="lesson_id" id="lesson_id" class="form-control @error('lesson_id') is-invalid @enderror">
                    <option value="">Select Lesson</option>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}" {{ old('lesson_id', $content->lesson_id) == $lesson->id ? 'selected' : '' }}>{{ $lesson->Lesson_Title }}</option>
                    @endforeach
                </select>
                @error('lesson_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="sound">Sound</label>
                @if($content->sound)
                    <audio controls src="{{ asset($content->sound) }}"></audio>
                    <p>Current sound: {{ basename($content->sound) }}</p>
                @endif
                <input type="file" name="sound" id="sound" class="form-control @error('sound') is-invalid @enderror" accept="audio/*">
                @error('sound')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="image">Image</label>
                @if($content->image)
                    <img src="{{ asset($content->image) }}" width="200" alt="Current Image">
                    <p>Current image: {{ basename($content->image) }}</p>
                @endif
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="Text">Text</label>
                <textarea name="Text" id="Text" class="form-control @error('Text') is-invalid @enderror">{{ old('Text', $content->Text) }}</textarea>
                @error('Text')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update Content</button>
            <a href="{{ route('contents.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection