@extends('layouts.master')

@section('content')
    <div class="col-xxl-9">
        <div class="card mt-xxl-n5">
            <div class="card-header">
                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                            <i class="fas fa-home"></i> Personal Details
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                            <i class="far fa-user"></i> Change Password
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content">
                    <div class="tab-pane active" id="personalDetails" role="tabpanel">

                        <form action="{{ route('profile-update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="firstnameInput" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="firstnameInput"
                                            placeholder="Enter your full_name"
                                            value="{{ old('full_name', auth()->user()->full_name) }}" name="full_name">
                                    </div>
                                </div>

                                <!--end col-->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="emailInput" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="emailInput"
                                            placeholder="Enter your email" value="{{ old('email', auth()->user()->email) }}"
                                            name="email">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-primary">Updates</button>
                                        <button type="button" class="btn btn-soft-success">Cancel</button>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                    </div>
                    <!--end tab-pane-->
                    <div class="tab-pane" id="changePassword" role="tabpanel">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('profile-update-password') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-2">
                                <div class="col-lg-4 position-relative">
                                    <label class="form-label">Old Password*</label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">

                                        <input type="password" class="form-control" id="old_password"
                                            name="oldpasswordInput" required>
                                        <button type="button"
                                            class="btn btn-link position-absolute end-0 top-50 translate-middle-y"
                                            onclick="togglePassword('old_password', this)">
                                            <i class="ri-eye-fill align-middle"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-4 position-relative">
                                    <label class="form-label">New Password*</label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">

                                        <input type="password" class="form-control" id="new_password"
                                            name="newpasswordInput" required>
                                        <button type="button"
                                            class="btn btn-link position-absolute end-0 top-50 translate-middle-y"
                                            onclick="togglePassword('new_password', this)">
                                            <i class="ri-eye-fill align-middle"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-4 position-relative">
                                    <label class="form-label">Confirm Password*</label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                        <input type="password" class="form-control" id="confirm_password"
                                            name="newpasswordInput_confirmation" required>
                                        <button type="button"
                                            class="btn btn-link position-absolute end-0 top-50 translate-middle-y"
                                            onclick="togglePassword('confirm_password', this)">
                                            <i class="ri-eye-fill align-middle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>

    @endsection
