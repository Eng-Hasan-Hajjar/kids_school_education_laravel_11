@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Questions Management</h1>
    <a href="{{ route('questions.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus-circle mr-1"></i> Create New Question
    </a>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Text</th>
                <th>Quiz</th>
                <th>Image</th>
                <th>Sound</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($questions as $question)
                <tr>
                    <td class="align-middle">{{ $question->Question_Text }}</td>
                    <td class="align-middle">{{ $question->quiz->Quiz_Title ?? 'N/A' }}</td>
                    <td class="align-middle text-center">
                        @if($question->image)
                            <img src="{{ asset($question->image) }}" class="img-circle" width="40" height="40" alt="Image">
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td class="align-middle">
                        @if($question->sound)
                            <audio controls style="width: 150px;">
                                <source src="{{ asset($question->sound) }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td class="align-middle">
                        <a href="{{ route('questions.show', $question->id) }}" class="btn btn-info btn-sm mr-1" title="View">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning btn-sm mr-1" title="Edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this question?')" title="Delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No questions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $questions->links() }}
</div>
@endsection