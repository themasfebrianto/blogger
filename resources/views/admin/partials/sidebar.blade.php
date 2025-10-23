<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-pen-nib"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin Blog</div>
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

    <!-- Posts -->
    <li class="nav-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.posts.index') }}">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Posts</span>
        </a>
    </li>

    <!-- Categories -->
    <li class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.categories.index') }}">
            <i class="fas fa-fw fa-folder-open"></i>
            <span>Categories</span>
        </a>
    </li>

    <!-- Tags -->
    <li class="nav-item {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.tags.index') }}">
            <i class="fas fa-fw fa-tags"></i>
            <span>Tags</span>
        </a>
    </li>

    <!-- Comments -->
    <li class="nav-item {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.comments.index') }}">
            <i class="fas fa-fw fa-comments"></i>
            <span>Comments</span>
        </a>
    </li>

    {{-- <!-- Users -->
    <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
    </li> --}}

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
<!-- End of Sidebar -->
