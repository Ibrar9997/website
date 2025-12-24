@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="d-flex profile-wrapper bg-solid-black">
            <!-- Nav tabs -->
            <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                <li class="nav-item">
                        <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Profile</span>
                </li>

            </ul>
            <div class="flex-shrink-0">
                <a href="{{ route('edit_profile') }}" class="btn btn-success"><i class="ri-edit-box-line align-bottom"></i> Edit Profile</a>
            </div>
        </div>
        <p><strong>Name:</strong> {{ auth()->user()->full_name }}</p>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
    </div>

@endsection
