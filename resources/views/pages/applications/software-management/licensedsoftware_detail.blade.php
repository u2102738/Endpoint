@section('title',$title)
@section('description',$description)
@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">{{ trans('menu.software-licensedsoftware') }} — {{$software->name}}</h4>
                <div class="breadcrumb-action justify-content-center flex-wrap">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('software-management.licensedsoftware','en') }}"><i class="las la-home"></i>Licensed Software</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ trans('menu.software-licensedsoftware-devicelist') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-default card-md mb-4">

                <div class="card-body">
                    <div class="tab-wrapper">

                        <div class="dm-tab tab-horizontal">
                            <ul class="nav nav-tabs vertical-tabs" role="tablist">

                                <li class="nav-item">
                                    <a class="nav-link active" id="tab-v-1-tab" data-bs-toggle="tab" href="#tab-v-1" role="tab" aria-selected="true">By Device</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-v-2-tab" data-bs-toggle="tab" href="#tab-v-2" role="tab" aria-selected="false">By Group</a>
                                </li>

                            </ul>
                            <div class="tab-content">
                                {{-- By Device --}}
                                <div class="tab-pane fade show active" id="tab-v-1" role="tabpanel" aria-labelledby="tab-v-1-tab">
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
                                            <div class="content-center">
                                                <div class="dropdown dropdown-btn dropdown-hover ">
                                                    <button class="btn btn-outline-lighten fs-14 fw-400 btn-primary color-white">
                                                        <i class="la la-file-invoice color-white"></i>
                                                        <p class="color-white">Generate Report</p>
                                                    </button>
                                                    <div class="dropdown-default dropdown-bottomCenter bg-white">
                                                        <a class="dropdown-item" href="{{ route('software-management.exportDevicesWithSoftware', [app()->getLocale(), $software->id]) }}" class="color-white a-hover-default">With Software</a>
                                                        <a class="dropdown-item" href="{{ route('software-management.exportDevicesWithoutSoftware', [app()->getLocale(), $software->id]) }}">Without Software</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive card-body-scrollable">
                                            <table class="table mb-0 table-borderless border-0" id="deviceTable">
                                                <thead class="sticky-top">
                                                    <tr class="userDatatable-header">
                                                        <th scope="col">
                                                            <span class="userDatatable-title">Device Name</span>
                                                        </th>
                                                        <th scope="col">
                                                            <span class="userDatatable-title">Device Owner</span>
                                                        </th>
                                                        <th scope="col">
                                                            <span class="userDatatable-title">State</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($devices) == 0)
                                                        <tr>
                                                            <td colspan="3">
                                                                <p class="text-center">No Device Found !</p>
                                                            </td>
                                                        </tr>
                                                    @else
                                                        @foreach ($devices as $device)
                                                            <tr>
                                                                <td>
                                                                    <div class="orderDatatable-title">
                                                                        <a href="{{ route('computer.device_detail', [app()->getLocale(), $device->id]) }}" class="text-dark">
                                                                            <h6>{{ $device->name }}</h6>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="orderDatatable-title">
                                                                        {{ $device->device_owner }}
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="userDatatable-content-status mb-0 d-flex flex-wrap">
                                                                        <span class="media-badge color-white bg-{{ $device->latestDeviceState->state ? 'active' : 'disconnected' }}">
                                                                            {{ $device->latestDeviceState->state ? 'active' : 'disconnected' }}
                                                                        </span>
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

                                {{-- By Group --}}
                                <div class="tab-pane fade" id="tab-v-2" role="tabpanel" aria-labelledby="tab-v-2-tab">
                                    <div class="userDatatable orderDatatable sellerDatatable global-shadow mb-30 py-30 px-sm-30 px-20 radius-xl w-100">
                                        <div class="project-top-wrapper d-flex justify-content-between flex-wrap mb-25 mt-n10">
                                            <div class="d-flex align-items-center flex-wrap justify-content-center">
                                                <div class="project-search order-search  global-shadow mt-10">
                                                    <form action="" class="order-search__form">
                                                        <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg">
                                                        <input class="form-control me-sm-2 border-0 box-shadow-none" type="search" placeholder="Filter by keyword" id="filterInput-Group" aria-label="Search">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive card-body-scrollable">
                                            <table class="table mb-0 table-borderless border-0" id="deviceGroupTable">
                                                <thead class="sticky-top">
                                                    <tr class="userDatatable-header">
                                                        <th scope="col">
                                                            <span class="userDatatable-title">Group Name</span>
                                                        </th>
                                                        <th scope="col">
                                                            <span class="userDatatable-title">Counter (Devices)</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($groupsWithLicensedSoftware->isEmpty())
                                                        <tr>
                                                            <td colspan="2">
                                                                <p class="text-center">No group Found !</p>
                                                            </td>
                                                        </tr>
                                                    @else
                                                        @foreach ($groupsWithLicensedSoftware as $group)
                                                            <tr>
                                                                <td>
                                                                    <div class="orderDatatable-title">
                                                                        <a class="text-dark cursor-true" data-bs-toggle="modal" data-bs-target="#group-generatereport-{{$group->id}}" data-group-id="{{ $group->id }}">
                                                                            <h6>{{ $group->name }}</h6>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="userDatatable-content text-center" style="text-transform: none;">
                                                                        {{ $group->devices_count }} / {{ $groupTotalDevices[$group->id] }}
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
                                <!-- Separate modal for each group -->
                                @foreach ($groupsWithLicensedSoftware as $group)
                                    <div class="modal fade" id="group-generatereport-{{ $group->id }}" role="dialog" tabindex="-1" aria-labelledby="group-generatereport-label-{{ $group->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content radius-xl">
                                                <div class="modal-header">
                                                    <h6 class="modal-title fw-500" id="group-generatereport-label-{{ $group->id }}">Generate Report - {{ $group->name }}</h6>
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
                                                                        <th scope="col">
                                                                            <div class="text-center">
                                                                                <span class="userDatatable-title">State</span>
                                                                            </div>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if (count($group->devices) == 0)
                                                                        <tr>
                                                                            <td colspan="3">
                                                                                <p class="text-center">No Device Found !</p>
                                                                            </td>
                                                                        </tr>
                                                                    @else
                                                                        @foreach ($group->devices as $device)
                                                                            <tr>
                                                                                <td>
                                                                                    <div class="orderDatatable-title text-center">
                                                                                        <a href="{{ route('computer.device_detail', [app()->getLocale(), $device->id]) }}" class="text-dark">
                                                                                            <h6>{{ $device->name }}</h6>
                                                                                        </a>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="orderDatatable-title text-center">
                                                                                        {{ $device->device_owner }}
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="userDatatable-content-status mb-0 d-flex flex-wrap">
                                                                                        <span class="media-badge color-white bg-{{ $device->latestDeviceState->state ? 'active' : 'disconnected' }}">
                                                                                            {{ $device->latestDeviceState->state ? 'active' : 'disconnected' }}
                                                                                        </span>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="layout-button mt-25 ">
                                                            <button class="btn btn-light btn-default btn-squared fw-400 text-capitalize b-light color-light" data-bs-dismiss="modal" aria-label="Close" type="button">cancel</button>
                                                            <div class="dropdown dropdown-btn dropdown-hover">
                                                                <button class="btn btn-outline-lighten fs-14 fw-400 btn-primary color-white">
                                                                    <i class="la la-file-invoice color-white"></i>
                                                                    <p class="color-white">Generate Report</p>
                                                                </button>
                                                                <div class="dropdown-default dropdown-bottomCenter bg-white mt-10">
                                                                    <a class="dropdown-item" href="{{ route('software-management.exportGroupDevicesWithSoftware', ['language' => app()->getLocale(), 'id' => $software->id, 'groupId' => $group->id]) }}" class="color-white a-hover-default">With Software</a>
                                                                    <a class="dropdown-item" href="{{ route('software-management.exportGroupDevicesWithoutSoftware', ['language' => app()->getLocale(), 'id' => $software->id, 'groupId' => $group->id]) }}">Without Software</a>
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
        </div>
    </div>
</div>

@endsection
