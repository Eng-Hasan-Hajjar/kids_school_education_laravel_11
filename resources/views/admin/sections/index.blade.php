@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Sections Management</h1>
    <a href="{{ route('sections.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus-circle mr-1"></i> Create New Section
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
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sections as $section)
                <tr>
                    <td class="align-middle">{{ $section->Section_Title }}</td>
                    <td class="align-middle">{{ $section->Section_Description }}</td>
                    <td class="align-middle">
                        <a href="{{ route('sections.show', $section->id) }}" class="btn btn-info btn-sm mr-1" title="View">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('sections.edit', $section->id) }}" class="btn btn-warning btn-sm mr-1" title="Edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('sections.destroy', $section->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this section?')" title="Delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">No sections found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $sections->links() }}
</div>
@endsection