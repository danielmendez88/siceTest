@extends('theme.sivyc.layout')
<!--generado por Daniel Méndez-->
@section('title', 'Solicitud de Inscripción | Sivyc Icatech')
<!--ÁREA EXTRA DONDE SE AGREGA CSS-->
@section('content_script_css')
    <style>
        .constancia_reclusion_tag{
            display: none;
        }
    </style>
@endsection
<!--ÁREA EXTRA DONDE SE AGREGA CSS ENDS-->
<!--contenido-->
@section('content')
    <div class="container g-pt-50">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div> <br>
        @endif
        <div class="row">
            <div class="col-lg-8 margin-tb">
                <div>
                    <h3><b>Solicitud de Inscripción (SID) - CERSS</b></h3>
                </div>
            </div>
            <div class="col-lg-4 margin-tb">
                <div class="pull-right">
                    <a class="btn btn-warning btn-circle m-1 btn-circle-sm" href="#" data-toggle="modal" data-placement="top" title="INFORMACIÓN ACERCA DEL SID" data-target="#fullHeight">
                        <i class="fa fa-info" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        <hr style="border-color:dimgray">
        <div style="text-align: center;">
            <h4><b>DATOS GENERALES CERSS</b></h4>
        </div>
        <form method="POST" id="form_sid_cerss" action="{{ route('preinscripcion.cerss.save') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <!--NOMBRE CERSS-->
                <div class="form-group col-md-4">
                    <label for="nombre_cerss " class="control-label">NOMBRE DEL CERSS</label>
                    <input type="text" class="form-control" id="nombre_cerss" name="nombre_cerss" autocomplete="off">
                </div>
                <!--NOMBRE CERSS END-->
                <div class="form-group col-md-8">
                    <label for="direcciones_cerss " class="control-label">DIRECCIÓN DEL CERSS</label>
                    <input type="text" class="form-control" id="direcciones_cerss " name="direcciones_cerss " autocomplete="off"/>
                </div>
            </div>
            <div class="form-row">
                <!--TITULAR DEL CERSS-->
                <div class="form-group col-md-8">
                    <label for="titular_cerss " class="control-label">TITULAR DEL CERSS</label>
                    <input type="text" class="form-control" id="titular_cerss " name="titular_cerss " autocomplete="off"/>
                </div>
                <!--TITULAR DEL CERSS END-->
            </div>

            <!--PERSONALES-->
            <hr style="border-color:dimgray">
            <div style="text-align: center;">
                <h4><b>DATOS PERSONALES CERSS</b></h4>
            </div>
            <!--PERSONALES END-->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="numero_expediente_cerss" class="control-label">NÚMERO DE EXPEDIENTE</label>
                    <input type="text" class="form-control" id="numero_expediente_cerss" name="numero_expediente_cerss" autocomplete="off"/>
                </div>
            </div>
            <div class="form-row">
                <!--nombre aspirante-->
                <div class="form-group col-md-4">
                    <label for="nombre_aspirante_cerss " class="control-label">NOMBRE</label>
                    <input type="text" class="form-control" id="nombre_aspirante_cerss" name="nombre_aspirante_cerss" autocomplete="off">
                </div>
                <!--nombre aspirante END-->
                <!-- apellido paterno -->
                <div class="form-group col-md-4">
                    <label for="apellidoPaterno_aspirante_cerss" class="control-label">APELLIDO PATERNO</label>
                    <input type="text" class="form-control" id="apellidoPaterno_aspirante_cerss" name="apellidoPaterno_aspirante_cerss" autocomplete="off">
                </div>
                <!-- apellido paterno END -->
                <!-- apellido materno-->
                <div class="form-group col-md-4">
                    <label for="apellidoMaterno_aspirante_cerss" class="control-label">APELLIDO MATERNO</label>
                    <input type="text" class="form-control" id="apellidoMaterno_aspirante_cerss" name="apellidoMaterno_aspirante_cerss" autocomplete="off">
                </div>
                <!-- apellido materno END-->
            </div>
            <div class="form-row">
                <b><label for="fechanacimiento" class="control-label">FECHA DE NACIMIENTO</label></b>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="dia_cerss" class="control-label">DÍA</label>
                    <select class="form-control" id="dia_cerss" name="dia_cerss">
                        <option value="">--SELECCIONAR--</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="mes_cerss" class="control-label">MES</label>
                    <select class="form-control" id="mes_cerss" name="mes_cerss">
                        <option value="">--SELECCIONAR--</option>
                        <option value="01">ENERO</option>
                        <option value="02">FEBRERO</option>
                        <option value="03">MARZO</option>
                        <option value="04">ABRIL</option>
                        <option value="05">MAYO</option>
                        <option value="06">JUNIO</option>
                        <option value="07">JULIO</option>
                        <option value="08">AGOSTO</option>
                        <option value="09">SEPTIEMBRE</option>
                        <option value="10">OCTUBRE</option>
                        <option value="11">NOVIEMBRE</option>
                        <option value="12">DICIEMBRE</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="anio_cerss" class="control-label">AÑO</label>
                    <input type="text" class="form-control" id="anio_cerss" name="anio_cerss" placeholder="INGRESA EL AÑO EJ. 1943" autocomplete="off">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nacionalidad_cerss" class="control-label">NACIONALIDAD</label>
                    <input type="text" class="form-control" id="nacionalidad_cerss" name="nacionalidad_cerss" placeholder="NACIONALIDAD" autocomplete="off">
                </div>
                <div class="form-group col-md-6">
                    <label for="genero_cerss" class="control-label">GENERO</label>
                    <select class="form-control" id="genero_cerss" name="genero_cerss">
                        <option value="">--SELECCIONAR--</option>
                        <option value="FEMENINO">MUJER</option>
                        <option value="MASCULINO">HOMBRE</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="curp_cerss" class="control-label">CURP ASPIRANTE</label>
                    <input type="text" class="form-control" id="curp_cerss" name="curp_cerss" placeholder="CURP" autocomplete="off">
                </div>
                <div class="form-group col-md-6">
                    <label for="rfc_cerss" class="control-label">RFC ASPIRANTE</label>
                    <input type="text" class="form-control" id="rfc_cerss" name="rfc_cerss" placeholder="RFC" autocomplete="off">
                </div>
            </div>
            <!---->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="ultimo_grado_estudios_cerss" class="control-label">ÚLTIMO GRADO DE ESTUDIOS</label>
                    <select class="form-control" id="ultimo_grado_estudios_cerss" name="ultimo_grado_estudios_cerss">
                        <option value="">--SELECCIONAR--</option>
                        @foreach ($grado_estudio as $itemGradoEstudio => $val)
                            <option value="{{$val}}">{{$val}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <div class="custom-file">
                        <label for="file_upload " class="control-label">FICHA IDENTIFICACIÓN CERSS</label>
                        <input type="file" class="form-control" id="file_upload" name="file_upload">
                    </div>
                </div>
            </div>
            <!--botones de enviar y retroceder-->
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <a class="btn btn-danger" href="{{URL::previous()}}">Regresar</a>
                    </div>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- Full Height Modal Right -->
            <div class="modal fade right" id="fullHeight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                <!-- Add class .modal-full-height and then add class .modal-right (or other classes from list above) to set a position to the modal -->
                    <div class="modal-dialog modal-full-height modal-right modal-notify modal-warning" role="document">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title w-100" id="myModalLabel">INFORMACIÓN ACERCA DE...</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="text-justify">
                                    <p>
                                        LA INFORMACIÓN CONTENIDA EN ÉSTE APARTADO PERMITIRÁ AL OPERADOR DEL MÓDULO PODER CONOCER DE PRIMERA MANO
                                        LA INFORMACIÓN Y LOS CAMPOS QUE SON PUNTUALMENTE REQUERIDOS PARA OPTIMIZAR LA CARGA DE INFORMACIÓN PARA EL PROCESO DE
                                        CAPTURA DE LOS ALUMNOS DE DIFERENTES CURSOS QUE OTORGA EL INSTITUTO.
                                        <br>A CONTNUACIÓN SE ENLISTA LOS SIGUIENTES CAMPOS:

                                        <ul class="list-group z-depth-0">
                                            <li class="list-group-item justify-content-between">
                                                <b> NOMBRE DEL ASPIRANTE - APELLIDO PATERNO </b>
                                            </li>
                                            <li class="list-group-item justify-content-between">
                                                <b> DÍA - MES - AÑO </b>
                                            </li>
                                            <li class="list-group-item justify-content-between">
                                                <b> GENERO - ESTADO CIVIL</b>
                                            </li>
                                            <li class="list-group-item justify-content-between">
                                                <b> CURP - FICHA IDENTIFICACIÓN CERSS</b>
                                            </li>
                                            <li class="list-group-item justify-content-between">
                                                <b> ESTADO - MUNICIPIO</b>
                                            </li>
                                            <li class="list-group-item justify-content-between">
                                                <b> ÚLTIMO GRADO DE ESTUDIOS - EXPEDIENTE - DOMICILIO</b>
                                            </li>
                                        </ul>
                                    </p>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
                            </div>
                        </div>

                    </div>
            </div>
        <!-- Full Height Modal Right -->
    </div>
@endsection
@section('script_content_js')
    <script type="text/javascript">
        $(function(){

            $.validator.addMethod("CURP_CERSS", function (value, element) {
                if (value !== '') {
                    var patt = new RegExp("^[A-Z][A,E,I,O,U,X][A-Z]{2}[0-9]{2}[0-1][0-9][0-3][0-9][M,H][A-Z]{2}[B,C,D,F,G,H,J,K,L,M,N,Ñ,P,Q,R,S,T,V,W,X,Y,Z]{3}[0-9,A-Z][0-9]$");
                    return patt.test(value);
                } else {
                    return false;
                }
            }, "Ingrese una CURP valida");

            $.validator.addMethod("RFC_CERSS", function (value, element) {
                if (value !== '') {
                    var patt = new RegExp("^[A-Z,Ñ,&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9][A-Z,0-9]?[A-Z,0-9]?[0-9,A-Z]?$");
                    return patt.test(value);
                } else {
                    return false;
                }
            }, "Ingrese un RFC valido");

            $("#curp_cerss").keyup(function(){
               if($(this).val().length > 0)
               {
                    $(this).addClass('CURP_CERSS');
               } else {
                    $(this).removeClass('CURP_CERSS');
               }
            });

            $('#rfc_cerss').keyup(function(){
               if($(this).val().length > 0)
               {
                    $(this).addClass('RFC_CERSS');
               } else {
                    $(this).removeClass('RFC_CERSS');
               }
            });

            /****
            * sólo acepta números en el texbox
            */
            $('#numero_expediente_cerss').keypress(function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    //display error message
                    return false;
                }
            });
            /**
            * Validar el tamaño del archivo en 2 MB
            */
            $.validator.addMethod('filesize', function (value, element, param) {
                return this.optional(element) || (element.files[0].size <= param * 1000000)
            }, 'El tamaño del archivo debe ser menor a {0} MB');

            /****
            * sólo acepta números en el texbox
            */
            $('#anio_cerss').keypress(function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    //display error message
                    return false;
                }
            });

            /**
            * validación nueva del SID
            */
            $('#form_sid_cerss').validate({
                rules: {
                    nombre_cerss: {
                        required: true,
                        minlength: 2
                    },
                    nombre_aspirante_cerss: {
                        required: true,
                        minlength: 2
                    },
                    apellidoPaterno_aspirante_cerss: {
                        required: true,
                    },
                    genero_cerss: {
                        required: true
                    },
                    dia_cerss: {
                        required: true
                    },
                    mes_cerss: {
                        required: true
                    },
                    anio_cerss: {
                        required: true,
                        maxlength: 4,
                        number: true
                    },
                    file_upload: {
                        required: true,
                        extension: "pdf",
                        filesize: 2 //max size 2mb
                    }
                },
                messages: {
                    nombre_cerss: {
                        required: 'Por favor ingrese el nombre del cerss',
                        minlength: jQuery.validator.format("Por favor, al menos {0} caracteres son necesarios")
                    },
                    nombre_aspirante_cerss: {
                        required: 'Por favor ingrese su nombre',
                        minlength: jQuery.validator.format("Por favor, al menos {0} caracteres son necesarios")
                    },
                    apellidoPaterno_aspirante_cerss: {
                        required: 'Por favor ingrese su apellido'
                    },
                    genero_cerss: {
                        required: 'Por favor Elegir su genero'
                    },
                    dia_cerss: {
                        required: "Por favor, seleccione el día"
                    },
                    mes_cerss: {
                        required: "Por favor, seleccione el mes"
                    },
                    anio_cerss: {
                        required: "Por favor, Ingrese el año",
                        maxlength: "Sólo acepta 4 digitos",
                        number: "Sólo se aceptan números"
                    },
                    medio_entero: {
                        required: "Por favor, seleccione una opción"
                    },
                    motivos_eleccion_sistema_capacitacion: {
                        required: "Por favor, seleccione una opción"
                    },
                    file_upload: {
                        required: "Por favor, Seleccione un archivo",
                        extension: "Sólo se permiten pdf",
                    }
                }
            });

        });
    </script>
@endsection
