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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">{{ trans('agents') }}</h4>
                        </div>
                    </div>
                    <div class="action-btn">
                        <a href="#" class="btn px-15 btn-primary" data-bs-toggle="modal" data-bs-target="#add-agent">
                        <i class="las la-plus fs-16"></i>Assign Agents</a>

                        {{-- Modal --}}
                        <div class="modal fade new-role" id="add-agent" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content radius-xl">
                                    <div class="modal-header">
                                        <h6 class="modal-title fw-500" id="staticBackdropLabel">Assign Agents</h6>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <i class="uil uil-times"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="new-member-modal">
                                            <form method="post" action="{{ route('agent.agentStore', app()->getLocale()) }}" enctype="multipart/form-data" onsubmit="handleFormSubmit(event)" id="new-agent">
                                                @csrf
                                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                                <!-- Your existing HTML structure and content -->
                                                <div class="form-group textarea-group">
                                                    <label>Access</label>
                                                    <hr>
                                                    <div class="dm-tag-mode">
                                                        <div class="dm-select">
                                                        <select name="ldap[]" id="select-tag" class="form-control" multiple="multiple">
                                                            @if (!empty($ldapData))
                                                                @foreach ($ldapData as $ldapEntry)
                                                                    <option value="{{ $ldapEntry['dn'] }}">
                                                                        {{ $ldapEntry['uid'] }} ({{ $ldapEntry['cn'] }})
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        </div>
                                                    </div>
                                                    @error('permissions')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="button-group d-flex pt-25">
                                                    <button class="btn btn-primary btn-default btn-squared text-capitalize btn-add-agent" type="submit">Assign agent</button>
                                                    <button class="btn btn-light btn-default btn-squared fw-400 text-capitalize b-light color-light" data-bs-dismiss="modal" aria-label="Close" type="button">Cancel</button>
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
                        <div class="content-center">
                            <div class="button-group m-0 mt-sm-0 mt-10 order-button-group">
                                <a href="#" class="btn px-15 btn-primary" data-bs-toggle="modal" data-bs-target="#send-email-agent"><i class="fas fa-envelope"></i> Send Email </a>
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
                                                <div class="checkbox-theme-default custom-checkbox check-all-agent">
                                                    <input class="checkbox check-all-group" type="checkbox" id="check-23">
                                                    <label for="check-23">
                                                        <span class="checkbox-text ">
                                                            Username
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Status</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Link</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Timestamp</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($agents) == 0)
                                <tr>
                                    <td colspan="4">
                                        <p class="text-center">No agent Found !</p>
                                    </td>
                                    <td class="d-none"></td>
                                    <td class="d-none"></td>
                                    <td class="d-none"></td>
                                    <td class="d-none"></td>
                                </tr>
                                @else
                                    @foreach ($agents as $agent)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="checkbox-group-wrapper">
                                                        <div class="checkbox-group d-flex me-1">
                                                            <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                                <input class="checkbox" type="checkbox" id="check-{{ $agent->id }}" name="agent[]" value="{{ $agent->id }}">
                                                                <label for="check-{{ $agent->id }}"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="" class="text-dark">
                                                    <div class="orderDatatable-title">
                                                        <h6 class="agent-name">{{ $agent->username }}</h6>
                                                    </div>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content" style="text-transform: none;">
                                                {{ $agent->status }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content" style="text-transform: none;">
                                                {{ $agent->link_path }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content text-center" style="text-transform: none;">
                                                {{ $agent->created_at->format('d M Y (D), H:i:s') }}
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{-- Send Email modal --}}
                        <div class="modal-info-update-reminder modal fade show" id="send-email-agent" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-info" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="modal-info-body d-flex">
                                            <div class="modal-info-text w-100">
                                                <h6>Send email to this agent(s)?</h6>
                                                <div class="overflow-y-scroll"></div>
                                                <p><i class="uil uil-exclamation-circle"></i> This process cannot be undone!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('agent.sendEmail','en') }}" method="post" id="send-email-form">
                                            @csrf
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-default btn-squared border-normal bg-normal px-20" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary btn-default btn-squared px-30">Yes</button>
                                            </div>
                                        </form>
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
</div>
@endsection
