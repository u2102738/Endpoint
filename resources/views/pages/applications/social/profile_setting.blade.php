@section('title',$title)
@section('description',$description)
@extends('layout.app')
@section('content')
<div class="profile-setting ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main">
                    <h4 class="text-capitalize breadcrumb-title">{{ trans('menu.social-profile-setting') }}</h4>
                    <div class="breadcrumb-action justify-content-center flex-wrap">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('social.profile_settings',app()->getLocale()) }}"><i class="las la-home"></i>Profile</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ trans('menu.social-profile-setting') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                {{-- Notify on success --}}
                @if (session('success'))
                    <div class=" alert alert-success alert-dismissible fade show mb-10" role="alert">
                        <div class="alert-content">
                            <p><i class="fas fa-check-circle"></i> <strong>Success!</strong> {{ session('success') }}</p>
                            <button type="button" class="btn-close text-capitalize" data-bs-dismiss="alert" aria-label="Close">
                                <img src="{{ asset('assets/img/svg/x.svg') }}" alt="x" class="svg" aria-hidden="true">
                            </button>
                        </div>
                    </div>
                {{-- Notify on error --}}
                @elseif (session('error'))
                    <div class=" alert alert-danger alert-dismissible fade show mb-10" role="alert">
                        <div class="alert-content">
                            <p><i class="fas fa-exclamation-circle"></i> <strong>Error!</strong> {{ session('error') }}</p>
                            <button type="button" class="btn-close text-capitalize" data-bs-dismiss="alert" aria-label="Close">
                                <img src="{{ asset('assets/img/svg/x.svg') }}" alt="x" class="svg" aria-hidden="true">
                            </button>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-xxl-3 col-lg-4 col-sm-5">
                <div class="card mb-25">
                    <div class="card-body text-center p-0">
                        <div class="account-profile border-bottom pt-25 px-25 pb-0 flex-column d-flex align-items-center ">
                            <div class="ap-img mb-20 pro_img_wrapper">
                                <input id="file-upload" type="file" name="fileUpload" class="d-none">
                                <label for="file-upload">
                                    <img class="ap-img__main rounded-circle wh-120" src="{{ asset('assets/img/author/profile.png') }}" alt="profile">
                                    <span class="cross" id="remove_pro_pic">
                                        <img src="{{ asset('assets/img/svg/camera.svg') }}" alt="camera" class="svg">
                                    </span>
                                </label>
                            </div>
                            <div class="ap-nameAddress pb-3">
                                <h5 class="ap-nameAddress__title">{{ $user->name }}</h5>
                                <p class="ap-nameAddress__subTitle fs-14 m-0">{{ $user->role ? $user->role->name : '-' }}</p>
                            </div>
                        </div>
                        <div class="ps-tab p-20 pb-25">
                            <div class="nav flex-column text-start" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                    <img src="{{ asset('assets/img/svg/user.svg') }}" alt="user" class="svg">Edit profile</a>
                                <a class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                                    <img src="{{ asset('assets/img/svg/key.svg') }}" alt="key" class="svg">change password</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-9 col-lg-8 col-sm-7">
                <div class="mb-50">
                    <div class="tab-content" id="v-pills-tabContent">

                        {{-- Edit Profile --}}
                        <div class="tab-pane fade  show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="edit-profile">
                                <div class="card">
                                    <div class="card-header px-sm-25 px-3">
                                        <div class="edit-profile__title">
                                            <h6>Edit Profile</h6>
                                            <span class="fs-13 color-light fw-400">Set up your personal
                                                information</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <div class="col-xxl-6 col-lg-8 col-sm-10">
                                                <div class="edit-profile__body mx-lg-20">
                                                    <form action="{{ route('social.updateProfile', $user->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group mb-20">
                                                            <label for="name">name</label>
                                                            <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="{{ $user->name }}" autocomplete="off">
                                                            @if($errors->has('name'))
                                                                <p class="text-danger">{{ $errors->first('name') }}</p>
                                                            @endif
                                                        </div>
                                                        <div class="form-group mb-20">
                                                            <label for="email">email address</label>
                                                            <input type="text" name="email" class="form-control" id="email" placeholder="Email Address" value="{{ $user->email }}" autocomplete="off">
                                                            @if($errors->has('email'))
                                                                <p class="text-danger">{{ $errors->first('email') }}</p>
                                                            @endif
                                                        </div>
                                                        <div class="form-group mb-20">
                                                            <label for="phonenumber">phone number</label>
                                                            <input type="tel" name="phonenumber" class="form-control" id="phonenumber" placeholder="Phone Number" value="{{ $user->phonenumber }}" autocomplete="off">
                                                            @if($errors->has('phonenumber'))
                                                                <p class="text-danger">{{ $errors->first('phonenumber') }}</p>
                                                            @endif
                                                        </div>

                                                        <div class="button-group d-flex flex-wrap pt-30 mb-15">
                                                            <button type="submit" class="btn btn-primary btn-default btn-squared me-15 text-capitalize">update profile
                                                            </button>
                                                            <a href="{{ route('home',app()->getLocale()) }}" class="btn btn-light btn-default btn-squared fw-400 text-capitalize m-sm-0 m-1">Cancel</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Change Password --}}
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                            <div class="edit-profile">
                                <div class="card">
                                    <div class="card-header  px-sm-25 px-3">
                                        <div class="edit-profile__title">
                                            <h6>change password</h6>
                                            <span class="fs-13 color-light fw-400">Change or reset your account
                                                password</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <div class="col-xxl-6 col-lg-8 col-sm-10">
                                                <div class="edit-profile__body mx-lg-20">
                                                    <form method="post" action="{{ route('social.updatePassword', $user->id) }}">
                                                        @csrf
                                                        <div class="form-group mb-20">
                                                            <label for="old-password">old password</label>
                                                            <div class="position-relative">
                                                                <input type="password" name="old-password" class="form-control" id="old-password">
                                                                <span class="fa fa-fw fa-eye-slash text-light fs-16 field-icon toggle-password2"></span>
                                                            </div>
                                                            @if($errors->has('old-password'))
                                                                <p class="text-danger">{{ $errors->first('old-password') }}</p>
                                                            @endif
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <label for="new-password">new password</label>
                                                            <div class="position-relative">
                                                                <input id="new-password" name="new-password" type="password" class="form-control pe-50">
                                                                <span class="fa fa-fw fa-eye-slash text-light fs-16 field-icon toggle-password2"></span>
                                                            </div>
                                                            @if($errors->has('new-password'))
                                                                <p class="text-danger">{{ $errors->first('new-password') }}</p>
                                                            @endif
                                                            <small id="passwordHelpInline" class="text-light fs-13">Minimum 6 characters</small>
                                                        </div>
                                                        <div class="button-group d-flex flex-wrap pt-45 mb-35">
                                                            <button class="btn btn-primary btn-default btn-squared me-15 text-capitalize">Save Changes
                                                            </button>
                                                            <a href="{{ route('home',app()->getLocale()) }}" class="btn btn-light btn-default btn-squared fw-400 text-capitalize m-sm-0 m-1">Cancel</a>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
