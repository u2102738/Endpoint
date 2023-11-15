@section('title',$title)
@section('description',$description)
@extends('layout.app')
@section('content')
<div class="profile-setting ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main">
                    <h4 class="text-capitalize breadcrumb-title">{{ trans('menu.computer-group-setting') }}</h4>
                    <div class="breadcrumb-action justify-content-center flex-wrap">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('computer.group',app()->getLocale()) }}"><i class="las la-home"></i>Group</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ trans('menu.computer-group-setting') }}</li>
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
                    @foreach ($find_group as $group)
                    <div class="card-body text-center p-0">
                        <div class="account-profile border-bottom pt-25 px-25 pb-0 flex-column d-flex align-items-center ">
                            <div class="ap-nameAddress pb-3">
                                <h5 class="ap-nameAddress__title">{{ $group->name }}</h5>
                                <p class="ap-nameAddress__subTitle fs-14 m-0">{{ $group->devices()->where('group_id', $group->id)->count() }} Device(s)</p>
                            </div>
                        </div>
                        <div class="ps-tab p-20 pb-25">
                            <div class="nav flex-column text-start" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                    <img src="{{ asset('assets/img/svg/settings.svg') }}" alt="user" class="svg">details</a>
                                <a class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                                    <img src="{{ asset('assets/img/svg/key.svg') }}" alt="key" class="svg">devices</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xxl-9 col-lg-8 col-sm-7">
                <div class="mb-50">
                    @foreach ($find_group as $group)
                        <div class="tab-content" id="v-pills-tabContent">
                            {{-- Edit Group --}}
                            <div class="tab-pane fade  show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                <div class="edit-profile">
                                    <div class="card">
                                        <div class="card-header px-sm-25 px-3">
                                            <div class="edit-profile__title">
                                                <h6>edit group</h6>
                                                <span class="fs-13 color-light fw-400">manage group details of {{ $group->name }}.</span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row justify-content-center">
                                                <div class="col-xxl-6 col-lg-8 col-sm-10">
                                                    <div class="edit-profile__body mx-lg-20">
                                                        {{-- Update group details --}}
                                                        <form method="post" action="{{ route('computer.updateDetails',[app()->getLocale(),$group->id]) }}" enctype="multipart/form-data">
                                                        @csrf
                                                            <div class="form-group mb-20">
                                                                <label for="name">name</label>
                                                                <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="{{ $group->name }}">
                                                                @if ($errors->has('name'))
                                                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                                                @endif
                                                            </div>

                                                            <div class="form-group mb-20">
                                                                <label for="description">Description</label>
                                                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Group description">{{ $group->description }}</textarea>
                                                                @if ($errors->has('description'))
                                                                    <p class="text-danger">{{ $errors->first('description') }}</p>
                                                                @endif
                                                            </div>

                                                            <div class="button-group d-flex flex-wrap pt-30 mb-15">
                                                                <button class="btn btn-primary btn-default btn-squared me-15 text-capitalize">update
                                                                </button>
                                                                <a href="{{ route('computer.group',[app()->getLocale(),$group->id]) }}" class="btn btn-light btn-default btn-squared fw-400 text-capitalize m-sm-0 m-1">Cancel</a>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Devices --}}
                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                <div class="edit-profile">
                                    <div class="card">
                                        <div class="card-header  px-sm-25 px-3">
                                            <div class="edit-profile__title">
                                                <h6>devices</h6>
                                                <span class="fs-13 color-light fw-400">Manage {{ $group->name }} devices. </span>
                                            </div>
                                            <div class="d-flex">
                                                <button type="button" class="border radius-lg color-primary fw-500 fs-12 bg-transparent acButton btn-checkAll">
                                                    <i class="fas fa-check m-2"></i>Select All
                                                </button>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#send-warning">
                                                    <button type="button" class="m-1 border radius-lg color-primary fw-500 fs-12 bg-transparent acButton">
                                                        <i class="fas fa-trash-alt m-2"></i>remove
                                                    </button>
                                                </a>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#add-devices">
                                                    <button type="button" class="border radius-lg color-primary fw-500 fs-12 bg-transparent acButton">
                                                        <i class="fas fa-plus m-2"></i>add device
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div>
                                                    <div class="edit-access__body card-body-scrollable">
                                                        <table class="table mb-0 table-borderless">
                                                            <tbody>
                                                                @if (count($devicesInGroup) == 0)
                                                                    <div class="col-12">
                                                                        <div class="mt-10 content-center">
                                                                            <div class="error-page text-center">
                                                                                <h5 class="fw-500">No Device Found!</h5>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    @foreach ($devicesInGroup as $device)
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="checkbox-group-wrapper">
                                                                                            <div class="checkbox-group d-flex me-1">
                                                                                                <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                                                                    <input class="checkbox" type="checkbox" id="check-grp-{{ $device->id }}" name="device[]">
                                                                                                    <label for="check-grp-{{ $device->id }}"></label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div>
                                                                                        <p class="fs-14 fw-400 color-dark mb-0 device-name">{{ $device->name }}</p>
                                                                                        <span class="mt-1 fs-14 color-light">{{ $device->device_owner }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                        <div class="modal-info-update-reminder modal fade show" id="send-warning" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-sm modal-info" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div class="modal-info-body d-flex">

                                                                            <div class="modal-info-text">
                                                                                <h6>Remove this device(s) from the group?</h6>
                                                                                <p><i class="uil uil-exclamation-circle"></i> This process cannot be undone!</p>
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <form action="{{ route('computer.deleteDevice',[app()->getLocale(),$group->id]) }}" method="post" id="delete-devices-form">
                                                                            @csrf
                                                                            <input type="hidden" name="group_id" value="{{ $group->id }}">
                                                                            <div class="d-flex justify-content-between">
                                                                                <button type="button" class="btn btn-default btn-squared border-normal bg-normal px-20" data-bs-dismiss="modal">No</button>
                                                                                <button type="submit" class="btn btn-primary btn-default btn-squared px-30">Yes</button>
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
                    @endforeach

                    {{-- Add Device Modal --}}
                    <div class="modal fade new-role" id="add-devices" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content radius-xl">
                                <div class="modal-header">
                                    <h6 class="modal-title fw-500" id="staticBackdropLabel">Add Devices</h6>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="uil uil-times"></i>
                                    </button>
                                </div>
                                @foreach ($find_group as $group)
                                <div class="modal-body">
                                    <div class="new-member-modal">
                                        <form method="post" action="{{ route('computer.addDevices', [app()->getLocale(), $group->id]) }}" enctype="multipart/form-data">
                                        @csrf
                                            <div class="form-group textarea-group">
                                                <label>Device</label>
                                                <hr>
                                                <div class="dm-tag-mode">
                                                    <div class="dm-select">
                                                        <select name="devices[]" id="select-tag" class="form-control" multiple="multiple">
                                                            @foreach ($devicesNotInGroup as $device)
                                                                <option value="{{ $device->id }}">{{ $device->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @error('devices')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="button-group d-flex pt-25">
                                                <button class="btn btn-primary btn-default btn-squared text-capitalize" type="submit">add devices</button>
                                                <button class="btn btn-light btn-default btn-squared fw-400 text-capitalize b-light color-light" data-bs-dismiss="modal" aria-label="Close">cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                    {{-- End Modal --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
