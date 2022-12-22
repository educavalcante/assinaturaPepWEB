@section('header')
    @include('layout._includes._header')
@show

@section('navbar')
    @include('layout._includes._navbar')
@show
<style>
    td.details-control {
        background: url('{{ asset('assets/dist/img/details_open.png') }}') no-repeat center center !important;
        cursor: pointer !important;
    }

    .ocutar {
        display: none !important;
    }

    tr.shown td.details-control {
        background: url('{{ asset('assets/dist/img/details_close.png') }}') no-repeat center center !important;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="fa fa-file-pdf-o"></i>
        </div>
        <div class="header-title">
            <h1>Arquivos Pendentes</h1>
            <small> </small>
            <ol class="breadcrumb hidden-xs">
                <li><a href="{{route('painel')}}"><i class="pe-7s-home"></i> Home</a></li>
                <li class="active">Arquivos Pendentes</li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="table-responsive">
                <table id="tabelaDocumentos"
                       class="table table-striped table-bordered table-hover dataTables-example display">
                    <thead>
                    <tr>
                        <th style="max-width: 20px; min-width: 10px"></th>
                        <th>Documento</th>
                        <th>Cps</th>
                        <th>Paciente</th>
                        <th>Visualizar</th>
                        <th>Importado</th>
                        <th>Status</th>
                        <th>Data Assinatura Digital</th>
                        <th>Assinar</th>
                        <th>Retirar Documento</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th>Documento</th>
                        <th>Cps</th>
                        <th>Paciente</th>
                        <th>Visualizar</th>
                        <th>Importado</th>
                        <th>Status</th>
                        <th>Data Assinatura Digital</th>
                        <th>Assinar</th>
                        <th>Retirar Documento</th>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <div class="row">
            </div>
        </div>
    </section> <!-- /.content -->

</div> <!-- /.content-wrapper -->
<!-- ./wrapper -->

<!-- Button trigger modal -->


<!-- Modal -->
@section('modalBird')
    @include('layout.modal.modalBird')
@show

@section('modalRetiraDocumentos')
    @include('layout.modal.retiraDocumentos')
@show

@section('meusArquivos')
    @include('js.jsMeusArquivos')
@show

@section('footer')
    @include('layout._includes._footer')
@show
