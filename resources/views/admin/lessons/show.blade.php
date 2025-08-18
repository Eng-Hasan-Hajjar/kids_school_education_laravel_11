@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $lesson->Lesson_Title }}</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>Unit:</strong> {{ $lesson->unit->Unit_Title ?? 'N/A' }}</p>
                <p><strong>Created At:</strong> {{ $lesson->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Updated At:</strong> {{ $lesson->updated_at->format('d/m/Y H:i') }}</p>
                
                @if($lesson->contents->count() > 0)
                    <h3>Contents</h3>
                    <ul>
                        @foreach($lesson->contents as $content)
                            <li>{{ $content->title }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        <a href="{{ route('lessons.edit', $lesson->id) }}" class="btn btn-warning mt-3">Edit</a>
        <a href="{{ route('lessons.index') }}" class="btn btn-secondary mt-3">Back to Lessons</a>
    </div>
@endsection