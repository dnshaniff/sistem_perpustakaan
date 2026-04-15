<!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="utf-8">
        <title>@yield('title', 'Perpustakaan')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

        <!-- AdminLTE -->
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            @include('components.navbar')
            @include('components.sidebar')

            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid">
                        <h1>@yield('page_title', 'Dashboard')</h1>
                    </div>
                </section>
                <section class="content">
                    <div class="container-fluid">
                        @include('components.alert')
                        @yield('content')
                    </div>
                </section>
            </div>

            @include('components.footer')
        </div>

        <!-- Scripts -->
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
</script>
    </body>

</html>
