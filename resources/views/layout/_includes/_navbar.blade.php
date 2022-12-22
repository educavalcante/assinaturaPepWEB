<header class="main-header">
    <a href="#" class="logo">

        <span class="logo-mini">
            <img id="imgLogoBar" src="{{asset('assets/dist/img/logoCpc.png')}}"/>
        </span>

        <span>
            <img id="logoCpc" src="{{asset('assets/dist/img/logoCpc.png')}}">
        </span>
    </a>

    <nav class="navbar navbar-static-top ">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="fa fa-tasks"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="pe-7s-bell"></i>
                        <span class="label label-warning">0</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"><i class="fa fa-bell"></i> 0 Notifications</li>
                        <li>
                            <ul class="menu">
                                <li>
                                    <a href="#" class="border-gray"><i class="fa fa-inbox"></i> Sem notificações<span
                                            class=" label-success label label-default pull-right">0</span></a>
                                </li>
                            </ul>
                    </ul>
                </li>

                <li class="dropdown dropdown-user admin-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <div class="user-image">
                            <img src="{{asset('assets/dist/img/iconeUsuario.png')}}" class="img-circle" height="40"
                                 width="40" alt="User Image">
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="fa fa-gear"></i> Ajustes</a></li>
                        <li><a href="{{route('logout')}}"><i class="fa fa-sign-out"></i> Sair</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<aside class="main-sidebar">
    <!-- sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">

            <div class="image pull-left">
                <img src="{{asset('assets/dist/img/iconeUsuario.png')}}" id="imgPacienteMenu" alt="User Image">
            </div>


            <div class="info">

                <h4 class="infoPacienteMenu">Usuario logado: {{ utf8_encode(Auth::user()->nome) }}</h4>
                <h4 class="infoPacienteMenu">Setor: {{ utf8_encode(Auth::user()->depto) }}</h4>

            </div>


        </div>

        <ul class="sidebar-menu">

            <li class="treeview">
                <a href="#">
                    <i class="ti-file"></i><span>Meus Arquivos</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('documentosPendentes')}}">Arquivos Pendentes</a></li>
                    <li><a href="{{route('documentosAssinados')}}">Arquivos Assinados</a></li>
                </ul>
            </li>

            @if(Auth::user()->id == 1 || Auth::user()->id == 2
            || Auth::user()->id == 223 ||  Auth::user()->id == 308)
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-paste pull-left"></i><span>Prontuário</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('verificar')}}">Consultar Situação</a></li>
                    <li><a href="{{route('baixar_prontuario')}}">Baixar Prontuário</a></li>
                </ul>
            </li>
            @endif

            {{-- <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i><span>Atendimento</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#">Prontuário</a></li>
                    <li><a href="#">Receituário Eletrônico</a></li>
                    <li><a href="#">Atestado Médico</a></li>
                    <li><a href="#">Solicitar exames</a></li>
                    <li><a href="#">Meus Pacientes</a></li>
                </ul>
            </li> --}}

            {{-- <li class="treeview">
                <a href="#">
                    <i class="fa fa-columns"></i><span>Ajustes Visuais</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#">Layout Fixo</a></li>
                    <li><a href="#">Tela Cheia</a></li>
                    <li><a href="#">collapsed layout</a></li>
                </ul>
            </li> --}}

        </ul>
    </div>
</aside>
