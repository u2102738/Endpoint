<div class="sidebar__menu-group">
    <ul class="sidebar_nav">
        {{-- Dashboard --}}
        <li>
            <a href="{{ route('home',app()->getLocale()) }}" class="{{ Request::is(app()->getLocale().'/home') ? 'active':'' }}">
                <span class="nav-icon la la-home fs-xl-18"></span>
                <span class="menu-text fs-xl-15">{{ trans('menu.dashboard-menu-title') }}</span>
            </a>
        </li>

        @if (Auth::user()->hasPermission('computer_device')
            || Auth::user()->hasPermission('computer_group')
            || Auth::user()->hasPermission('software_osupdate')
            || Auth::user()->hasPermission('software_licensedSoftware')
            || Auth::user()->hasPermission('software_prohibitedSoftware'))
        <li class="menu-title mt-30">
            <span class="fs-xl-14"> Applications</span>
        </li>
        @endif

        {{-- Agent --}}
        @if (Auth::user()->hasPermission('agent'))
        <li class="has-child {{ Request::is(app()->getLocale().'/applications/agent/*') ? 'open':'' }}">
            <a href="#" class="{{ Request::is(app()->getLocale().'/applications/agent/*') ? 'active':'' }}">
                <span class="nav-icon la la-icons fs-xl-18"></span>
                <span class="menu-text fs-xl-15">{{ trans('agent') }}</span>
                <span class="toggle-icon"></span>
            </a>
            <ul class="m-auto">
                @if (Auth::user()->hasPermission('agent'))
                <li><a href="{{ route('agent.overview',app()->getLocale()) }}" class="{{ Request::is(app()->getLocale().'/applications/agent/overview') ? 'active':'' }} fs-xl-15">{{ trans('overview') }}</a></li>
                @endif
                @if (Auth::user()->hasPermission('agent'))
                <li ><a href="{{ route('agent.deployment',app()->getLocale()) }}" class="{{ Request::is(app()->getLocale().'/applications/agent/agent*') ? 'active':'' }} fs-xl-15">{{ trans('agent') }}</a></li>
                @endif
            </ul>
        </li>
        @endif

        {{-- Computers --}}
        @if (Auth::user()->hasPermission('computer_device')
            || Auth::user()->hasPermission('computer_group'))
        <li class="has-child {{ Request::is(app()->getLocale().'/applications/computer/*') ? 'open':'' }}">
            <a href="#" class="{{ Request::is(app()->getLocale().'/applications/computer/*') ? 'active':'' }}">
                <span class="nav-icon la la-laptop fs-xl-18"></span>
                <span class="menu-text fs-xl-15">{{ trans('menu.computer-menu-title') }}</span>
                <span class="toggle-icon"></span>
            </a>
            <ul class="m-auto">
                @if (Auth::user()->hasPermission('computer_device'))
                <li ><a href="{{ route('computer.device',app()->getLocale()) }}" class="{{ Request::is(app()->getLocale().'/applications/computer/device') ? 'active':'' }} fs-xl-15">{{ trans('menu.computer-device') }}</a></li>
                @endif
                @if (Auth::user()->hasPermission('computer_group'))
                <li><a href="{{ route('computer.group',app()->getLocale()) }}" class="{{ Request::is(app()->getLocale().'/applications/computer/group') ? 'active':'' }} fs-xl-15">{{ trans('menu.computer-group') }}</a></li>
                @endif
            </ul>
        </li>
        @endif

        {{-- Software Management --}}
        @if (Auth::user()->hasPermission('software_osupdate')
            || Auth::user()->hasPermission('software_licensedSoftware')
            || Auth::user()->hasPermission('software_prohibitedSoftware')
            || Auth::user()->hasPermission('software_deployment'))
        <li class="has-child {{ Request::is(app()->getLocale().'/applications/software-management/*') ? 'open':'' }}">
            <a href="#" class="{{ Request::is(app()->getLocale().'/applications/software-management/*') ? 'active':'' }}">
                <span class="nav-icon la la-icons fs-xl-18"></span>
                <span class="menu-text fs-xl-15">{{ trans('menu.software-menu-title') }}</span>
                <span class="toggle-icon"></span>
            </a>
            <ul class="m-auto">
                @if (Auth::user()->hasPermission('software_osupdate')
                    || Auth::user()->hasPermission('software_licensedSoftware')
                    || Auth::user()->hasPermission('software_prohibitedSoftware')
                    || Auth::user()->hasPermission('software_deployment'))
                <li><a href="{{ route('software-management.overview',app()->getLocale()) }}" class="{{ Request::is(app()->getLocale().'/applications/software-management/overview') ? 'active':'' }} fs-xl-15">{{ trans('menu.softwaremanagement-overview') }}</a></li>
                @endif
                @if (Auth::user()->hasPermission('software_osupdate'))
                <li><a href="{{ route('software-management.osupdate',app()->getLocale()) }}" class="{{ Request::is(app()->getLocale().'/applications/software-management/osupdate') ? 'active':'' }} fs-xl-15">{{ trans('menu.software-osupdate') }}</a></li>
                @endif
                @if (Auth::user()->hasPermission('software_licensedSoftware'))
                <li><a href="{{ route('software-management.licensedsoftware',app()->getLocale()) }}" class="{{ Request::is(app()->getLocale().'/applications/software-management/licensedsoftware*') ? 'active':'' }} fs-xl-15">{{ trans('menu.software-menu-licensed') }}</a></li>
                @endif
                @if (Auth::user()->hasPermission('software_prohibitedSoftware'))
                <li><a href="{{ route('software-management.prohibitedsoftware',app()->getLocale()) }}" class="{{ Request::is(app()->getLocale().'/applications/software-management/prohibitedsoftware*') ? 'active':'' }} fs-xl-15">{{ trans('menu.software-menu-prohibited') }}</a></li>
                @endif
            </ul>
        </li>
        @endif

        {{-- Software Deployment --}}
        @if (Auth::user()->hasPermission('software_deployment'))
        <li class="has-child {{ Request::is(app()->getLocale().'/applications/software-deployment/*') ? 'open':'' }}">
            <a href="#" class="{{ Request::is(app()->getLocale().'/applications/software-deployment/*') ? 'active':'' }}">
                <span class="nav-icon la la-icons fs-xl-18"></span>
                <span class="menu-text fs-xl-15">{{ trans('menu.software-softwaredeployment') }}</span>
                <span class="toggle-icon"></span>
            </a>
            <ul class="m-auto">
                @if (Auth::user()->hasPermission('software_deployment'))
                <li><a href="{{ route('software-deployment.overview',app()->getLocale()) }}" class="{{ Request::is(app()->getLocale().'/applications/software-deployment/overview') ? 'active':'' }} fs-xl-15">{{ trans('menu.softwaredeployment-overview') }}</a></li>
                @endif
                @if (Auth::user()->hasPermission('software_deployment'))
                <li ><a href="{{ route('software-deployment.deployment',app()->getLocale()) }}" class="{{ Request::is(app()->getLocale().'/applications/software-deployment/package*') ? 'active':'' }} fs-xl-15">{{ trans('menu.softwaredeployment-deployment') }}</a></li>
                @endif
            </ul>
        </li>
        @endif

        {{-- Audit Log --}}
        @if (Auth::user()->hasPermission('log_auth')
            || Auth::user()->hasPermission('log_activity'))
        <li class="menu-title mt-30">
            <span class="fs-xl-14"> Audit Log</span>
        </li>
        @endif

        {{-- Auth Log --}}
        @if (Auth::user()->hasPermission('log_auth'))
        <li>
            <a href="{{ route('auditlog.auth',app()->getLocale()) }}" class="{{ Request::is(app()->getLocale().'/auditlog/auth') ? 'active':'' }}">
                <span class="nav-icon la la-shield-alt fs-xl-18"></span>
                <span class="menu-text fs-xl-15">{{ trans('menu.auth-log') }}</span>
            </a>
        </li>
        @endif

        {{-- Activity Log --}}
        @if (Auth::user()->hasPermission('log_activity'))
        <li>
            <a href="{{ route('auditlog.activity',app()->getLocale()) }}" class="{{ Request::is(app()->getLocale().'/auditlog/activity') ? 'active':'' }}">
                <span class="nav-icon la la-book fs-xl-18"></span>
                <span class="menu-text fs-xl-15">{{ trans('menu.activity-log') }}</span>
            </a>
        </li>
        @endif

        {{-- Accessible to Admin only --}}
        @if (Auth::user()->role_id == 1)
            <li class="menu-title mt-30">
                <span class="fs-xl-14"> Settings</span>
            </li>

            <li>
                <a href="{{ route('settings.user.list',app()->getLocale()) }}" class="{{ Request::is(app()->getLocale().'/settings/user/list') ? 'active':'' }}">
                    <span class="nav-icon uil uil-users-alt fs-xl-18"></span>
                    <span class="menu-text fs-xl-15">{{ trans('menu.user-menu-title') }}</span>
                </a>
            </li>

            <li>
                <a href="{{ route('settings.role.list',app()->getLocale()) }}" class="{{ Request::is(app()->getLocale().'/settings/role/*') ? 'active':'' }}">
                    <span class="nav-icon la la-users-cog fs-xl-18"></span>
                    <span class="menu-text fs-xl-15">{{ trans('menu.role-menu-title') }}</span>
                </a>
            </li>


            <li class="has-child {{ Request::is(app()->getLocale().'/settings/software/*') ? 'open':'' }}">
                <a href="#" class="{{ Request::is(app()->getLocale().'/settings/software/*') ? 'active':'' }}">
                    <span class="nav-icon la la-icons fs-xl-18"></span>
                    <span class="menu-text fs-xl-15">{{ trans('menu.software-setting-menu-title') }}</span>
                    <span class="toggle-icon"></span>
                </a>
                <ul class="m-auto">
                    <li><a href="{{ route('settings.software.osversion',app()->getLocale()) }}" class="{{ Request::is(app()->getLocale().'/settings/software/osversion') ? 'active':'' }} fs-xl-15">{{ trans('menu.software-osversion') }}</a></li>
                </ul>
            </li>
        @endif
    </ul>
</div>
