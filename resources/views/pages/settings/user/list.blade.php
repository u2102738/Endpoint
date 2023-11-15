@section('title',$title)
@section('description',$description)
@extends('layout.app')
@section('content')

<div class="crm mb-25">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-lg-12">
                <div class="breadcrumb-main">
                    <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                        <div class="d-flex align-items-center user-member__title justify-content-center me-sm-25">
                            <h4 class="text-capitalize fw-500 breadcrumb-title">{{ trans('menu.user-table') }}</h4>
                        </div>
                    </div>
                    <div class="action-btn">
                        {{-- Check if user's role has permission --}}
                        <a href="#" class="btn px-15 btn-primary" data-bs-toggle="modal" data-bs-target="#new-user">
                        <i class="las la-plus fs-16"></i>Add User</a>

                        <!-- Add Modal -->
                        <div class="modal fade new-user" id="new-user" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content  radius-xl">
                                    <div class="modal-header">
                                        <h6 class="modal-title fw-500" id="staticBackdropLabel">Add User</h6>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <img src="{{ asset('assets/img/svg/x.svg') }}" alt="x" class="svg">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="new-member-modal">
                                            <form method="post" action="{{ route('settings.user.store', app()->getLocale()) }}">
                                                @csrf
                                                <div class="form-group row mb-25">
                                                    <div class="col-sm-3 d-flex align-items-center">
                                                        <label for="name" class=" col-form-label color-dark fs-14 fw-500 align-center">Name</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="with-icon">
                                                            <span class="la-user lar color-gray"></span>
                                                            <input type="text" class="form-control  ih-medium ip-gray radius-xs b-light" id="name" name="name" placeholder="John Doe" value="{{ old('name') }}" autocomplete="off">
                                                        </div>
                                                        @if ($errors->has('name'))
                                                            <p class="text-danger">{{ $errors->first('name') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-25">
                                                    <div class="col-sm-3 d-flex align-items-center">
                                                        <label for="email" class="col-form-label color-dark fs-14 fw-500 align-center">Email Address</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="with-icon">
                                                            <span class="lar la-envelope color-gray"></span>
                                                            <input type="email" class="form-control  ih-medium ip-gray radius-xs b-light" id="email" name="email" placeholder="username@email.com" value="{{ old('email') }}" autocomplete="off">
                                                        </div>
                                                        @if ($errors->has('email'))
                                                            <p class="text-danger">{{ $errors->first('email') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-25">
                                                    <div class="col-sm-3 d-flex align-items-center">
                                                        <label for="phonenumber" class=" col-form-label color-dark fs-14 fw-500 align-center">Phone Number</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="with-icon">
                                                            <span class="lar la la-phone"></span>
                                                            <input type="text" class="form-control  ih-medium ip-gray radius-xs b-light" id="phonenumber" name="phonenumber" placeholder="013456789" value="{{ old('phonenumber') }}" autocomplete="off">
                                                        </div>
                                                        @if ($errors->has('phonenumber'))
                                                            <p class="text-danger">{{ $errors->first('phonenumber') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-20">
                                                    <div class="col-sm-3 d-flex align-items-center">
                                                        <label for="role-member" class=" col-form-label color-dark fs-14 fw-500 align-center">Role</label>
                                                    </div>
                                                    <div class="category-member col-sm-9">
                                                        <select class="js-example-basic-single js-states form-control" id="role-member" name="role">
                                                            @foreach($roles as $roleId => $roleName)
                                                                <option value="{{ $roleId }}" {{ old('role',3) == $roleId ? 'selected' : '' }}>{{ $roleName }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @if ($errors->has('role'))
                                                        <p class="text-danger">{{ $errors->first('role') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group row mb-0">
                                                    <div class="col-sm-3">
                                                        <label for="password" class=" col-form-label color-dark fs-14 fw-500 align-center">Password</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="with-icon">
                                                            <span class="las la-lock color-gray"></span>
                                                            <input type="password" class="form-control  ih-medium ip-gray radius-xs b-light" id="password" name="password" autocomplete="off">
                                                        </div>
                                                        @if ($errors->has('password'))
                                                                <p class="text-danger">{{ $errors->first('password') }}</p>
                                                            @endif
                                                        <div class="layout-button mt-25">
                                                            <button type="submit" class="btn btn-primary btn-default btn-squared px-30">add</button>
                                                            <button class="btn btn-light btn-default btn-squared fw-400 text-capitalize b-light color-light" data-bs-dismiss="modal" aria-label="Close" type="button">cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Add Modal -->
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

            @include('components.user.overview_cards')

        </div>
        <div class="card mt-0">
            <div class="card-body-user">
                <div class="userDatatable adv-table-table global-shadow border-0 bg-white w-100 adv-table">
                    <div class="table-responsive">
                        <div id="filter-form-container"></div>
                        <table class="table mb-0 table-borderless adv-table-user" data-sorting="true" data-filter-container="#filter-form-container" data-paging-current="1" data-paging-position="right" data-paging-size="5">
                            <thead>
                                <tr class="userDatatable-header">
                                    <th>
                                        <span class="userDatatable-title">#</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">name</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">email</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">phone number</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">role</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title float-right">action</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($users) == 0)
                                    <tr>
                                        <td colspan="6">
                                            <p class="text-center">No User Found !</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <div class="userDatatable-content">{{ $loop->iteration }}</div>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="userDatatable-inline-title">
                                                        <a href="#" class="text-dark fw-500">
                                                            <h6>{{ $user->name }}</h6>
                                                        </a>
                                                        <p class="d-block mb-0">
                                                            {{-- Kuching, Sarawak --}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content" style="text-transform: none;">
                                                    {{ $user->email }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    {{ $user->phonenumber }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    {{ $user->role ? $user->role->name : '-' }}
                                                </div>
                                            </td>
                                            <td>
                                                <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                                                    <li>
                                                        <a href="#" class="view">
                                                            <i class="uil uil-eye"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="edit" data-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#edit-user-{{ $user->id }}">
                                                            <i class="uil uil-edit"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="remove" data-bs-toggle="modal" data-bs-target="#modal-info-delete-{{ $user->id }}">
                                                            <i class="uil uil-trash-alt"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>


                                        <div class="modal fade edit-user " id="edit-user-{{ $user->id }}" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel-{{ $user->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content  radius-xl">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title fw-500" id="staticBackdropLabel">Edit User</h6>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <img src="{{ asset('assets/img/svg/x.svg') }}" alt="x" class="svg">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="edit-user-modal">
                                                            <form method="post" action="{{ route('settings.user.update',[app()->getLocale(),$user->id]) }}" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="form-group row mb-25">
                                                                    <div class="col-sm-3 d-flex align-items-center">
                                                                        <label for="edit-user-name-{{$user->id}}" class=" col-form-label color-dark fs-14 fw-500 align-center">Name</label>
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <div class="with-icon">
                                                                            <span class="la-user lar color-gray"></span>
                                                                            <input type="text" class="form-control  ih-medium ip-gray radius-xs b-light" id="edit-user-name-{{$user->id}}" name="name" placeholder="Name" value="{{ $user->name }}" autocomplete="off">
                                                                        </div>
                                                                        @if($errors->has('name'))
                                                                            <p class="text-danger">{{ $errors->first('name') }}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mb-25">
                                                                    <div class="col-sm-3 d-flex align-items-center">
                                                                        <label for="edit-user-email-{{$user->id}}" class=" col-form-label color-dark fs-14 fw-500 align-center">Email
                                                                            Address</label>
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <div class="with-icon">
                                                                            <span class="lar la-envelope color-gray"></span>
                                                                            <input type="email" class="form-control  ih-medium ip-gray radius-xs b-light" id="edit-user-email-{{$user->id}}" name="email" placeholder="Email Address" value="{{ $user->email }}" autocomplete="off">
                                                                        </div>
                                                                        @if($errors->has('email'))
                                                                            <p class="text-danger">{{ $errors->first('email') }}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mb-25">
                                                                    <div class="col-sm-3 d-flex align-items-center">
                                                                        <label for="edit-user-phone-{{$user->id}}" class=" col-form-label color-dark fs-14 fw-500 align-center">Phone
                                                                            Number</label>
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <div class="with-icon">
                                                                            <span class="lar la la-phone"></span>
                                                                            <input type="text" class="form-control  ih-medium ip-gray radius-xs b-light" id="edit-user-phone-{{$user->id}}" name="phonenumber" placeholder="Phone Number" value="{{ $user->phonenumber }}" autocomplete="off">
                                                                        </div>
                                                                        @if($errors->has('phonenumber'))
                                                                            <p class="text-danger">{{ $errors->first('phonenumber') }}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mb-20">
                                                                    <div class="col-sm-3">
                                                                        <label for="edit-user-role-{{$user->id}}" class=" col-form-label color-dark fs-14 fw-500 align-center">Role</label>
                                                                    </div>
                                                                    <div class="category-member col-sm-9">
                                                                        <div class="">
                                                                            <select class="js-example-basic-single js-states form-control" id="edit-user-role-{{$user->id}}" name="role">
                                                                            @foreach ($roles as $roleId => $roleName)
                                                                                <option value="{{ $roleId }}" {{ $roleId == $user->role_id ? 'selected' : '' }}>
                                                                                    {{ $roleName }}
                                                                                </option>
                                                                            @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="layout-button mt-25">
                                                                            <button type="submit" class="btn btn-primary btn-default btn-squared px-30" id="edit-user-form-{{$user->id}}">Save</button>
                                                                            <button type="button" class="btn btn-default btn-squared border-normal bg-normal px-20 " data-bs-dismiss="modal" aria-label="Close">cancel</button>
                                                                        </div>
                                                                    </div>
                                                                    @if($errors->has('role'))
                                                                        <p class="text-danger">{{ $errors->first('role') }}</p>
                                                                    @endif
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-info-delete modal fade show" id="modal-info-delete-{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm modal-info" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="modal-info-body d-flex">

                                                            <div class="modal-info-text">
                                                                <h6>Are you sure you want to delete this user?</h6>
                                                                <p><i class="uil uil-exclamation-circle"></i> This process cannot be undone!</p>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <form action="{{ route('settings.user.delete',[app()->getLocale(),$user->id]) }}" method="post" id="delete-{{ $user->id }}">
                                                            @csrf
                                                            <div class="d-flex justify-content-between">
                                                                <button type="button" class="btn btn-default btn-squared border-normal bg-normal px-20" data-bs-dismiss="modal">No</button>
                                                                <button type="submit" class="btn btn-primary btn-default btn-squared px-30">Yes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach

                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



