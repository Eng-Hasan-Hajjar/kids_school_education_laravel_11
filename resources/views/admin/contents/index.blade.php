@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Contents</h1>
        <a href="{{ route('contents.create') }}" class="btn btn-primary mb-3">Create New Content</a>

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
                    <th>Lesson</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contents as $content)
                    <tr>
                        <td>{{ $content->Text }}</td>
                        <td>{{ $content->lesson->Lesson_Title ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('contents.show', $content->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('contents.edit', $content->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('contents.destroy', $content->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No contents found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $contents->links() }}
    </div>
@endsection