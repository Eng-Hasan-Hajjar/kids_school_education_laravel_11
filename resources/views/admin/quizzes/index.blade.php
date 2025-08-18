@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Quizzes</h1>
        <a href="{{ route('quizzes.create') }}" class="btn btn-primary mb-3">Create New Quiz</a>

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
                    <th>Title</th>
                    <th>Unit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($quizzes as $quiz)
                    <tr>
                        <td>{{ $quiz->Quiz_Title }}</td>
                        <td>{{ $quiz->unit->Unit_Title ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('quizzes.show', $quiz->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No quizzes found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $quizzes->links() }}
    </div>
@endsection