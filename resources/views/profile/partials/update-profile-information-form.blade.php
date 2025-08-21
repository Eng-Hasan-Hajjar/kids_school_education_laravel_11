@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">{{ __('Profile Information') }}</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">{{ __("Update your account's profile information, email address, and upload profile picture or payment receipt.") }}</p>

                    <!-- Profile Picture Preview -->
                    <div class="text-center mb-4">
                        @if(auth()->user()->profile_image)
                            <img src="{{ asset(auth()->user()->profile_image) }}" class="img-circle elevation-2" width="80" height="80" alt="Profile Picture">
                        @else
                            <span class="text-muted">No profile picture uploaded.</span>
                        @endif
                    </div>

                    <!-- Verification Email Form -->
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <!-- Profile Update Form -->
                    <form method="post" action="{{ route('profile.update') }}" class="space-y-4" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <!-- Name Field -->
                        <div class="form-group">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="mt-2">
                                    <p class="text-sm text-gray-600">
                                        {{ __('Your email address is unverified.') }}
                                        <button form="send-verification" class="btn btn-link p-0 text-sm text-primary">
                                            {{ __('Click here to re-send the verification email.') }}
                                        </button>
                                    </p>
                                    @if (session('status') === 'verification-link-sent')
                                        <p class="text-sm text-success mt-2">{{ __('A new verification link has been sent to your email address.') }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Profile Picture Upload -->
                        <div class="form-group">
                            <label for="profile_image" class="form-label">{{ __('Profile Picture') }}</label>
                            <input type="file" name="profile_image" id="profile_image" class="form-control @error('profile_image') is-invalid @enderror" accept="image/*">
                            @error('profile_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if(auth()->user()->profile_image)
                                <img src="{{ asset(auth()->user()->profile_image) }}" class="mt-2 img-circle elevation-1" width="60" alt="Current Profile Picture">
                            @endif
                        </div>

                        <!-- Payment Receipt Upload -->
                        <div class="form-group">
                            <label for="payment_receipt" class="form-label">{{ __('Payment Receipt') }}</label>
                            <input type="file" name="payment_receipt" id="payment_receipt" class="form-control @error('payment_receipt') is-invalid @enderror" accept="image/*">
                            @error('payment_receipt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if(auth()->user()->payment_receipt)
                                <img src="{{ asset(auth()->user()->payment_receipt) }}" class="mt-2 img-circle elevation-1" width="60" alt="Current Payment Receipt">
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> {{ __('Save') }}
                            </button>
                            @if (session('status') === 'profile-updated')
                                <span class="text-sm text-success ml-2">{{ __('Saved.') }}</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>






















<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">{{ __('Update Password') }}</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>

                    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                        @csrf
                        @method('put')

                        <!-- Current Password Field -->
                        <div class="form-group">
                            <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
                            <input id="update_password_current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password">
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- New Password Field -->
                        <div class="form-group">
                            <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
                            <input id="update_password_password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="form-group">
                            <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
                            @error('password_confirmation', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> {{ __('Save') }}
                            </button>
                            @if (session('status') === 'password-updated')
                                <span class="text-sm text-success ml-2">{{ __('Saved.') }}</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>







<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h3 class="card-title">{{ __('Delete Account') }}</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please download any data or information that you wish to retain before proceeding.') }}</p>

                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm-user-deletion">
                        <i class="fas fa-trash mr-1"></i> {{ __('Delete Account') }}
                    </button>

                    <!-- Delete Account Modal -->
                    <div class="modal fade" id="confirm-user-deletion" tabindex="-1" role="dialog" aria-labelledby="confirm-user-deletion-label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="confirm-user-deletion-label">{{ __('Confirm Account Deletion') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
                                    @csrf
                                    @method('delete')

                                    <div class="form-group">
                                        <p class="text-sm text-gray-600">{{ __('Please enter your password to confirm you would like to permanently delete your account.') }}</p>
                                        <input id="password" name="password" type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" placeholder="{{ __('Password') }}">
                                        @error('password', 'userDeletion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">{{ __('Cancel') }}</button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash mr-1"></i> {{ __('Delete Account') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection