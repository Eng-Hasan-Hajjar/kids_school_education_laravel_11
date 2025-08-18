@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Sections</h1>
        <a href="{{ route('sections.create') }}" class="btn btn-primary mb-3">Create New Section</a>

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
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sections as $section)
                    <tr>
                        <td>{{ $section->Section_Title }}</td>
                        <td>{{ $section->Section_Description }}</td>
                        <td>
                            <a href="{{ route('sections.show', $section->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('sections.edit', $section->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('sections.destroy', $section->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No sections found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $sections->links() }}
    </div>
@endsection