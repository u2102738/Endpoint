@section('title',$title)
@section('description',$description)
@extends('layout.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mt-15">
            <div class="card card-default card-md mb-3">
                <form action="{{ route('auditlog.auth', app()->getLocale()) }}" method="GET">
                    <div class="dm-date-ranger position-relative d-flex align-items-center">
                        <div class="form-group mb-0">
                            <input type="text" name="date-range-from" class="form-control form-control-sm" id="date-from-11" placeholder="Start" autocomplete="off">
                        </div>
                        <span class="divider">-</span>
                        <div class="form-group mb-0">
                            <input type="text" name="date-range-to" class="form-control form-control-sm" id="date-to-11" placeholder="End" autocomplete="off">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary btn-default btn-squared px-100">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 changelog-15 d-block mb-10">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-header">
                        <h6>{{ trans('page_title.authlog') }}</h6>
                    </div>
                    <div class="card-body p-0 m-10">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="st_matrics-today" role="tabpanel" aria-labelledby="st_matrics-today-tab">
                                <div class="table-responsive card-body-scrollable">
                                    <table class="table table-bordered table-social">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">Time</th>
                                                <th scope="col">Auth ID</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Login Status</th>
                                                <th scope="col">Description</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            @if (count($auth_log) == 0)
                                                <tr>
                                                    <td colspan="5">
                                                        <p class="text-center">No Authentication History Found !</p>
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach ($auth_log as $index => $log)
                                                    <tr>
                                                        <td>{{ $log->created_at }}</td>
                                                        <td>
                                                            <a href="">{{ $log->id }}</a>
                                                        </td>

                                                        <td class="d-flex">
                                                            @if($log->user_id !== null && $log->user && $log->user->exists)
                                                                @if ($log->user->trashed())
                                                                    {{ $log->user->name }}
                                                                @else
                                                                    <div class="dropdown">
                                                                        <a class="btn-link me-2" href="#" role="button" id="dropdownMenuLink{{ $index }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <i class="la la-info-circle"></i>
                                                                        </a>
                                                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink{{ $index }}">
                                                                            <span class="dropdown-item">ID: {{ $log->user_id }}</span>
                                                                            <span class="dropdown-item">Name: {{ $log->user->name }}</span>
                                                                            <span class="dropdown-item">Role: {{ $log->user->role->name }}</span>
                                                                        </div>
                                                                    </div>
                                                                    {{ $log->user->name }}
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="userDatatable-content-status mb-0 d-flex flex-wrap">
                                                                <span class="media-badge color-white bg-{{ $log->type ? 'success' : 'danger' }}">
                                                                    {{ $log->type ? 'Successful' : 'Failed' }}
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="d-flex text-left">{{ $log->description }}</td>
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
        <div class="col-12 changelog-6 d-block">
            <div class="changeLog-history mb-30">
                <div class="card">
                    <div class="card-header py-20 px-20">
                        <div class="changelog-history__title text-uppercase">
                            AUTH LOG
                        </div>
                        <div class="changelog-history__titleExtra">

                        </div>
                    </div>
                    <div class="card-body p-20">
                        <h4 class="history-title">SUCCESSFUL LOGIN HISTORY</h4>
                        <ul class="v-history-list">
                            <li>
                                <span class="version-name">Today</span><span class="version-date">{{ $successfulToday }}</span>
                            </li>
                            <li>
                                <span class="version-name">Yesterday</span><span class="version-date">{{ $successfulYesterday }}</span>
                            </li>
                            <li>
                                <span class="version-name">This Month</span><span class="version-date">{{ $successfulThisMonth }}</span>
                            </li>
                            <li>
                                <span class="version-name">Last Month</span><span class="version-date">{{ $successfulLastMonth }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-20">
                        <h4 class="history-title">FAILED LOGIN HISTORY</h4>
                        <ul class="v-history-list">
                            <li>
                                <span class="version-name">Today</span><span class="version-date">{{ $failedToday }}</span>
                            </li>
                            <li>
                                <span class="version-name">Yesterday</span><span class="version-date">{{ $failedYesterday }}</span>
                            </li>
                            <li>
                                <span class="version-name">This Month</span><span class="version-date">{{ $failedThisMonth }}</span>
                            </li>
                            <li>
                                <span class="version-name">Last Month</span><span class="version-date">{{ $failedLastMonth }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

