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
            <h1>Verifica prontuario</h1>
            <small> </small>
            <ol class="breadcrumb hidden-xs">
                <li><a href="{{route('painel')}}"><i class="pe-7s-home"></i> Home</a></li>
                <li class="active">Arquivos Pendentes</li>
            </ol>
            <div class="header-title">

            </div>
        </div>
    </section>
    <!-- Main content -->
    <section>
        <div class="row">
            <form class="col-sm-6" method="POST" action="{{route('buscaProntuario')}}">
                @csrf
                <div class="col-sm-6 form-group">
                    <label>Cps</label>
                    <input type="number" name="cps" class="form-control" placeholder="Digite a cps" required>
                    <button type="submit" class="btn btn-success">Filtrar</button>
                </div>
            </form>
        </div>
    </section> <!-- /.content -->
    @isset($statusProntuarios)
    @foreach($statusProntuarios as $statusProntuario)
        @php
        $quantAssinados = $statusProntuario["quantAssinados"];
        $quantPendentes = $statusProntuario["quantPendentes"];
        $listaArquivosPendentes = $statusProntuario["listaArquivoPendentes"];
        @endphp
    @endforeach
    @endisset
    <section class="content">
        @if(isset($quantAssinados))
            @foreach($quantAssinados as $quantAssinado)
                <h4>Arquivos Assinados: {{$quantAssinado->QUANTASS}}</h4>
            @endforeach
        @endif

        @if(isset($quantPendentes))
            @foreach($quantPendentes as $quantPendente)
                <h4>Arquivos Pendentes: {{$quantPendente->QUANT}}</h4>
            @endforeach
        @endif
        <div class="row">
            <div class="table-responsive">
                <center>
                    <h3>Assinaturas Pendentes</h3>
                </center>
                <table id="tabelaDocumentos"
                       class="table table-striped table-bordered table-hover dataTables-example display">
                    <thead>
                    <tr>
                        <th style="max-width: 20px; min-width: 10px"></th>
                        <th>Profissional</th>
                        <th>Codigo</th>
                        <th>Cps</th>
                        <th>Quantidade de arquivos pendentes por profissional</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($listaArquivosPendentes))
                        @foreach($listaArquivosPendentes as $listaArquivosPendente )
                            <tr>
                                <th></th>
                                <th>{{utf8_encode($listaArquivosPendente->NOME)}}</th>
                                <th>{{$listaArquivosPendente->CODIGO}}</th>
                                <th>{{$listaArquivosPendente->CPS}}</th>
                                <th>{{$listaArquivosPendente->QUANT}}</th>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th>Profissional</th>
                        <th>Codigo</th>
                        <th>Cps</th>
                        <th>Quantidade de arquivos pendentes por profissional</th>
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

@section('footer')
    @include('layout._includes._footer')
@show
