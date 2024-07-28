        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('images_setting/1/logo_icone1_20230211.png') }}" alt="Imob"
                height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>


            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        {{ Auth::user()->name }} &nbsp;
                        <i class="fas fa-angle-down right"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="left: inherit; right: 0px;">
                        <span class="dropdown-item dropdown-header">Ações</span>
                        <div class="dropdown-divider"></div>

                        <a class="nav-link" href="#" style="text-align: center;"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-fw fa-power-off text-red"></i>
                            Sair
                        </a>
                    </div>
                </li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="/home" class="brand-link">
                <img src="{{ asset('images_setting/1/logo_icone1_20230211.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Dashboard</span>
            </a>


            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-header">CADASTRO</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class='nav-icon fas fa-user-circle fa-lg'></i>
                                <p>Pessoas
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">
                                <li class="nav-item">
                                    <a href="/locators-list" class="nav-link">
                                        <i class="nav-icon fas fa-user-friends"></i>
                                        <p class="text">Proprietários</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/renters-list" class="nav-link">
                                        <i class="nav-icon fas fa-users fa-lg"></i>
                                        <p class="text">Locatários</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/guarantors-list" class="nav-link">
                                        <i class="nav-icon fas fa-user-shield"></i>
                                        <p class="text">Fiadores</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/suppliers-list" class="nav-link">
                                <i class="nav-icon fas fa fa-university" aria-hidden="true"></i>
                                <p class="text">Fornecedores</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class='nav-icon fas fa-house-user fa-lg'></i>
                                <p>Propriedades
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">
                                <li class="nav-item">
                                    <a href="/properties-list" class="nav-link">
                                        <i class="nav-icon fas fa-home"></i>
                                        <p class="text">Imóveis</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/condos-list" class="nav-link">
                                        <i class="nav-icon fas fa-building"></i>
                                        <p class="text">Condomínios</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="/cities-list" class="nav-link">
                                <i class="nav-icon fas fa-city fa-lg"></i>
                                <p class="text">Cidades</p>
                            </a>
                        </li>

                        <li class="nav-header">ADMINISTRATIVO</li>
                        @if (Auth::user()->type == 1)
                            <li class="nav-item">
                                <a href="/setting-list" class="nav-link">
                                    <i class="nav-icon fas fa-cog fa-lg"></i>
                                    <p class="text">Configurações</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/users-list" class="nav-link">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p class="text">Usuários</p>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ url('user/' . Auth::user()->id . '/edit_user') }}" class="nav-link">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p class="text">Meu Usuário</p>
                                </a>
                            </li>
                        @endif

                        {{-- <li class="nav-item">
                            <a href="/reports-list" class="nav-link">
                                <i class="nav-icon fas fa-sticky-note"></i>
                                <p class="text">Relatórios</p>
                            </a>
                        </li> --}}


                        @if (Auth::user()->type == 1)
                            <li class="nav-header">FINANCEIRO</li>
                            <li class="nav-item">
                                <a href="/transactions-list" class="nav-link">
                                    <i class="nav-icon fas fa-handshake"></i>
                                    <p class="text">Contratos</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/accounts-pay-list" class="nav-link">
                                    <i class="nav-icon fas fa-money-bill-alt"></i>
                                    <p class="text">Contas à Pagar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/accounts-receive-list" class="nav-link">
                                    <i class="nav-icon far fa-money-bill-alt"></i>
                                    <p class="text">Contas à Receber</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/installments-list" class="nav-link">
                                    <i class="nav-icon fas fa-hand-holding-usd"></i>
                                    <p class="text">Parcelas de Imóveis</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/transfers-list" class="nav-link">
                                    <i class="nav-icon fas fa-comment-dollar"></i>
                                    <p class="text">Repasses</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/bank-accounts-list" class="nav-link">
                                    <i class="nav-icon fas fa-piggy-bank"></i>
                                    <p class="text">Contas Bancárias</p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="/checks-list" class="nav-link">
                                    <i class="nav-icon fas fa-money-check"></i>
                                    <p class="text">Cheques</p>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="/cashflow-list" class="nav-link">
                                    <i class="nav-icon fas fa-coins"></i>
                                    <p class="text">Caixa</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>

        </aside>
