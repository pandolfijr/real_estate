@include('site.components.header')
{{-- @include('site.components.search') --}}


<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        {{-- @include('dashboard.components.menu') --}}

        <div class="content-wrapper">
            <div id="app">
                @yield('content')
                <router-view></router-view>
            </div>

        </div>
    </div>
    @vite('resources/js/app.js')
</body>

@include('site.components.footer')

</html>
