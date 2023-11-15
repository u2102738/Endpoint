@section('title',$title)
@section('description',$description)
@extends('layout.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">{{ trans('menu.computer-device') }}</h4>
                <div class="breadcrumb-action justify-content-center flex-wrap">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('computer.device',app()->getLocale()) }}"><i class="las la-home"></i>Device</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ trans('menu.computer-device-detail') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card card-default card-md mb-4">
                <div class="page-title-bg bg-white">
                    <div class="page-title-wrap ">
                        <div class="page-title d-flex justify-content-between">
                            <div class="page-title__left">
                                <a href="#" onclick="goBack()"><i class="las la-arrow-left"></i></a>
                                <span class="title-text">{{$find_device->first()->name}}</span>
                                @foreach ($find_device as $device)
                                    <span class="media-badge color-white bg-{{ $device->latestDeviceState ? 'active' : 'disconnected' }} m-15">
                                        {{ $device->latestDeviceState ? 'active' : 'disconnected' }}
                                    </span>
                                    @if ($device->hardware->OS_Version < $recommendedOSVersion)
                                        <span class="media-badge color-white order-bg-opacity-outdated">Outdated - OS Version</span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="page-info d-space-between">
                        <div class="page-info__item">
                            <div class="page-info__single">
                                <span class="info-title">Device Owner:</span>
                                <span class="info-text">{{ $find_device->first()->device_owner }}</span>
                            </div>
                        </div>
                        <div class="page-info__item">
                            <div class="page-info__single">
                                <span class="info-title">UP Time :</span>
                                @foreach ($find_device as $device)
                                    @if($device->latestDeviceState && $device->latestDeviceState->uptime != null)
                                        <span class="info-text">{{ $device->latestDeviceState->uptime }}</span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="page-info__item">
                            <div class="page-info__single">
                                <span class="info-title">Added on :</span>
                                <span class="info-text">{{ $find_device->first()->created_at->format('d F Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-wrapper">

                        <div class="dm-tab tab-horizontal">
                            <ul class="nav nav-tabs vertical-tabs" role="tablist">

                                <li class="nav-item">
                                    <a class="nav-link active" id="tab-v-1-tab" data-bs-toggle="tab" href="#tab-v-1" role="tab" aria-selected="true">Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-v-2-tab" data-bs-toggle="tab" href="#tab-v-2" role="tab" aria-selected="false">Software</a>
                                </li>

                            </ul>
                            <div class="tab-content">
                                {{-- Details Tab --}}
                                <div class="tab-pane fade p-10 show active" id="tab-v-1" role="tabpanel" aria-labelledby="tab-v-1-tab">
                                    <h5>Machine Specification</h5>
                                    <div class="mt-30 d-space-between">
                                        <div class="page-info__item">
                                            <div class="page-info__single">
                                                <p>Device ID</p>
                                                <strong><span class="info-text">{{ $find_device->first()->id }}</span></strong>
                                            </div>
                                        </div>

                                        <div class="page-info__item">
                                            <div class="page-info__single">
                                                <p>Device Name</p>
                                                <strong><span class="info-text">{{$find_device->first()->name}}</span></strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-20 d-space-between">
                                        <div class="page-info__item">
                                            <div class="page-info__single">
                                                <p>OS_Version</p>
                                                <strong><span class="info-text">{{ $find_device->first()->hardware->OS_Version }}</span></strong>
                                            </div>
                                        </div>

                                        <div class="page-info__item">
                                            <div class="page-info__single">
                                                <p>Serial Number</p>
                                                <strong><span class="info-text">{{ $find_device->first()->hardware->serial_number }}</span></strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-20 d-space-between">
                                        <div class="page-info__item">
                                            <div class="page-info__single">
                                                <p>Vendor</p>
                                                <strong><span class="info-text">{{ $find_device->first()->hardware->vendor }}</span></strong>
                                            </div>
                                        </div>

                                        <div class="page-info__item">
                                            <div class="page-info__single">
                                                <p>Domain</p>
                                                <strong><span class="info-text">{{ $find_device->first()->hardware->domain }}</span></strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-20 d-space-between">
                                        <div class="page-info__item">
                                            <div class="page-info__single">
                                                <p>System Family</p>
                                                <strong><span class="info-text">{{ $find_device->first()->hardware->system_family }}</span></strong>
                                            </div>
                                        </div>

                                        <div class="page-info__item">
                                            <div class="page-info__single">
                                                <p>Version</p>
                                                <strong><span class="info-text">{{ $find_device->first()->hardware->version }}</span></strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Software Tab --}}
                                <div class="tab-pane fade p-10" id="tab-v-2" role="tabpanel" aria-labelledby="tab-v-2-tab">
                                    <div class="card mt-0">
                                        <div class="card-header color-dark fw-500">
                                            Downloaded
                                          </div>
                                        <div class="card-body-software">
                                            <div class="userDatatable adv-table-table global-shadow border-0 bg-white w-100 adv-table">
                                                <div class="table-responsive">
                                                    <div id="filter-form-container"></div>
                                                    <table class="table mb-0 table-borderless adv-table-user mt-10" data-sorting="true" data-filter-container="#filter-form-container" data-paging-current="1" data-paging-position="right" data-paging-size="10">
                                                        <thead>
                                                            <tr class="userDatatable-header">
                                                                <th>
                                                                    <span class="userDatatable-title">Name</span>
                                                                </th>
                                                                <th class="text-center">
                                                                    <span class="userDatatable-title">Version</span>
                                                                </th>
                                                                <th>
                                                                    <span class="userDatatable-title">Type</span>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (count($devices) == 0)
                                                                <tr>
                                                                    <td colspan="3">
                                                                        <p class="text-center">No Software Found !</p>
                                                                    </td>
                                                                    <td class="d-none"></td>
                                                                    <td class="d-none"></td>
                                                                </tr>
                                                            @else
                                                                @foreach ($devices as $software)
                                                                    <tr>
                                                                        <td>
                                                                            <div class="userDatatable-content">
                                                                                {{ $software->allSoftware->name }}
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="userDatatable-content text-center">
                                                                                {{ $software->allSoftware->version }}
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="userDatatable-content">
                                                                                <div class="userDatatable-content-status mb-0 d-flex flex-wrap">
                                                                                    <span class="media-badge color-white bg-{{ $software->allSoftware->type ? 'active' : 'disconnected' }}">
                                                                                        {{ $software->allSoftware->type ? 'Licensed' : 'Without License' }}
                                                                                    </span>
                                                                                </div>
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
                        </div>
                    </div>
                </div>
            </div>
            <!-- ends: .card -->
        </div>
    </div>
</div>
@endsection

