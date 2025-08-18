@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Section</h1>
        
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('sections.update', $section->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="Section_Title">Section Title</label>
                <input type="text" name="Section_Title" id="Section_Title" class="form-control @error('Section_Title') is-invalid @enderror" value="{{ old('Section_Title', $section->Section_Title) }}">
                @error('Section_Title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="Section_Description">Section Description</label>
                <textarea name="Section_Description" id="Section_Description" class="form-control @error('Section_Description') is-invalid @enderror">{{ old('Section_Description', $section->Section_Description) }}</textarea>
                @error('Section_Description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update Section</button>
            <a href="{{ route('sections.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection