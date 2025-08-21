@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Users Management</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus-circle mr-1"></i> Add New User
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
                <th>Profile Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td class="align-middle text-center">
                        @if($user->profile_image)
                            <img src="{{ asset($user->profile_image) }}" class="img-circle" width="40" height="40" alt="Profile Image">
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td class="align-middle">{{ $user->name }}</td>
                    <td class="align-middle">{{ $user->email }}</td>
                    <td class="align-middle">{{ $user->roles->pluck('name')->implode(', ') }}</td>
                    <td class="align-middle">
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm mr-1" title="View">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm mr-1" title="Edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')" title="Delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

   
</div>
@endsection