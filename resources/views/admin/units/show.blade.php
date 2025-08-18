@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $unit->Unit_Title }}</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>Section Innovation:</strong> {{ $unit->section->Section_Title ?? 'N/A' }}</p>
                <p><strong>Created At:</strong> {{ $unit->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Updated At:</strong> {{ $unit->updated_at->format('d/m/Y H:i') }}</p>
                
                @if($unit->lessons->count() > 0)
                    <h3>Lessons</h3>
                    <ul>
                        @foreach($unit->lessons as $lesson)
                            <li>{{ $lesson->Lesson_Title }}</li>
                        @endforeach
                    </ul>
                @endif
                
                @if($unit->quizzes->count() > 0)
                    <h3>Quizzes</h3>
                    <ul>
                        @foreach($unit->quizzes as $quiz)
                            <li>{{ $quiz->title }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-warning mt-3">Edit</a>
        <a href="{{ route('units.index') }}" class="btn btn-secondary mt-3">Back to Units</a>
    </div>
@endsection