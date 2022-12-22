@section('header')
@include('layout._includes._header')
@show

@section('navbar')
@include('layout._includes._navbar')
@show
<div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="header-icon">
                    <i class="fa fa-tachometer"></i>
                </div>
                <div class="header-title">
                    <h1> Painel Principal</h1>
                    <small>Painel</small>
                    <ol class="breadcrumb hidden-xs">
                        <li class="active"><a href="#"><i class="pe-7s-home"></i> Painel Principal</a></li>
                    </ol>
                </div>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <a href="{{route('documentosPendentes')}}">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                        <div class="panel panel-bd cardbox">
                            <div class="panel-body">
                                <div class="items pull-left">
                                    <i class="fa fa-file-o fa-2x"></i>
                                    <h5> Documentos Pendentes</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>

                    <a href="{{route('documentosAssinados')}}">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                            <div class="panel panel-bd cardbox">
                                <div class="panel-body">
                                    <div class="items pull-left">
                                        <i class="fa fa-file-text-o fa-2x"></i>
                                        <h5> Documentos Assinados</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                        <div class="panel panel-bd cardbox">
                            <div class="panel-body">
                                <div class="statistic-box">
                                    <h2><span class="count-number">4</span>
                                    </h2>
                                </div>
                                <div class="items pull-left">
                                    <i class="fa fa-line-chart fa-2x"></i>
                                    <h5>Total de Indicadores em andamento</h5>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="row">
                </div> <!-- /.row -->
            </section> <!-- /.content -->

        </div> <!-- /.content-wrapper -->
   @section('footer')
@include('layout._includes._footer')
@show
