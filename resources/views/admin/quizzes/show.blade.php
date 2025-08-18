@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $quiz->Quiz_Title }}</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>Unit:</strong> {{ $quiz->unit->Unit_Title ?? 'N/A' }}</p>
                <p><strong>Created At:</strong> {{ $quiz->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Updated At:</strong> {{ $quiz->updated_at->format('d/m/Y H:i') }}</p>
                
                @if($quiz->questions->count() > 0)
                    <h3>Questions</h3>
                    <ul>
                        @foreach($quiz->questions as $question)
                            <li>{{ $question->Question_Text }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No questions associated with this quiz.</p>
                @endif
            </div>
        </div>
        <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-warning mt-3">Edit</a>
        <a href="{{ route('quizzes.index') }}" class="btn btn-secondary mt-3">Back to Quizzes</a>
    </div>
@endsection