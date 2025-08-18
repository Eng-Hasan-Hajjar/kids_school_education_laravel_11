@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Lessons</h1>
        <a href="{{ route('lessons.create') }}" class="btn btn-primary mb-3">Create New Lesson</a>

        <form method="GET" action="{{ route('lessons.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="unit_id" class="form-control">
                        <option value="">All Units</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->Unit_Title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary">Filter</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Unit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lessons as $lesson)
                    <tr>
                        <td>{{ $lesson->Lesson_Title }}</td>
                        <td>{{ $lesson->unit->Unit_Title ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('lessons.show', $lesson->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('lessons.edit', $lesson->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('lessons.destroy', $lesson->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $lessons->links() }}
    </div>
@endsection