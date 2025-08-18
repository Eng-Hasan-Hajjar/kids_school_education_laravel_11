@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Units</h1>
        <a href="{{ route('units.create') }}" class="btn btn-primary mb-3">Create New Unit</a>

        <form method="GET" action="{{ route('units.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="section_id" class="form-control">
                        <option value="">All Sections</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>{{ $section->Section_Title }}</option>
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
                    <th>Section</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($units as $unit)
                    <tr>
                        <td>{{ $unit->Unit_Title }}</td>
                        <td>{{ $unit->section->Section_Title ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('units.show', $unit->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('units.destroy', $unit->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $units->links() }}
    </div>
@endsection