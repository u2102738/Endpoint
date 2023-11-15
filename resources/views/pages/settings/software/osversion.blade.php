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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">{{ trans('menu.software-osversion') }}</h4>
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
            </div>
            <div class="col-xxl-12 mb-25">
                <div class="card knowledge-base border-0 py-sm-30 px-sm-25">
                    <h1>Recommended Version</h1>
                    <form action="{{ route('settings.software.updateOSVersion','en') }}" method="POST">
                        @csrf
                        <input type="text" class="form-control ih-medium ip-gray radius-xs b-light text-center" id="version" name="version" placeholder="Version" value="{{ $osVersion }}" autocomplete="off">
                        <button type="submit" class="btn btn-primary mt-10">
                            <i class="fas fa-save"></i>Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
