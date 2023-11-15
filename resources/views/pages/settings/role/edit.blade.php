@section('title', $title)
@section('description', $description)
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
                                <li class="breadcrumb-item"><a href="{{ route('settings.role.list',app()->getLocale()) }}"><i class="las la-home"></i>Roles</a></li>
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
                    @foreach ($find_role as $role)
                    <div class="card-body text-center p-0">
                        <div class="account-profile border-bottom pt-25 px-25 pb-0 flex-column d-flex align-items-center ">
                            <div class="ap-nameAddress pb-3">
                                <h5 class="ap-nameAddress__title">{{ $role->name }}</h5>
                                <p class="ap-nameAddress__subTitle fs-14 m-0">{{ $role->users()->where('role_id', $role->id)->count() }} User(s)</p>
                            </div>
                        </div>
                        <div class="ps-tab p-20 pb-25">
                            <div class="nav flex-column text-start" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                    <img src="{{ asset('assets/img/svg/user.svg') }}" alt="user" class="svg">details</a>
                                <a class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                                    <img src="{{ asset('assets/img/svg/key.svg') }}" alt="key" class="svg">Permissions</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xxl-9 col-lg-8 col-sm-7">
                <div class="mb-50">
                    @foreach ($find_role as $role)
                        <div class="tab-content" id="v-pills-tabContent">
                            {{-- Edit Role --}}
                            <div class="tab-pane fade  show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                <div class="edit-profile">
                                    <div class="card">
                                        <div class="card-header px-sm-25 px-3">
                                            <div class="edit-profile__title">
                                                <h6>edit role</h6>
                                                <span class="fs-13 color-light fw-400">manage role details of {{ $role->name }}.</span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row justify-content-center">
                                                <div class="col-xxl-6 col-lg-8 col-sm-10">
                                                    <div class="edit-profile__body mx-lg-20">
                                                        <form method="post" action="{{ route('settings.role.updateDetails',[app()->getLocale(),$role->id]) }}" enctype="multipart/form-data">
                                                        @csrf
                                                            <div class="form-group mb-20">
                                                                <label for="name">name</label>
                                                                <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="{{ $role->name }}">
                                                                @if ($errors->has('name'))
                                                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                                                @endif
                                                            </div>

                                                            <div class="form-group mb-20">
                                                                <label for="description">Description</label>
                                                                <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" placeholder="Role description">{{ $role->description }}</textarea>
                                                                @if ($errors->has('description'))
                                                                    <p class="text-danger">{{ $errors->first('description') }}</p>
                                                                @endif
                                                            </div>

                                                            <div class="button-group d-flex flex-wrap pt-30 mb-15">
                                                                <button class="btn btn-primary btn-default btn-squared me-15 text-capitalize">update
                                                                </button>
                                                                <a href="{{ route('settings.role.list',[app()->getLocale(),$role->id]) }}" class="btn btn-light btn-default btn-squared fw-400 text-capitalize m-sm-0 m-1">Cancel</a>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Change Access --}}
                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                <div class="edit-profile">
                                    <div class="card">
                                        <div class="card-header  px-sm-25 px-3">
                                            <div class="edit-profile__title">
                                                <h6>permissions</h6>
                                                <span class="fs-13 color-light fw-400">Manage {{ $role->name }} access. </span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row justify-content-center">
                                                <div class="col-xxl-6 col-lg-8 col-sm-10">
                                                    <div class="edit-access__body mx-lg-20">
                                                        <form method="post" action="{{ route('settings.role.updateAccess',[app()->getLocale(),$role->id]) }}" enctype="multipart/form-data">
                                                        @csrf
                                                            @foreach ($permissions as $permission)
                                                                <div class="checkbox-theme-default custom-checkbox ">
                                                                    <input value="{{ $permission->id }}" class="checkbox" type="checkbox" id="permission-{{ $permission->id }}" name="permissions[]" @if (in_array($permission->id, $rolePermissionIds)) checked @endif>
                                                                    <label for="permission-{{ $permission->id }}">
                                                                        <span class="checkbox-text">
                                                                            {{ ucwords($permission->name) }}
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            @endforeach

                                                            <div class="button-group d-flex flex-wrap pt-30 mb-15">
                                                                <button class="btn btn-primary btn-default btn-squared me-15 text-capitalize">update
                                                                </button>
                                                                <a href="{{ route('settings.role.list',app()->getLocale()) }}" class="btn btn-light btn-default btn-squared fw-400 text-capitalize m-sm-0 m-1">Cancel</a>
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
