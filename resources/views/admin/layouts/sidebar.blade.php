<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-pen-nib"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'Themas.Log') }}</div>
    </a>


    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Content Menu -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.posts.*', 'admin.categories.*', 'admin.tags.*', 'admin.comments.*') ? '' : 'collapsed' }}"
            href="#" data-toggle="collapse" data-target="#collapseContent"
            aria-expanded="{{ request()->routeIs('admin.posts.*', 'admin.categories.*', 'admin.tags.*', 'admin.comments.*') ? 'true' : 'false' }}"
            aria-controls="collapseContent">
            <i class="fas fa-fw fa-folder"></i>
            <span>Content</span>
        </a>
        <div id="collapseContent"
            class="collapse {{ request()->routeIs('admin.posts.*', 'admin.categories.*', 'admin.tags.*', 'admin.comments.*') ? 'show' : '' }}"
            aria-labelledby="headingContent">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}"
                    href="{{ route('admin.posts.index') }}">
                    <i class="fas fa-fw fa-newspaper"></i> Posts
                </a>
                <a class="collapse-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                    href="{{ route('admin.categories.index') }}">
                    <i class="fas fa-fw fa-folder-open"></i> Categories
                </a>
                <a class="collapse-item {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}"
                    href="{{ route('admin.tags.index') }}">
                    <i class="fas fa-fw fa-tags"></i> Tags
                </a>
                <a class="collapse-item {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}"
                    href="{{ route('admin.comments.index') }}">
                    <i class="fas fa-fw fa-comments"></i> Comments
                </a>
            </div>
        </div>
    </li>

    <!-- Yaumi Menu -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.yaumi-activities.*', 'admin.yaumi-logs.*', 'admin.yaumi-streaks.*') ? '' : 'collapsed' }}"
            href="#" data-toggle="collapse" data-target="#collapseYaumi"
            aria-expanded="{{ request()->routeIs('admin.yaumi-activities.*', 'admin.yaumi-logs.*', 'admin.yaumi-streaks.*') ? 'true' : 'false' }}"
            aria-controls="collapseYaumi">
            <i class="fas fa-fw fa-running"></i>
            <span>Yaumi</span>
        </a>
        <div id="collapseYaumi"
            class="collapse {{ request()->routeIs('admin.yaumi-activities.*', 'admin.yaumi-logs.*', 'admin.yaumi-streaks.*') ? 'show' : '' }}"
            aria-labelledby="headingYaumi">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('admin.yaumi-activities.*') ? 'active' : '' }}"
                    href="{{ route('admin.yaumi-activities.index') }}">
                    <i class="fas fa-fw fa-running"></i> Activities
                </a>
                <a class="collapse-item {{ request()->routeIs('admin.yaumi-logs.*') ? 'active' : '' }}"
                    href="{{ route('admin.yaumi-logs.index') }}">
                    <i class="fas fa-fw fa-book"></i> Logs
                </a>
                <a class="collapse-item {{ request()->routeIs('admin.yaumi-streaks.*') ? 'active' : '' }}"
                    href="{{ route('admin.yaumi-streaks.index') }}">
                    <i class="fas fa-fw fa-fire"></i> Streaks
                </a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">


    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
