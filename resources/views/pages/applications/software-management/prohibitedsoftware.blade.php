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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">{{ trans('menu.software-prohibitedsoftware') }}</h4>
                        </div>
                    </div>
                    <div class="action-btn">
                        <a href="#" class="btn px-15 btn-primary" data-bs-toggle="modal" data-bs-target="#edit-softwarerestriction"><i class="fas fa-edit"></i> Software Restriction</a>

                        {{-- Edit Software Restriction Modal --}}
                        <div class="modal fade edit-user " id="edit-softwarerestriction" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content  radius-xl">
                                    <div class="modal-header">
                                        <h6 class="modal-title fw-500" id="staticBackdropLabel">Edit Software Restriction</h6>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <img src="{{ asset('assets/img/svg/x.svg') }}" alt="x" class="svg">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="edit-user-modal">
                                            <form method="post" action="{{ route('software-management.updateSoftwareRestriction','en') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row mb-20">
                                                    <div class="col-sm-3 d-flex align-items-center">
                                                        <label for="software-member" class=" col-form-label color-dark fs-14 fw-500 align-center">Software</label>
                                                    </div>
                                                    <div class="category-member col-sm-9">
                                                        <select class="js-example-basic-single js-states form-control" id="software-member" name="software">
                                                            <option value=""></option>
                                                            @foreach($allSoftware as $software)
                                                                <option value="{{ $software->id }}" data-restriction="{{ $software->restriction }}">{{ $software->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('software'))
                                                            <p class="text-danger">{{ $errors->first('software') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-20">
                                                    <div class="col-sm-3 d-flex align-items-center">
                                                        <label for="restriction-member" class="col-form-label color-dark fs-14 fw-500 align-center">Restriction</label>
                                                    </div>
                                                    <div class="category-member col-sm-9">
                                                        <div class="form-check form-switch form-switch-primary form-switch-sm">
                                                            <input type="checkbox" class="form-check-input" id="restriction-member" name="restriction">
                                                            <h6 id="restriction-label" for="restriction-member" class="lh-lg"></h6>
                                                        </div>
                                                        @if ($errors->has('restriction'))
                                                            <p class="text-danger">{{ $errors->first('restriction') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0">
                                                    <div class="col-sm-9">
                                                        <div class="layout-button mt-25">
                                                            <button type="submit" class="btn btn-primary btn-default btn-squared px-30" id="edit-softwarerestriction">Save</button>
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

                @include('components.software-management.prohibitedsoftware.overview_cards')
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
                                    <th scope="col">
                                        <span class="userDatatable-title">#</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Name</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Version</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">counter (devices)</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($prohibitedSoftware) == 0)
                                    <tr>
                                        <td colspan="4">
                                            <p class="text-center">No Prohibited Software Found !</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($prohibitedSoftware as $software)
                                        <tr>
                                            <td>
                                                <div class="userDatatable-content">{{ $loop->iteration }}</div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content" style="text-transform: none;">
                                                    <a href="{{ route('software-management.prohibitedsoftware_detail', [app()->getLocale(), $software->id]) }}" class="text-dark">
                                                        <h6>{{ $software->name }}</h6>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content" style="text-transform: none;">
                                                    {{ $software->version }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content text-center">
                                                    {{ $software->deviceSoftware()->count() }} / {{ $totalDevices }}
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
@endsection
