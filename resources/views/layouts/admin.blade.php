<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Arusuvai</title>

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/font-awesome/css/font-awesome.min.css') }}">

    <!-- Page Plugin CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/jquery-bar-rating/css-stars.css') }}">

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">

    <link rel="shortcut icon" href="{{ asset('admin/assets/images/logo/logo.jpeg') }}" />
</head>

<body>
<div class="container-scroller">

    {{-- SIDEBAR --}}
    @include('includes.sidebar')

    <div class="container-fluid page-body-wrapper">

        {{-- HEADER / NAVBAR --}}
        @include('includes.header')

        {{-- MAIN PANEL --}}
        <div class="main-panel">
            <div class="content-wrapper pb-0">

                {{-- PAGE CONTENT --}}
                @yield('content')

            </div>

            {{-- FOOTER --}}
            @include('includes.footer')
        </div>
        {{-- END MAIN PANEL --}}

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
        @endif

        @if(session('error'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 3000
        });
        @endif

        @if($errors->any())
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: "{{ $errors->first() }}",
            showConfirmButton: false,
            timer: 4000
        });
        @endif

    });
</script>

<!-- Plugins JS -->
<script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>

<!-- Page Plugins -->
<script src="{{ asset('admin/assets/vendors/jquery-bar-rating/jquery.barrating.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendors/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('admin/assets/vendors/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('admin/assets/vendors/flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('admin/assets/vendors/flot/jquery.flot.categories.js') }}"></script>
<script src="{{ asset('admin/assets/vendors/flot/jquery.flot.fillbetween.js') }}"></script>
<script src="{{ asset('admin/assets/vendors/flot/jquery.flot.stack.js') }}"></script>
<script src="{{ asset('admin/assets/js/jquery.cookie.js') }}"></script>

<!-- Core JS -->
<script src="{{ asset('admin/assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('admin/assets/js/misc.js') }}"></script>
<script src="{{ asset('admin/assets/js/settings.js') }}"></script>
<script src="{{ asset('admin/assets/js/todolist.js') }}"></script>
<script src="{{ asset('admin/assets/js/hoverable-collapse.js') }}"></script>

<!-- Custom JS -->
<script src="{{ asset('admin/assets/js/proBanner.js') }}"></script>
<script src="{{ asset('admin/assets/js/dashboard.js') }}"></script>

@stack('scripts')
</body>
</html>
