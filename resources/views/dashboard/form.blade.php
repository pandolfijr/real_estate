@include('dashboard.components.header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('dashboard.components.menu')
        <div class="content-wrapper">
            <div style="padding-top: 0.5em;"></div>
            <div id="app">
                @yield('content')
                <router-view></router-view>
            </div>
        </div>
        @vite('resources/js/app.js')
    </div>
</body>
@include('dashboard.components.footer')
</html>
