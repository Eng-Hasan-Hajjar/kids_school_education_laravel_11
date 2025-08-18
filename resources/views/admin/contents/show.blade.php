@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $content->Text }}</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>Lesson:</strong> {{ $content->lesson->Lesson_Title ?? 'N/A' }}</p>
                <p><strong>Sound:</strong> {{ $content->sound ?? 'N/A' }}</p>
                <p><strong>Image:</strong> {{ $content->image ?? 'N/A' }}</p>
                <p><strong>Text:</strong> {{ $content->Text }}</p>
                <p><strong>Created At:</strong> {{ $content->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Updated At:</strong> {{ $content->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        <a href="{{ route('contents.edit', $content->id) }}" class="btn btn-warning mt-3">Edit</a>
        <a href="{{ route('contents.index') }}" class="btn btn-secondary mt-3">Back to Contents</a>
    </div>
@endsection