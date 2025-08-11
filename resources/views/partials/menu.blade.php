<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">
    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full" href="#" style="text-align: center;color: white;font-weight: bold;">
            {{ config('app.name') }}
        </a>
    </div>
    <ul class="c-sidebar-nav">
        @if(Auth::user()->id)
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                    <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt"> </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
        @endif()

        @can('user_management_access')
                @if(Auth::user()->id)
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon"> </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                @endif()
            @if(Auth::user()->id)
                @can('role_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon"> </i>
                            {{ trans('cruds.role.title') }}
                        </a>
                    </li>
                @endcan
            @endif()
            @can('user_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                        <i class="fa-fw fas fa-user c-sidebar-nav-icon"> </i>
                        {{ trans('cruds.user.title') }}
                    </a>
                </li>
            @endcan
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.uploads.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/uploads") || request()->is("admin/uploads/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-ambulance c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.upload.title') }}
                </a>
            </li>
        @endcan
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.oldfiles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/oldfiles") || request()->is("admin/oldfiles/*") ? "c-active" : "" }}">
                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.oldfiles.title') }}
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt"> </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>
</div>