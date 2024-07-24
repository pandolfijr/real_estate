@include('dashboard.components.header-login')

<body id="top">
    <div class="page_loader"></div>
    <div class="login-6">
        <div id="particles-js"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="form-section">
                        <div class="logo">
                            <a href="#">
                                <img src="{{ asset('images_setting/1/logo_icone1_20230211.png') }}"
                                    alt="logo">
                            </a>
                        </div>
                        <div class="typing">
                            <h1>Faça login em sua conta</h1>
                        </div>
                        <div class="login-inner-form">
                            <form action="{{ route('login-admin') }}" method="post">
                                @csrf
                                <div class="form-group clearfix">
                                    <div class="form-box{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <input name="email" type="email" class="form-control" id="email"
                                            placeholder="Digite seu e-mail" aria-label="Digite seu e-mail" value="{{ old('email') }}" autofocus>
                                        <i class="flaticon-mail-2"></i>
                                        @if ($errors->has('email'))
                                        <span class="help-block" style="color:#e81e63">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="form-box">
                                        <input name="password" type="password" class="form-control" autocomplete="off"
                                            id="password" placeholder="Digite sua senha" aria-label="Digite sua senha">
                                        <i class="flaticon-password"></i>
                                        @if ($errors->has('password'))
                                        <span class="help-block" style="color:#e81e63">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>
                                <div class="checkbox form-group clearfix">
                                    <div class="form-check float-start">
                                        <input class="form-check-input" type="checkbox" id="rememberme">
                                        <label class="form-check-label" for="rememberme">
                                            Lembrar-me
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <button type="submit" class="btn btn-primary btn-lg btn-theme">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

@include('dashboard.components.footer-login')

</html>
