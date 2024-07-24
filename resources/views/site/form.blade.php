@include('site.components.header')

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        <i class="bi bi-list mobile-nav-toggle d-none" style="color: white; margin-top: 0.5em;"></i>
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

<style>
    .button-search {
        margin-right: 3em;
        margin-top: -2.6em;
        background: var(--color-primary);
    }
</style>
