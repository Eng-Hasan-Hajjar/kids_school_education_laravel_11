@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $section->Section_Title }}</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>Description:</strong> {{ $section->Section_Description }}</p>
                <p><strong>Created At:</strong> {{ $section->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Updated At:</strong> {{ $section->updated_at->format('d/m/Y H:i') }}</p>
                
                @if($section->units->count() > 0)
                    <h3>Units</h3>
                    <ul>
                        @foreach($section->units as $unit)
                            <li>{{ $unit->Unit_Title }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No units associated with this section.</p>
                @endif
                
                @if($section->users->count() > 0)
                    <h3>Associated Users</h3>
                    <ul>
                        @foreach($section->users as $user)
                            <li>{{ $user->name ?? 'N/A' }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No users associated with this section.</p>
                @endif
            </div>
        </div>
        <a href="{{ route('sections.edit', $section->id) }}" class="btn btn-warning mt-3">Edit</a>
        <a href="{{ route('sections.index') }}" class="btn btn-secondary mt-3">Back to Sections</a>
    </div>
@endsection