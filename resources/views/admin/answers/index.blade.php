@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Answers</h1>
        <a href="{{ route('answers.create') }}" class="btn btn-primary mb-3">Create New Answer</a>

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
                    <th>Correct</th>
                    <th>Question</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($answers as $answer)
                    <tr>
                        <td>{{ $answer->Answer_Text }}</td>
                        <td>{{ $answer->Iscorrect ? 'Yes' : 'No' }}</td>
                        <td>{{ $answer->question->Question_Text ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('answers.show', $answer->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('answers.edit', $answer->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('answers.destroy', $answer->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No answers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $answers->links() }}
    </div>
@endsection