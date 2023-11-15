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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">{{ trans('menu.softwaredeployment-packages') }}</h4>
                        </div>
                    </div>
                    <div class="action-btn">
                        <a href="#" class="btn px-15 btn-primary" data-bs-toggle="modal" data-bs-target="#add-package">
                        <i class="las la-plus fs-16"></i>Add Packages</a>

                        {{-- Modal --}}
                        <div class="modal fade new-role" id="add-package" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content radius-xl">
                                    <div class="modal-header">
                                        <h6 class="modal-title fw-500" id="staticBackdropLabel">Add Packages</h6>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <i class="uil uil-times"></i>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="new-member-modal">
                                            <form method="post" action="{{ route('software-deployment.packageStore', app()->getLocale()) }}" enctype="multipart/form-data" onsubmit="handleFormSubmit(event)" id="new-package">
                                                @csrf
                                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                                <div class="form-group mb-20">
                                                    <input type="text" class="form-control" name="name" placeholder="Package Name">
                                                    @if ($errors->has('name'))
                                                        <p class="text-danger">{{ $errors->first('name') }}</p>
                                                    @endif
                                                </div>

                                                <div class="form-group mb-20">
                                                    <input type="text" class="form-control" name="version" placeholder="Package Version">
                                                    @if ($errors->has('version'))
                                                        <p class="text-danger">{{ $errors->first('version') }}</p>
                                                    @endif
                                                </div>

                                                <div class="dm-tag-wrap">
                                                    <div class="dm-upload">
                                                        <div class="dm-upload__button">
                                                            <a href="javascript:void(0)" class="btn btn-lg btn-outline-lighten btn-upload" onclick="$('#upload-2').click()"> <img src="{{ asset('assets/img/svg/upload.svg') }}" alt="upload" class="svg"> Upload</a>
                                                            <input type="file" name="file" class="upload-one" id="upload-2" onchange="updateFileName(this)">
                                                        </div>
                                                        <div class="dm-upload__file">
                                                            <ul id="uploaded-files-list"></ul>
                                                        </div>
                                                        <div class="storage-progress">
                                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    @if( $errors->has('file'))
                                                        <p class="text-danger">{{ $errors->first('file') }}</p>
                                                    @endif
                                                </div>

                                                <div class="button-group d-flex pt-25">
                                                    <button class="btn btn-primary btn-default btn-squared text-capitalize btn-add-package" type="submit">Add package</button>
                                                    <button class="btn btn-light btn-default btn-squared fw-400 text-capitalize b-light color-light" data-bs-dismiss="modal" aria-label="Close" type="button">Cancel</button>
                                                    <button class="btn btn-light btn-default btn-squared fw-400 text-capitalize b-light color-light" type="button" onclick="clearFile()">Clear File</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Close Modal --}}
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
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="userDatatable orderDatatable sellerDatatable global-shadow mb-30 py-30 px-sm-30 px-20 radius-xl w-100">
                    <div class="project-top-wrapper d-flex justify-content-between flex-wrap mb-25 mt-n10">
                        <div class="d-flex align-items-center flex-wrap justify-content-center">
                            <div class="project-search order-search  global-shadow mt-10">
                                <form action="" class="order-search__form">
                                    <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg">
                                    <input class="form-control me-sm-2 border-0 box-shadow-none" type="search" placeholder="Filter by keyword" id="filterInput" aria-label="Search">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive card-body-scrollable">
                        <table class="table mb-0 table-borderless border-0" id="deviceTable">
                            <thead class="sticky-top">
                                <tr class="userDatatable-header">
                                    <th scope="col w-20">
                                        <span class="userDatatable-title">#</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Name</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Version</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($packages) == 0)
                                    <tr>
                                        <td colspan="4">
                                            <p class="text-center">No Package Found !</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($packages as $package)
                                        <tr>
                                            <td>
                                                <div class="userDatatable-content">{{ $loop->iteration }}</div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content" style="text-transform: none;">
                                                    <a class="text-dark cursor-true" data-bs-toggle="modal" data-bs-target="#package-{{$package->id}}" data-package-id="{{ $package->id }}">
                                                        <h6>{{ $package->name }}</h6>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content" style="text-transform: none;">
                                                    {{ $package->version }}
                                                </div>
                                            </td>
                                            <td>
                                                <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                                                    <li>
                                                        <a href="{{ route('software-deployment.deployment_detail', [app()->getLocale(), $package->id]) }}" class="view">
                                                            <i class="uil uil-arrow-circle-up"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="edit" data-id="{{ $package->id }}" data-bs-toggle="modal" data-bs-target="#edit-package-{{ $package->id }}">
                                                            <i class="uil uil-edit"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="remove" data-bs-toggle="modal" data-bs-target="#modal-info-delete-{{ $package->id }}">
                                                            <i class="uil uil-trash-alt"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>

                                        {{-- Edit Modal --}}
                                        <div class="modal fade edit-package " id="edit-package-{{ $package->id }}" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel-{{ $package->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content  radius-xl">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title fw-500" id="staticBackdropLabel">Edit Package</h6>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <img src="{{ asset('assets/img/svg/x.svg') }}" alt="x" class="svg">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="edit-package-modal">
                                                            <form method="post" action="{{ route('software-deployment.packageUpdate',[app()->getLocale(),$package->id]) }}" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="form-group row mb-25">
                                                                    <div class="col-sm-3 d-flex align-items-center">
                                                                        <label for="edit-package-name-{{$package->id}}" class=" col-form-label color-dark fs-14 fw-500 align-center">Name</label>
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <div class="with-icon">
                                                                            <span class="la-user lar color-gray"></span>
                                                                            <input type="text" class="form-control  ih-medium ip-gray radius-xs b-light" id="edit-package-name-{{$package->id}}" name="name" placeholder="Name" value="{{ $package->name }}" autocomplete="off">
                                                                        </div>
                                                                        @if($errors->has('name'))
                                                                            <p class="text-danger">{{ $errors->first('name') }}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mb-25">
                                                                    <div class="col-sm-3 d-flex align-items-center">
                                                                        <label for="edit-package-version-{{$package->id}}" class=" col-form-label color-dark fs-14 fw-500 align-center">Version</label>
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <div class="with-icon">
                                                                            <span class="lar la-envelope color-gray"></span>
                                                                            <input type="text" class="form-control  ih-medium ip-gray radius-xs b-light" id="edit-package-version-{{$package->id}}" name="version" placeholder="Version" value="{{ $package->version }}" autocomplete="off">
                                                                        </div>
                                                                        @if($errors->has('version'))
                                                                            <p class="text-danger">{{ $errors->first('version') }}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mb-20">
                                                                    <div class="col-sm-3">
                                                                        <label for="edit-package-file-{{$package->id}}" class=" col-form-label color-dark fs-14 fw-500 align-center">Current File</label>
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <div class="overflow-auto">
                                                                            <a href="{{ route('software-deployment.downloadFile', [app()->getLocale(), $package->id]) }}" target="_blank">{{ $package->file_name }}</a>
                                                                        </div>
                                                                        <div class="layout-button mt-25">
                                                                            <button type="submit" class="btn btn-primary btn-default btn-squared px-30" id="edit-package-form-{{$package->id}}">Save</button>
                                                                            <button type="button" class="btn btn-default btn-squared border-normal bg-normal px-20 " data-bs-dismiss="modal" aria-label="Close">cancel</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- End Edit Modal --}}

                                        {{-- Delete Modal --}}
                                        <div class="modal-info-delete modal fade show" id="modal-info-delete-{{ $package->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm modal-info" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="modal-info-body d-flex">

                                                            <div class="modal-info-text">
                                                                <h6>Are you sure you want to delete this package?</h6>
                                                                <p><i class="uil uil-exclamation-circle"></i> This process cannot be undone!</p>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <form action="{{ route('software-deployment.packageDelete',[app()->getLocale(),$package->id]) }}" method="post" id="delete-{{ $package->id }}">
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
                                        {{-- End Delete Modal --}}
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @foreach ($packages as $package)
                        {{-- Package Device List Modal --}}
                        <div class="modal fade" id="package-{{$package->id}}" role="dialog" tabindex="-1" aria-labelledby="package-label-{{$package->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content radius-xl">
                                    <div class="modal-header">
                                        <h6 class="modal-title fw-500" id="package-label-{{$package->id}}">Package - {{ $package->name }}</h6>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <img src="{{ asset('assets/img/svg/x.svg') }}" alt="x" class="svg">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="generatereport-modal">
                                            <div class="table-responsive card-body-scrollable">
                                                <table class="table mb-0 table-borderless border-0">
                                                    <thead class="sticky-top">
                                                        <tr class="userDatatable-header">
                                                            <th scope="col">
                                                                <div class="text-center">
                                                                    <span class="userDatatable-title">Device Name</span>
                                                                </div>
                                                            </th>
                                                            <th scope="col">
                                                                <div class="text-center">
                                                                    <span class="userDatatable-title">Device Owner</span>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($package->devices) == 0)
                                                            <tr>
                                                                <td colspan="2">
                                                                    <p class="text-center">No Device Found !</p>
                                                                </td>
                                                            </tr>
                                                        @else
                                                            @foreach ($package->devices as $device)
                                                                <tr>
                                                                    <td>
                                                                        <div class="orderDatatable-title text-center">
                                                                            <h6>{{ $device->name }}</h6>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="orderDatatable-title text-center">
                                                                            {{ $device->device_owner }}
                                                                        </div>
                                                                    </td>
                                                                </tr>
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
                        {{-- End Package Device List Modal --}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
