<!DOCTYPE html>
<html lang="en">

<head>
    @include('backend.includes.others.meta-ttitle')
    @include('backend.includes.others.css')




</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <!-- Header -->
            @include('backend.components.header')

            <!-- Sidebar -->
            @include('backend.components.sidebar')

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
