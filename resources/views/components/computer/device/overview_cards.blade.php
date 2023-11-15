<div class="row">
    <div class="col-md-4">
        <div class="overview-content products-awards pt-20 pb-20 text-center radius-xl">
            <div class="d-inline-flex flex-column align-items-center justify-content-center w-32">
                <div class="revenue-chart-box__Icon order-bg-opacity-primary color-primary me-0">
                    <i class="fas fa-desktop"></i>
                </div>
                <div class="d-flex align-items-start flex-wrap">
                    <div>
                        <p class="mb-1 mb-0 color-gray">Total Devices</p>
                        <h1>{{ $total_devices }}</h1>
                    </div>
                </div>
            </div>
            <a href="{{ route('software-management.osupdate', 'en') }}" class=""> 
                <div class="d-inline-flex flex-column align-items-center justify-content-center w-32">
                    <div class="revenue-chart-box__Icon order-bg-opacity-outdated color-primary me-0">
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <div class="d-flex align-items-start flex-wrap">
                        <div>
                            <p class="mb-1 mb-0 color-gray">Outdated OS</p>
                            <h1>{{ $total_outdatedOS }}</h1>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="overview-content products-awards pt-20 pb-20 text-center radius-xl">
            <div class="d-inline-flex flex-column align-items-center justify-content-center w-30">
                <div class="revenue-chart-box__Icon order-bg-opacity-accepted color-primary me-0">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="d-flex align-items-start flex-wrap">
                    <div>
                        <p class="mb-1 mb-0 color-gray">Valid ERP</p>
                        <h1>{{ $valid_ERP }}</h1>
                    </div>
                </div>
            </div>
            <a href="{{ route('software-management.osupdate', 'en') }}" class=""> 
                <div class="d-inline-flex flex-column align-items-center justify-content-center w-30">
                    <div class="revenue-chart-box__Icon order-bg-opacity-rejected color-primary me-0">
                        <i class="fas fa-ban"></i>
                    </div>
                    <div class="d-flex align-items-start flex-wrap">
                        <div>
                            <p class="mb-1 mb-0 color-gray">Invalid ERP</p>
                            <h1>{{ $total_outdatedOS }}</h1>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="overview-content products-awards pt-20 pb-20 text-center radius-xl">
            <div class="d-inline-flex flex-column align-items-center justify-content-center w-30">
                <div class="revenue-chart-box__Icon order-bg-opacity-accepted color-info me-0">
                    <i class="fas fa-check"></i>
                </div>
                <div class="d-flex align-items-start flex-wrap">
                    <div>
                        <p class="mb-1 mb-0 color-gray">Accepted</p>
                        <h1>{{ $accepted }}</h1>
                    </div>
                </div>
            </div>
            <div class="d-inline-flex flex-column align-items-center justify-content-center w-30">
                <div class="revenue-chart-box__Icon order-bg-opacity-rejected color-info me-0">
                    <i class="fas fa-times"></i>
                </div>
                <div class="d-flex align-items-start flex-wrap">
                    <div>
                        <p class="mb-1 mb-0 color-gray">Rejected</p>
                        <h1>{{ $rejected }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="overview-content products-awards pt-20 pb-20 text-center radius-xl">
            <div class="d-inline-flex flex-column align-items-center justify-content-center w-30">
                <div class="revenue-chart-box__Icon order-bg-opacity-active color-info me-0">
                    <i class="fas fa-link"></i>
                </div>
                <div class="d-flex align-items-start flex-wrap">
                    <div>
                        <p class="mb-1 mb-0 color-gray">Active</p>
                        <h1>{{ $active }}</h1>
                    </div>
                </div>
            </div>
            <div class="d-inline-flex flex-column align-items-center justify-content-center w-30">
                <div class="revenue-chart-box__Icon order-bg-opacity-disconnected color-info me-0">
                    <i class="fas fa-unlink"></i>
                </div>
                <div class="d-flex align-items-start flex-wrap">
                    <div>
                        <p class="mb-1 mb-0 color-gray">Disconnected</p>
                        <h1>{{ $disconnected }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

