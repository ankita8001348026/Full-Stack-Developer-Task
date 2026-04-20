<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} | @yield('title')</title>
    <link rel="icon" href="{{asset('frontend/assets/image/favicon.png')}}" type="image/gif" sizes="32x32">

    @section('header')
    @include('backend.layouts.header')
    @show
</head>

<body class="hold-transition sidebar-mini layout-fixed" id="main-body">

    {{-- Page Preloader --}}
    <div id="page-preloader">
        <div class="preloader-ring"></div>
    </div>

    <div class="wrapper">

        @include('backend.layouts.sidebar')

        @yield('sections')

        <footer class="main-footer text-center">
            <strong>Copyright &copy; {{ date('Y') }} <a href="{{ url('') }}" target="_blank">{{ env('APP_NAME') }}</a>.</strong>
            All rights reserved.
        </footer>

        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    @include('backend.common.delete_modal')

    @section('footer')
    @include('backend.layouts.footer')
    @show

    @stack('scripts')

    <script>
        // Hide preloader once page is ready
        window.addEventListener('load', function() {
            var preloader = document.getElementById('page-preloader');
            if (preloader) preloader.classList.add('hidden');
        });

        function getDeleteRoute($route) {
            document.getElementById("confirm_del").setAttribute("action", $route);
        }

        function fullScreen() {
            let fullscreen = localStorage.getItem("fullscreen");
            if (fullscreen === null) {
                localStorage.setItem("fullscreen", 'full');
            }
            if (fullscreen == 'full') {
                localStorage.setItem("fullscreen", 'normal');
            }
            if (fullscreen == 'normal') {
                localStorage.setItem("fullscreen", 'full');
            }
        }

        function sidebarCollapse() {
            let sidebar_collapse = localStorage.getItem("sidebar_collapse");
            if (sidebar_collapse === null) {
                localStorage.setItem("sidebar_collapse", 'hide');
            }
            if (sidebar_collapse == 'hide') {
                localStorage.setItem("sidebar_collapse", 'show');
            }
            if (sidebar_collapse == 'show') {
                localStorage.setItem("sidebar_collapse", 'hide');
            }
        }

        $(document).ready(() => {
            let sidebar_collapse = localStorage.getItem("sidebar_collapse");
            let fullscreen = localStorage.getItem("fullscreen");

            if (sidebar_collapse == 'hide') {
                $('#main-body').addClass('sidebar-collapse');
            }
            if (fullscreen == 'full') {
                $('#add-fa-class').removeClass('fa-expand-arrows-alt');
                $('#add-fa-class').addClass('fa-compress-arrows-alt');
            }
        });
    </script>
</body>

</html>