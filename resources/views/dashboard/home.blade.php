@include('dashboard.components.header')


<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        @include('dashboard.components.menu')

        <div class="content-wrapper">
            <div id="app">
                @yield('content')
                <router-view></router-view>
            </div>

        </div>
    </div>
    @vite('resources/js/app.js')
</body>

@include('dashboard.components.footer')

</html>
