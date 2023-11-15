<nav class="navbar navbar-light">
    <div class="navbar-left">
        <div class="logo-area">
            <a class="navbar-brand" href="{{ route('home',app()->getLocale()) }}">
                <img class="dark" src="{{ asset('assets/img/logo-dark.png') }}" alt="img">
                <img class="light" src="{{ asset('assets/img/logo-white.png') }}" alt="img">
            </a>
            <a href="#" class="sidebar-toggle">
                <img class="svg" src="{{ asset('assets/img/svg/align-center-alt.svg') }}" alt="img"></a>
        </div>
    </div>
    <div class="navbar-right">
        <ul class="navbar-right__menu">
            <li class="nav-notification">
                <div class="dropdown-custom">
                    <a href="javascript:;" class="{{ $unreadNotificationsCount > 0 ? ' nav-item-toggle icon-active' : '' }}">
                        <img class="svg" src="{{ asset('assets/img/svg/alarm.svg') }}" alt="img">
                    </a>
                    <div class="dropdown-wrapper">
                        <h2 class="dropdown-wrapper__title">Notifications
                            @if ($unreadNotificationsCount > 99)
                             <span class="badge badge-round badge-danger badge-lg ms-1">99+</span>
                            @elseif ($unreadNotificationsCount > 0)
                                <span class="badge badge-round badge-danger badge-lg ms-1">{{ $unreadNotificationsCount }}</span>
                            @endif
                        </h2>
                        <ul class="notifications-list">
                            @if (count($notifications) == 0)
                                <p class="text-center pb-2">No Notification !</p>
                            @else
                                @foreach ($notifications as $notification)
                                    <form method="POST" action="{{ route('social.markAsRead', [app()->getLocale(), $notification->id]) }}" class="notification-form" id="notification-form-{{ $notification->id }}">
                                        @csrf
                                    @if (Str::contains($notification->activity->event_type, 'User'))
                                        <a href="{{ route('settings.user.list',app()->getLocale()) }}" class="text-dark" onclick="document.getElementById('notification-form-{{ $notification->id }}').submit(); return false;">
                                    @elseif(Str::contains($notification->activity->event_type, 'Role'))
                                        <a href="{{ route('settings.role.list',app()->getLocale()) }}" class="text-dark" onclick="document.getElementById('notification-form-{{ $notification->id }}').submit(); return false;">
                                    @elseif (Str::contains($notification->activity->event_type, 'OS Version'))
                                        <a href="{{ route('settings.software.osversion',app()->getLocale()) }}" class="text-dark" onclick="document.getElementById('notification-form-{{ $notification->id }}').submit(); return false;">
                                    @elseif (Str::contains($notification->activity->event_type, 'Group'))
                                        <a href="{{ route('computer.group',app()->getLocale()) }}" class="text-dark" onclick="document.getElementById('notification-form-{{ $notification->id }}').submit(); return false;">
                                    @elseif (Str::contains($notification->activity->event_type, 'OS Update'))
                                        <a href="{{ route('software-management.osupdate',app()->getLocale()) }}" class="text-dark" onclick="document.getElementById('notification-form-{{ $notification->id }}').submit(); return false;">
                                    @elseif (Str::contains($notification->activity->event_type, 'Software License'))
                                        <a href="{{ route('software-management.licensedsoftware',app()->getLocale()) }}" class="text-dark" onclick="document.getElementById('notification-form-{{ $notification->id }}').submit(); return false;">
                                    @elseif (Str::contains($notification->activity->event_type, 'Software Restriction')
                                            || (Str::contains($notification->activity->event_type, 'Prohibited')))
                                        <a href="{{ route('software-management.prohibitedsoftware',app()->getLocale()) }}" class="text-dark" onclick="document.getElementById('notification-form-{{ $notification->id }}').submit(); return false;">
                                    @elseif (Str::contains($notification->activity->event_type, 'Package'))
                                        <a href="{{ route('software-deployment.deployment',app()->getLocale()) }}" class="text-dark" onclick="document.getElementById('notification-form-{{ $notification->id }}').submit(); return false;">
                                    @endif

                                        <li class="nav-notification__single nav-notification__single--unread d-flex flex-wrap">
                                            <div class="nav-notification__type nav-notification__type--primary">
                                                @if (Str::contains($notification->activity->event_type, 'User'))
                                                    <i class="uil uil-users-alt"></i>
                                                @elseif (Str::contains($notification->activity->event_type, 'Role'))
                                                    <i class="la la-users-cog"></i>
                                                @elseif (Str::contains($notification->activity->event_type, 'Device') || Str::contains($notification->activity->event_type, 'Group'))
                                                    <i class="la la-laptop"></i>
                                                @elseif (Str::contains($notification->activity->event_type, 'Software') || Str::contains($notification->activity->event_type, 'OS') || Str::contains($notification->activity->event_type, 'Package'))
                                                    <i class="la la-icons"></i>
                                                @else
                                                    <i class="fas fa-exclamation-circle"></i>
                                                @endif
                                            </div>
                                            <div class="nav-notification__details ">
                                                <p>
                                                    <span>{{$notification->activity->description }}</span>
                                                </p>
                                                <p>
                                                    <span class="time-posted">{{$notification->created_at->diffForHumans()}}</span>
                                                </p>

                                            </div>
                                            @if ($notification->is_read == 0)
                                            <div class="align-center ms-3">
                                                <span class="badge-dot dot-danger"></span>
                                            </div>
                                            @endif
                                        </li>

                                        </a>
                                    </form>
                                @endforeach
                            @endif
                        </ul>
                        <div class="d-flex">
                            <div class="w-50">
                                <form action="{{ route('social.markAllasRead','en') }}" method="post">
                                @csrf
                                    <button type="submit" class="dropdown-wrapper__more w-100">Mark All as Read</button>
                                </form>
                            </div>
                            <div class="w-50">
                                <form action="{{ route('social.clearNotification','en')}}" method="post">
                                @csrf
                                    <button type="submit" class="dropdown-wrapper__more w-100">Clear Notification</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-author">
                <div class="dropdown-custom">
                    <a href="javascript:;" class="nav-item-toggle"><img src="{{ asset('assets/img/author-nav.jpg') }}" alt="" class="rounded-circle">
                        @if(Auth::check())
                            <span class="nav-item__title">{{ Auth::user()->name }}<i class="las la-angle-down nav-item__arrow"></i></span>
                        @endif
                    </a>
                    <div class="dropdown-wrapper">
                        <div class="nav-author__info">
                            <div class="author-img">
                                <img src="{{ asset('assets/img/author-nav.jpg') }}" alt="" class="rounded-circle">
                            </div>
                            <div>
                                @if(Auth::check())
                                    <h6 class="text-capitalize">{{ Auth::user()->name }}</h6>
                                @endif
                                <span>{{ Auth::user()->role ? Auth::user()->role->name : '-' }}</span>
                            </div>
                        </div>
                        <div class="nav-author__options">
                            <ul>
                                <li>
                                    <a href="{{ route('social.profile_settings',app()->getLocale()) }}">
                                        <img src="{{ asset('assets/img/svg/user.svg') }}" alt="user" class="svg"> Profile</a>
                                </li>
                            </ul>
                            <a href="" class="nav-author__signout" onclick="event.preventDefault();document.getElementById('logout').submit();">
                                <img src="{{ asset('assets/img/svg/log-out.svg') }}" alt="log-out" class="svg">
                                 Sign Out</a>
                                <form style="display:none;" id="logout" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    @method('post')
                                </form>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <div class="navbar-right__mobileAction d-md-none">
            <a href="#" class="btn-author-action">
                <img src="{{ asset('assets/img/svg/more-vertical.svg') }}" alt="more-vertical" class="svg"></a>
        </div>
    </div>
</nav>
