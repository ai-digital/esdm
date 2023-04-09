<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    @include('backend.includes.others.meta-title')
    @include('backend.includes.others.css')




</head>

<body>
    <div id="app">

        <!-- Header -->
        @include('backend.includes.others.header')
        <div class="main-wrapper">
            <!-- Sidebar -->
            @include('backend.includes.others.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    @yield('content')
                </section>
            </div>

            <!-- Footer -->
            @include('backend.includes.others.footer')
        </div>
    </div>

    <!-- General JS Scripts -->
    @include('backend.includes.others.js')
</body>

</html>
