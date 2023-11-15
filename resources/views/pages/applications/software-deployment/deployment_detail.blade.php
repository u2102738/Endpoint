@section('title',$title)
@section('description',$description)
@extends('layout.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">{{ trans('menu.softwaredeployment-packages') }} — {{ $package->name }}</h4>
                <div class="breadcrumb-action justify-content-center flex-wrap">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('software-deployment.deployment','en') }}"><i class="las la-home"></i>Packages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ trans('menu.softwaredeployment-deploy') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
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

                    <div class="content-center">
                        <div class="button-group m-0 mt-sm-0 mt-10 order-button-group">
                            <a href="#" class="btn px-15 btn-primary" data-bs-toggle="modal" data-bs-target="#send-reminder-device"><i class="fa fa-rocket"></i> Deploy</a>
                        </div>
                    </div>

                </div>
                <div class="table-responsive card-body-scrollable">
                    <table class="table mb-0 table-borderless border-0" id="deviceTable">
                        <thead class="sticky-top">
                            <tr class="userDatatable-header">
                                <th scope="col">
                                    <div class="d-flex align-items-center">
                                        <div class="bd-example-indeterminate">
                                            <div class="checkbox-theme-default custom-checkbox check-all">
                                                <input class="checkbox check-all" type="checkbox" id="check-23">
                                                <label for="check-23">
                                                    <span class="checkbox-text ">
                                                        Device Name
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th scope="col">
                                    <span class="userDatatable-title">Device Owner</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($devices) == 0)
                                <tr>
                                    <td colspan="2">
                                        <p class="text-center">No device found!</p>
                                    </td>
                                </tr>
                            @else
                                @foreach ($devices as $device)
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
                                            <a href="{{ route('computer.device_detail', [app()->getLocale(), $device->id]) }}" class="text-dark">
                                                <div class="orderDatatable-title">
                                                    <h6 class="device-name">{{ $device->name }}</h6>
                                                </div>
                                            </a>
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

                    {{-- Send Update Reminder confirmation modal --}}
                    <div class="modal-info-deploy-reminder modal fade show" id="send-reminder-device" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-info" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="modal-info-body d-flex">

                                        <div class="modal-info-text w-100">
                                            <h6>Send update reminder to this device(s)?</h6>
                                            <div class="overflow-y-scroll"></div>
                                            <p><i class="uil uil-exclamation-circle"></i> This process cannot be undone!</p>
                                        </div>

                                    </div>
                                </div>

                                <div class="modal-footer">
                                    {{-- <form action="" method="post" id="send-reminder-form">
                                        @csrf --}}
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-default btn-squared border-normal bg-normal px-20" data-bs-dismiss="modal">No</button>
                                            <button type="submit" class="btn btn-primary btn-default btn-squared px-30">Yes</button>
                                        </div>
                                    {{-- </form> --}}
                                </div>
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
