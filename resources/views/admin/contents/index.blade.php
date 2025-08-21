@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Contents Management</h1>
    <a href="{{ route('contents.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus-circle mr-1"></i> Create New Content
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
                <th>Lesson</th>
                <th>Image</th>
                <th>Sound</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contents as $content)
                <tr>
                    <td class="align-middle">{{ $content->Text }}</td>
                    <td class="align-middle">{{ $content->lesson->Lesson_Title ?? 'N/A' }}</td>
                    <td class="align-middle text-center">
                        @if($content->image)
                            <img src="{{ asset($content->image) }}" class="img-circle" width="40" height="40" alt="Image">
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td class="align-middle">
                        @if($content->sound)
                            <audio controls style="width: 150px;">
                                <source src="{{ asset($content->sound) }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td class="align-middle">
                        <a href="{{ route('contents.show', $content->id) }}" class="btn btn-info btn-sm mr-1" title="View">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('contents.edit', $content->id) }}" class="btn btn-warning btn-sm mr-1" title="Edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('contents.destroy', $content->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this content?')" title="Delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No contents found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $contents->links() }}
</div>
@endsection