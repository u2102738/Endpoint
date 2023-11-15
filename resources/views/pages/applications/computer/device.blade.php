@section('title',$title)
@section('description',$description)
@extends('layout.app')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mb-30">
            <div class="breadcrumb-main">
                <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                    <div class="d-flex align-items-center user-member__title justify-content-center me-sm-25">
                        <h4 class="text-capitalize fw-500 breadcrumb-title">{{ trans('menu.computer-device') }}</h4>
                    </div>
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
            @include('components.computer.device.overview_cards')

            <div class="card mt-15">
                <div class="card-body">
                    <div class="userDatatable adv-table-table global-shadow border-0 bg-white w-100 adv-table">
                        <div class="table-responsive">
                            <div id="filter-form-container"></div>
                            <table class="table mb-0 table-borderless adv-table-filter" data-sorting="true" data-filter-container="#filter-form-container" data-paging-current="1" data-paging-position="right" data-paging-size="5" id="deviceTable">
                                <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">name</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">device owner</span>
                                        </th>
                                        <th class="text-center" data-type="html" data-name='status'>
                                            <span class="userDatatable-title">status</span>
                                        </th>
                                        <th class="text-center" data-type="html" data-name='state'>
                                            <span class="userDatatable-title">state</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($devices) == 0)
                                        <tr>
                                            <td colspan="4">
                                                <p class="text-center">No Device Found !</p>
                                            </td>
                                            <td class="d-none"></td>
                                            <td class="d-none"></td>
                                            <td class="d-none"></td>
                                        </tr>
                                    @else
                                        @foreach ($devices as $device)
                                        <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="userDatatable-inline-title">
                                                        @if ($device->status == 0)
                                                            <h6>{{ $device->name }}</h6>
                                                        @else
                                                            @if ($device->hasOutdatedOS)
                                                                <a href="{{ route('computer.device_detail', [app()->getLocale(), $device->id]) }}" class="text-dark fw-500">
                                                                    <h6>{{ $device->name }} <i class="fas fa-exclamation-triangle warning-color"></i></h6>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('computer.device_detail', [app()->getLocale(), $device->id]) }}" class="text-dark fw-500">
                                                                    <h6>{{ $device->name }}</h6>
                                                                </a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content-status mb-0 d-flex flex-wrap justify-content-sm-start p-0" style="text-transform: none;">
                                                    <h6>{{ $device->device_owner }}</h6>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content-status mb-0 d-flex flex-wrap">
                                                    <span class="media-badge color-white bg-{{ $device->status ? 'success' : 'danger' }}">
                                                        {{ $device->status ? 'accepted' : 'rejected' }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($device->latestDeviceState === null || $device->latestDeviceState->state === null)
                                                    <div class="userDatatable-content-status mb-0 d-flex flex-wrap">
                                                        <span class="media-badge">
                                                            <i class="fas fa-minus"></i>
                                                        </span>
                                                    </div>
                                                @else
                                                    <div class="userDatatable-content-status mb-0 d-flex flex-wrap">
                                                        <span class="media-badge color-white bg-{{ $device->latestDeviceState->state ? 'active' : 'disconnected' }}">
                                                            {{ $device->latestDeviceState->state ? 'active' : 'disconnected' }}
                                                        </span>
                                                    </div>
                                                @endif
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
@endsection
