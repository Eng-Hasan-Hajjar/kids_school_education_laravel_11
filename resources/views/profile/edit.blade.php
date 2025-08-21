@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-body p-0">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
          
        
        </div>
    </div>
</div>
@endsection