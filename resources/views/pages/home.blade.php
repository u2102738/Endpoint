@section('title',$title)
@section('description',$description)
@extends('layout.app')
@section('content')
<div class="d-flex mt-2">
    <div class="container-fluid col-lg-9">
        <div class=" mb-xxl-45 mb-25">
            <div class="card banner-feature--13 d-flex">
                <div class="d-flex align-items-center flex-sm-nowrap flex-wrap text-sm-start text-center">
                    <div class="card-body">
                        <h2 class="banner-feature__heading color-white">Welcome Back, {{Auth::user()->name}}!</h2>
                        <p class="banner-feature__para color-white fs-xl-18">Simplify your workday and enhance productivity with our user-friendly platform.<br> Let's make your tasks easier and more enjoyable.</p>
                    </div>
                    <div class="banner-feature__shape w-25 text-center">
                        <img src="{{ asset('assets/img/logo_3d_white.png') }}" alt="" class="dashboard-logo">
                    </div>
                </div>
            </div>
        </div>

        @if (Auth::user()->hasPermission('computer_device'))
        <div class="row mt-10">
            {{-- Device Status Overview --}}
            <div class="col-lg-7 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="fs-xl-20">Device Status Overview</h6>
                    </div>
                    <div class="card-body">
                        <div>
                            <canvas id="lineChartBasic" data-accepted-data="{{ json_encode($acceptedData) }}" data-rejected-data="{{ json_encode($rejectedData) }}"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Active Devices --}}
            <div class="col-xxl-5 col-lg-5 mb-25">
                <div class="card revenueChartTwo border-0 h-100">
                    <div class="card-header">
                        <h6 class="fs-xl-20">Active Devices</h6>
                        {{-- <p class="fs-xl-20">Accepted Devices Only</p> --}}
                    </div>
                    <div class="card-body d-flex align-center">
                        <div class="parentContainer position-relative w-50">
                            <div class="storage color-primary" data-active-percentage="{{ $activePercentage }}">
                                <div class="storage"></div>
                            </div>
                        </div>
                        <div class="sales-target d-flex justify-content-around w-50">
                            <div class="sales-target__single text-center">
                                <span class="fs-xl-20">Total Active (Devices)</span>
                                @if ($totalDevicesCount != 0)
                                    <h3>{{ $activeDevicesCount }} / {{ $totalDevicesCount }}</h3>
                                @else
                                    <h3>0</h3>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            @if (Auth::user()->hasPermission('software_osupdate'))
            <div class="col-xxl-6 col-sm-6 col-md-6 col-ssm-12 mb-25">
                {{-- Active Devices with Outdated OS Card --}}
                <div class="ap-po-details ap-po-details--luodcy  overview-card-shape radius-xl d-flex justify-content-between">
                    <div class=" ap-po-details-content d-flex flex-wrap justify-content-between w-100">
                        <div class="ap-po-details__titlebar">
                            <p class="fs-xl-18">Active Devices with Outdated OS</p>
                            <h1>{{ $outdatedOSdevices }}</h1>
                            <div class="ap-po-details-time">
                                <span class="color-warning"><i class="la la-smile fs-xl-16"></i>
                                @if (Auth::user()->role_id == 1)
                                <a href="{{ route('settings.software.osversion',app()->getLocale()) }}">
                                    <strong class="fs-xl-16">{{ $osVersion }}</strong>
                                </a>
                                @else
                                    <strong class="fs-xl-16">{{ $osVersion }}</strong>
                                @endif
                                </span>
                                <small class="fs-xl-16">Recommended Version</small>
                            </div>
                        </div>
                        <a href="{{ route('software-management.osupdate',app()->getLocale()) }}">
                            <div class="ap-po-details__icon-area color-danger">
                                <i class="uil uil-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
                {{-- End of Active Devices with Outdated OS Card --}}
            </div>
            @endif

            @if (Auth::user()->hasPermission('software_prohibitedSoftware'))
            <div class="col-xxl-6 col-sm-6 col-md-6 col-ssm-12 mb-25">
                {{-- Prohibited Software with Devices Card --}}
                <div class="ap-po-details ap-po-details--luodcy  overview-card-shape radius-xl d-flex justify-content-between">
                    <div class=" ap-po-details-content d-flex flex-wrap justify-content-between w-100">
                        <div class="ap-po-details__titlebar">
                            <p class="fs-xl-18">Prohibited Software with Device(s)</p>
                            <h1>{{ $prohibitedSoftwareWithDevices }}</h1>
                            <div class="ap-po-details-time">
                                <span class="color-danger"><i class="la la-exclamation-circle fs-xl-16"></i>
                                    <strong class="fs-xl-16">{{ $prohibitedSoftwareCount }}</strong>
                                </span>
                                <small class="fs-xl-16">Prohibited Software</small>
                            </div>
                        </div>
                        <a href="{{ route('software-management.prohibitedsoftware',app()->getLocale()) }}">
                            <div class="ap-po-details__icon-area color-danger">
                                <i class="uil uil-arrow-circle-right"></i>
                            </div>
                        </a>

                    </div>
                </div>
                {{-- End of Prohibited Software with Devices Card --}}
            </div>
            @endif
        </div>
    </div>
    {{-- Notification --}}
    <div class="col-xxl-3 col-lg-3 mb-25">
        <div class="card border-0 card-inbox" id="notification-card">
            <div class="card-header border-0">
                <h6 class="fs-xl-20">Notification</h6>
            </div>
            <div class="card-body pb-35 pt-0 card-body-scrollable-notification">
                <div class="card-inbox-members">
                    <ul>
                        @if (count($allNotifications) == 0)
                            <p class="text-center pb-2 fs-xl-18">No Notification !</p>
                        @else
                            @foreach ($allNotifications as $notification)
                                <li>
                                    <div class="card-inbox-members__left">
                                        <div class="card-inbox-members__title m-2 w-70">
                                            <h6 class="fs-xl-18">{{ $notification->activity->user->name }}</h6>
                                            <div class="card-inbox-members__title--online w-100 fs-xl-16">
                                                {{ $notification->activity->description }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inbox-member__right w-30 text-end">
                                        <div class="card-inbox-member__time">
                                            <span class="fs-xl-16">{{ $notification->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

