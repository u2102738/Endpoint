@section('title',$title)
@section('description',$description)
@extends('layout.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mt-15">
            <div class="card card-default card-md mb-3">
                <form action="{{ route('auditlog.activity', app()->getLocale()) }}" method="GET">
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
        <div class="col-12 changelog-15 d-block">
            <div class="col-12 mb-15">
                <div class="card border-0">
                    <div class="card-header">
                        <h6>{{ trans('page_title.activitylog') }}</h6>
                    </div>
                    <div class="card-body p-0 m-10">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="st_matrics-today" role="tabpanel" aria-labelledby="st_matrics-today-tab">
                                <div class="table-responsive card-body-scrollable-activitylog">
                                    <table class="table table-bordered table-social">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">Time</th>
                                                <th scope="col">Activity ID</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Event Type</th>
                                                <th scope="col">Event Status</th>
                                                <th scope="col">Description</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            @if (count($activity_log) == 0)
                                                <tr>
                                                    <td colspan="6">
                                                        <p class="text-center">No Activity Found !</p>
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach ($activity_log as $index => $log)
                                                    <tr>
                                                        <td>{{ $log->created_at }}</td>
                                                        <td>
                                                            <a href="">{{ $log->id }}</a>
                                                        </td>
                                                        <td>
                                                            <a href="">{{ $log->user->name }}</a>
                                                        </td>
                                                        <td>{{ $log->event_type }}</td>
                                                        <td>
                                                            <div class="userDatatable-content-status mb-0 d-flex flex-wrap">
                                                                <span class="media-badge color-white bg-{{ $log->event_status ? 'success' : 'danger' }}">
                                                                    {{ $log->event_status ? 'Successful' : 'Failed' }}
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex text-left">
                                                                @if($log->user_id_affected !== null && $log->userAffected)
                                                                <div class="dropdown">
                                                                    <a class="btn-link me-2" href="#" role="button" id="dropdownMenuLink{{ $index }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="la la-info-circle"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink{{ $index }}">
                                                                        <span class="dropdown-item">ID: {{ $log->user_id_affected }}</span>
                                                                        <span class="dropdown-item">Name: {{ $log->userAffected->name }}</span>
                                                                        <span class="dropdown-item">Role: {{ $log->userAffected->role->name }}</span>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                {{ $log->description }}
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
        <div class="col-12 changelog-6 d-block">
            <div class="changeLog-history mb-30">
                <div class="card">
                    <div class="card-header py-20 px-20">
                        <div class="changelog-history__title text-uppercase">
                            ACTIVITY LOG
                        </div>
                        <div class="changelog-history__titleExtra">

                        </div>
                    </div>
                    <div class="card-body p-20">
                        <h4 class="history-title">USER ACTIVITY &mdash; TODAY</h4>
                        <ul class="v-history-list">
                            <li>
                                <span class="version-name">Successful</span><span class="version-date">{{$userSuccessful}}</span>
                            </li>
                            <li>
                                <span class="version-name">Failed</span><span class="version-date">{{$userFailed}}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-20">
                        <h4 class="history-title">ROLE ACTIVITY &mdash; TODAY</h4>
                        <ul class="v-history-list">
                            <li>
                                <span class="version-name">Successful</span><span class="version-date">{{$roleSuccessful}}</span>
                            </li>
                            <li>
                                <span class="version-name">Failed</span><span class="version-date">{{$roleFailed}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
