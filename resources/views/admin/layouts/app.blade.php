<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Fonts & Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Core Framework CSS (Bootstrap + SBAdmin2) -->
    <link href="{{ asset('sbadmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700,900" rel="stylesheet">
    <link href="{{ asset('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css/quill.css') }}" rel="stylesheet">

    <!-- 🧩 Custom Modern Overrides (should be LAST) -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body id="page-top">
    <div id="wrapper">

        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Content Wrapper --}}
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                {{-- Topbar --}}
                @include('admin.partials.topbar')

                {{-- Page Content --}}
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            {{-- Footer --}}
            @include('admin.partials.footer')
        </div>

    </div>

    {{-- Scroll to Top Button --}}
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    {{-- Scripts --}}
    <script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sbadmin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('sbadmin2/js/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/quill.min.js') }}"></script>

    @stack('scripts')
</body>

</html>
