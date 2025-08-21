@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Answers Management</h1>
    <a href="{{ route('answers.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus-circle mr-1"></i> Create New Answer
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
                <th>Correct</th>
                <th>Question</th>
                <th>Image</th>
                <th>Sound</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($answers as $answer)
                <tr>
                    <td class="align-middle">{{ $answer->Answer_Text }}</td>
                    <td class="align-middle">{{ $answer->Iscorrect ? 'Yes' : 'No' }}</td>
                    <td class="align-middle">{{ $answer->question->Question_Text ?? 'N/A' }}</td>
                    <td class="align-middle text-center">
                        @if($answer->image)
                            <img src="{{ asset($answer->image) }}" class="img-circle" width="40" height="40" alt="Image">
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td class="align-middle">
                        @if($answer->sound)
                            <audio controls style="width: 150px;">
                                <source src="{{ asset($answer->sound) }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td class="align-middle">
                        <a href="{{ route('answers.show', $answer->id) }}" class="btn btn-info btn-sm mr-1" title="View">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('answers.edit', $answer->id) }}" class="btn btn-warning btn-sm mr-1" title="Edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('answers.destroy', $answer->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this answer?')" title="Delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No answers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $answers->links() }}
</div>
@endsection