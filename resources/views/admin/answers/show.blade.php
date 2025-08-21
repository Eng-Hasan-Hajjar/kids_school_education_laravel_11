@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $answer->Answer_Text }}</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>Question:</strong> {{ $answer->question->Question_Text ?? 'N/A' }}</p>
                <p><strong>Text:</strong> {{ $answer->Answer_Text }}</p>
                <p><strong>Is Correct:</strong> {{ $answer->Iscorrect ? 'Yes' : 'No' }}</p>
                <p><strong>Sound:</strong> 
                    @if($answer->sound)
                        <audio controls>
                            <source src="{{ asset($answer->sound) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    @else 
                        N/A 
                    @endif
                </p>
                <p><strong>Image:</strong> 
                    @if($answer->image)
                        <img src="{{ asset($answer->image) }}" width="300" alt="Image">
                    @else 
                        N/A 
                    @endif
                </p>
                <p><strong>Created At:</strong> {{ $answer->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Updated At:</strong> {{ $answer->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        <a href="{{ route('answers.edit', $answer->id) }}" class="btn btn-warning mt-3">Edit</a>
        <a href="{{ route('answers.index') }}" class="btn btn-secondary mt-3">Back to Answers</a>
    </div>
@endsection