<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>CPC - Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--===============================================================================================-->

    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/animate/animate.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/css-hamburgers/hamburgers.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{('vendor/select2/select2.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{('css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{('css/main.css')}}">

    <link href="{{asset('assets/plugins/jquery-ui-1.12.1/jquery-ui.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/plugins/lobipanel/lobipanel.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/plugins/pace/flash.css" rel="stylesheet')}}" type="text/css"/>
    <link href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/themify-icons/themify-icons.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/plugins/toastr/toastr.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/plugins/emojionearea/emojionearea.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/plugins/monthly/monthly.css" rel="stylesheet')}}" type="text/css"/>
    <link href="{{asset('assets/dist/css/stylehealth.min.css" rel="stylesheet')}}" type="text/css"/>
    <link rel="shortcut icon" href="{{asset('assets/dist/img/favicon.png')}}"
          type="image/x-icon">
    <link rel="stylesheet" href="{{asset('reset.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>

<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-pic js-tilt" data-tilt>
                <img id="logo" src="{{asset('assets/dist/img/assinatura.png')}}">
            </div>

            <form class="login100-form validate-form" action="{{route('logar')}}" method="POST">

                {{ csrf_field() }}
                <span class="login100-form-title">
						Assinatura CPC
						<p>Assine documentos pdf utilizando o certificado digital :)</p>
					</span>

                <div class="wrap-input100 validate-input">
                    <input class="input100" type="text" id="usuario" name="usuario" placeholder="Digite seu código" required>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Password is required">
                    <input class="input100" type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                </div>

                <div class="container-login100-form-btn">
                    <button type="submit" class="login100-form-btn">
                        Acessar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<center>

    <footer class="footerIndex">
        <div id="version" class="pull-right hidden-xs"><b>Version </b>{{env('VERSION')}}
        </div>
        <strong>Copyright &copy; 2000-<?= date('Y') ?> <a href="http://www.cpcbrasil.com/" target="_brink">Cpc Brasil
                Sistemas</a>.</strong> todos direitos reservados.
    </footer>
</center>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!--===============================================================================================-->
<script src="{{asset('vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('vendor/bootstrap/js/popper.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('vendor/tilt/tilt.jquery.min.js')}}"></script>

<script src="{{asset('assets/plugins/jQuery/jquery-1.12.4.min.js')}}" type="text/javascript"></script>
<!-- jquery-ui -->
<script src="{{asset('assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js')}}" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<!-- lobipanel -->
<script src="{{asset('assets/plugins/lobipanel/lobipanel.min.js')}}" type="text/javascript"></script>
<!-- Pace js -->
<script src="{{asset('assets/plugins/pace/pace.min.js')}}" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="{{asset('assets/plugins/slimScroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<!-- FastClick -->
<script src="{{asset('assets/plugins/fastclick/fastclick.min.js')}}" type="text/javascript"></script>
<!-- Hadmin frame -->
<script src="{{asset('assets/dist/js/custom1.js')}}" type="text/javascript"></script>
<!-- End Core Plugins
    =====================================================================-->
<!-- Start Page Lavel Plugins
    =====================================================================-->
<!-- Toastr js -->
<script src="{{asset('assets/plugins/toastr/toastr.min.js')}}" type="text/javascript"></script>
<!-- Sparkline js -->
<script src="{{asset('assets/plugins/sparkline/sparkline.min.js')}}" type="text/javascript"></script>
<!-- Data maps js -->
<script src="{{asset('assets/plugins/datamaps/d3.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/datamaps/topojson.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/datamaps/datamaps.all.min.js')}}" type="text/javascript"></script>
<!-- Counter js -->
<script src="{{asset('assets/plugins/counterup/waypoints.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
<!-- ChartJs JavaScript -->
<script src="{{asset('assets/plugins/chartJs/Chart.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/emojionearea/emojionearea.min.js')}}" type="text/javascript"></script>
<!-- Monthly js -->
<script src="asset{{('assets/plugins/monthly/monthly.js')}}" type="text/javascript"></script>
<!-- Data maps -->
<script src="{{asset('assets/plugins/datamaps/d3.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/datamaps/topojson.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/datamaps/datamaps.all.min.js')}}" type="text/javascript"></script>

<!-- End Page Lavel Plugins
    =====================================================================-->
<!-- Start Theme label Script
    =====================================================================-->
<!-- Dashboard js -->
<script src="{{asset('assets/dist/js/custom.js')}}" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        $('#toTop').hide()
    })
</script>
<!--===============================================================================================-->
<script src="js/main.js"></script>

<script>
    $('#usuario').on({
        click: function () {
            console.log('Fui clicado!')
        },
        blur: function () {
            document.getElementById('nomeUsuario').value = $("#usuario").val()

            // 	$.ajax({
            // 		url: 'http://localhost:8000/user',
            // 		type: 'POST',
            // 		success: function(data) {
            // 		}
            // 	});

        }
    })

    $('#nomeUsuario').on({
        click: function () {
            console.log('Fui clicado!')
        },
        blur: function () {
            document.getElementById('usuario').value = $("#nomeUsuario").val()
            // alert($('#usuario').val())

            // $.ajax({
            // 	url: 'http://localhost:8000/user',
            // 	type: 'POST',
            // 	success: function(data) {
            // 	}
            // });

        }
    })
</script>

</body>

</html>
