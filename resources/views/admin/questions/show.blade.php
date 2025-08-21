@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $question->Question_Text }}</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>Quiz:</strong> {{ $question->quiz->Quiz_Title ?? 'N/A' }}</p>
                <p><strong>Question Text:</strong> {{ $question->Question_Text }}</p>
                <p><strong>Sound:</strong> 
                    @if($question->sound)
                        <audio controls>
                            <source src="{{ asset($question->sound) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    @else 
                        N/A 
                    @endif
                </p>
                <p><strong>Image:</strong> 
                    @if($question->image)
                        <img src="{{ asset($question->image) }}" width="300" alt="Image">
                    @else 
                        N/A 
                    @endif
                </p>
                <p><strong>Created At:</strong> {{ $question->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Updated At:</strong> {{ $question->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning mt-3">Edit</a>
        <a href="{{ route('questions.index') }}" class="btn btn-secondary mt-3">Back to Questions</a>
    </div>
@endsection