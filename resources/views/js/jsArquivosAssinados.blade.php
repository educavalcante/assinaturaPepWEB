<script>

    function cachePagina(pagina) {
        var paginaCache = pagina
        var find_pg = '';
        $('.paginate_button a').each(function (i, obj) {
            find_pg = $(this).text();
            if (paginaCache === find_pg) {
                $(this).trigger('click');
            }
        });
    }

    function msgSucesso(msg) {
        iziToast.success({
            title: 'Sucesso !!! ',
            message: msg,
            closeOnClick: true,
            backgroundColor: 'rgba(19, 133, 70, 0.9)',
            progressBarColor: '#FFF',
            overlay: true,
            overlayClose: true,
            position: 'center',
            timeout: 600
        });
    }

    function msgWarning(msg) {
        iziToast.warning({
            title: 'ATENÇÃO: ',
            message: msg,
            closeOnClick: true,
            color: '#FFF',
            backgroundColor: '#FFC107',
            progressBarColor: '#FFF',
            overlay: true,
            overlayClose: true,
            position: 'center',
            timeout: 8000
        });
    }

    function msgErro(msg) {
        iziToast.error({
            title: 'Error',
            message: msg,
        });
    }

    function format(d) {
        // `d` is the original data object for the row
        console.log(d);
        return '<fieldset>' +
            '<legend>Arquivo: ' + d.documentos + '</legend>' +
            '<table cellpadding="50" cellspacing="0" border="0" style="padding-left:50px;">' +
            '<tr>' +
            '<td><strong>Criado:</strong> ' + d.criado + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td><strong>Tipo:</strong> ' + d.tipo + '</td>' +
            '</tr>' +
            '<td><strong>Extensão:</strong> ' + d.extensao + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td><strong>Responsável: </strong> ' + d['--'] + '</td>' +
            '</tr>' +
            '<tr>' +
            // '<td><strong>Ações: </strong> ' +
            // "<a style='margin-right:5px;' target='_blank' href='{{ url('slide') }}/"+ d.dicom +
            // "' title='IMAGENS DO PACIENTE' class='btn btn-primary btn-xs'><i class='fa fa-image'></i> VER IMAGENS</a>" +
            // "<a style='margin-right:5px;' target='_blank' href='{{ url('dicom') }}/" + d.dicom +
            // "' title='Imagens DICOM' class='btn btn-primary btn-xs'><i class='fa fa-image'></i> DICOM</a>" +
            // "<a style='margin-right:5px' href='#" +
            // "' target=slide title='HISTORICO do Paciente' class='btn btn-primary btn-xs'><i class='fa fa-image'></i> HISTORICO</a>" +
            // "<a href='#" +
            // "' target=slide title='LAUDO DO Paciente' class='btn btn-primary btn-xs'><i class='fa fa-image'></i> LAUDO</a>" +
            // "<a style='margin-left:5px;' target='_blank' href='{{ url('downloadZip') }}/" + d.zip +
            // "' title='Imagens Zip' class='btn btn-primary btn-xs'><i class='fa fa-image'></i> Imagens Zip</a>" +
            // '</td>' +


            '</tr>' +
            '<tr>' +
            '</tr>' +
            '</table>' +
            '</fieldset>';

    }

    $(document).ready(function () {

        var pagina = $('.paginate_button.active a').text()
        $('#tabelaDocumentos').DataTable({
            lengthMenu: [
                [20, 60, 80, 100, -1],
                [20, 60, 80, 100, "total"]
            ],
            pageLength: 20,
            responsive: true,
            "processing": true,
            "serverSide": true,
            "serverMethod": 'post',
            "ajax": {
                "url": "{{ route('arquivosAssinados') }}"
            },

            "columns": [{
                "class": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
                {
                    "data": "documentos"
                },
                {
                    "data": "cps"
                },
                {
                    "data": "paciente"
                },
                {
                    "data": "visualizar"
                },
                {
                    "data": "criado"
                },
                {
                    "data": "status"
                },
                {
                    "data": "dataAssinatura"
                },
            ],
            "oLanguage": {
                "sLengthMenu": "Mostrar _MENU_ registros por página",
                "sZeroRecords": "Nenhum registro encontrado",
                "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
                "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros)",
                "sSearch": "Pesquisar: ",
                "sProcessing": "Carregando... Aguarde ! :)",
                "oPaginate": {
                    "sFirst": "Início",
                    "sPrevious": "Anterior",
                    "sNext": "Próximo",
                    "sLast": "Último"
                }
            },

        });

        alert = function () {
        };

        var table = $('#tabelaDocumentos').DataTable();

        $('#tabelaDocumentos tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);


            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });

        $('#tabelaDocumentos_filter label input').on('focus', function () {
            this.setAttribute('id', 'inputSearch');
            $("#inputSearch").focus();
        });
        $("#inputSearch").focus();
    });

</script>
