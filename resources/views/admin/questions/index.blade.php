@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Questions</h1>
        <a href="{{ route('questions.create') }}" class="btn btn-primary mb-3">Create New Question</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Text</th>
                    <th>Quiz</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($questions as $question)
                    <tr>
                        <td>{{ $question->Question_Text }}</td>
                        <td>{{ $question->quiz->Quiz_Title ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('questions.show', $question->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No questions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $questions->links() }}
    </div>
@endsection