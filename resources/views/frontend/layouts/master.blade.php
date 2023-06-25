<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    @include('frontend.layouts.meta')
</head>

<body>
    <!-- Preloader -->
    <div class="loader-wrapper">
        <div class="sk-cube-grid">
            <div class="sk-cube sk-cube1"></div>
            <div class="sk-cube sk-cube2"></div>
            <div class="sk-cube sk-cube3"></div>
            <div class="sk-cube sk-cube4"></div>
            <div class="sk-cube sk-cube5"></div>
            <div class="sk-cube sk-cube6"></div>
            <div class="sk-cube sk-cube7"></div>
            <div class="sk-cube sk-cube8"></div>
            <div class="sk-cube sk-cube9"></div>
        </div>
    </div>
    <!-- Page Wrapper
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->

    <div class="main-wrapper">
        <!-- Header Section -->
        @include('frontend.layouts.navigation')
        <!-- Header Section -->

        <!-- Main Content Section -->
        <main class="main">
            @yield('content')
        </main>
        <!-- Main Content Section -->
        <!-- Footer -->
        @include('frontend.layouts.footer')
        <!-- Footer Section -->
        <a href="#0" class="cd-top"> Top </a>
    </div>
    <!-- General JS Scripts -->
    @include('frontend.layouts.js')
</body>

</html>
