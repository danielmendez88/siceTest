@extends('theme.sivyc.layout') {{--AGC--}}
@section('title', 'Paqueterias Didacticas | SIVyC Icatech')
@section('css_content')
<link rel="stylesheet" href="{{ asset('css/paqueterias/paqueterias.css') }}" />
<link rel="stylesheet" href="{{asset('css/global.css') }}" />
<link rel="stylesheet" href="{{asset('edit-select/jquery-editable-select.min.css') }}" />

@endsection
@section('content')
<link rel="stylesheet" href="{{asset('css/global.css') }}" />
<link rel="stylesheet" href="{{asset('edit-select/jquery-editable-select.min.css') }}" />

<div class="card-header">
    Validacion de Paqueterias Didacticas
</div>
<form method="POST" action="{{route('paqueteriasGuardar',$idCurso)}}" id="creacion" enctype="multipart/form-data">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @csrf
    <div class="card card-body" style=" min-height:150px;">

        <div class="row bg-light" style="padding:20px">
            <div class="form-group col-md-4">
                Solicitud: <b>{{ $curso->tipoSoli }}</b>
            </div>
            <div class="form-group col-md-6">
                Motivo Solicitud: <b>{{ $curso->motivoSoli }}</b>
            </div>
            <div class="form-group col-md-3">
                Estatus: <b>{{ $curso->estatus_paqueteria }}</b>
            </div>
        </div>
        @if($curso->estatus_paqueteria == 'ENVIADO A PREVALIDACION')
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="tipo" class="contro-label">Accion:</label>
                <select class="form-control" id="tipoAccion" name="accion">
                    <option value="" selected disabled>--SELECCIONAR--</option>
                    <option value="PREVALIDACION RECHAZADA ">RECHAZAR</option>
                    <option value="NO PROCEDE">NO PROCEDE</option>
                    <option value="PREVALIDACION ACEPTADA">VALIDO</option>
                </select>
            </div>

            <div class="form-group col-md-6">
                <div class="form-group col-md-12 col-sm-12">
                    <label for="objetivos col-md-12" class="control-label">OBSERVACIONES:</label>
                    <textarea placeholder="Objetivos especificos por tema" class="form-control" id="observaciones" name="observaciones"></textarea>
                </div>
            </div>

            <div class="form-group col-md-3">
                <div class="form-group col-md-12 col-sm-12">
                    <a class="btn btn-primary" id="responderSoli">Responder</a>
                </div>
            </div>
        </div>
        @elseif($curso->estatus_paqueteria == 'TURNADO A DTA')

        <div class="form-row">
            <div class="form-group col-md-4">
                <div class="form-group col-md-12 col-sm-12">
                    <label for="objetivos col-md-12" class="control-label">Memoramdum:</label>
                    <input type="text" placeholder="No. Memo" class="form-control" id="memo" name="memo">

                    <div id="memo_alert" class="alert  alert-warning alert-dismissible fade show" role="alert" style="display:none">
                        Introduce el numero de memoramdum
                        
                    </div>
                </div>
            </div>
            <div class="form-group col-md-4">
                <div class="form-group col-md-12 col-sm-12">
                    <label for="objetivos col-md-12" class="control-label">Fecha :</label>
                    <input type="date" placeholder="DD/MM/AAAA" class="form-control" id="fecha" name="fecha" value="{{ $fechaActual->format('Y-m-d') }}">
                </div>
            </div>
        </div>
        
        <div class="form-row">

            <div class="form-group col-md-3 col-sm-4">
                <label for="objetivos col-md-12" class="control-label"></label>
                <a type="button" class="btn btn-primary" href="{{ route('descargar.memo.soli',$idCurso) }}" target="_blank">Descargar Memoramdum Solicitud</a>
            </div>
            <div class="form-group col-md-3 col-sm-4">
                <label for="objetivos col-md-12" class="control-label"></label>
                <a type="button" class="btn btn-primary" id="generarMemoValiBtn">Generar Memoramdum Validacion</a>
            </div>
            <div class="form-group col-md-3 col-sm-4">
                <label for="objetivos col-md-12" class="control-label"></label>
                <a type="button" class="btn btn-primary" id="subirMemoValiBtn" data-toggle="modal" data-target="#myModal">Subir Memoramdum Validacion</a>
            </div>
        </div>
        @endif
    </div>

    <div class="card card-body" style=" min-height:450px;">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
        @endif


        <div style="text-align: right;width:65%">
            <label for="tituloformulariocubuzon_paqueteriasrso">
            </label>
        </div>

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item ">
                <a class="nav-link active" id="pills-paqdid-tab" data-toggle="pill" href="#pills-paqdid" role="tab" aria-controls="pills-paqdid" aria-selected="false">Paqueterias Didacticas</a>
            </li>

        </ul>
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        @if ($message = Session::get('warning'))
        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>
        @endif
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade  show active" id="pills-paqdid" role="tabpanel" aria-labelledby="pills-paqdid-tab">
                <hr style="border-color:dimgray">
                <label>
                    <h2>Material Didactico del curso</h2>
                </label>
                <div class="alert-custom" id="alert-files" style="display: none">
                    <span class="closebtn-p" onclick="this.parentElement.style.display='none';">&times;</span>
                    <strong><label for="" id="files-msg"></label></strong>
                </div>
                <hr style="border-color:dimgray">

                <table class="table table-striped col-md-10">
                    <thead>
                        <tr>
                            <th class="h4" scope="col"></th>
                            <th class="h4" scope="col"></th>
                            <th class="h4 text-center" scope="col" colspan="2">Seleccionar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="h6" scope="row"> CARTA DESCRIPTIVA </th>
                            <th></th>
                            <th class="text-center">
                                <a id="botonCARTADESCPDF" class="nav-link">
                                    <i class="fa fa-file-pdf-o  fa-2x fa-lg text-danger"></i>
                                </a>
                            </th>
                            <th class="text-center">
                                <a id="botonCARTADESCWORD" class="nav-link">
                                    <i class="fa fa-file-word-o  fa-2x fa-lg text-light"></i>
                                </a>
                            </th>
                        </tr>

                        <tr>
                            <th class="h6" scope="row"> MANUAL DIDACTICO</th>
                            <th></th>
                            <th class="text-center">
                                <a id="botonMANUALDIDPDF" class="nav-link">
                                    <i class="fa fa-file-pdf-o  fa-2x fa-lg text-danger"></i>
                                </a>
                            </th>
                            <th class="text-center">
                                <a id="botonMANUALWORD" class="nav-link">
                                    <i class="fa fa-file-word-o  fa-2x fa-lg text-light"></i>
                                </a>
                            </th>
                        </tr>
                        <tr>
                            <th class="h6" scope="row"> GUIA DE APRENDIZAJE</th>
                            <th></th>
                            <th class="text-center">
                                <a id="botonMANUALDIDPDF" class="nav-link">
                                    <i class="fa fa-file-powerpoint-o  fa-2x fa-lg text-light"></i>
                                </a>
                            </th>
                            <th class="text-center">
                                <a id="botonMANUALWORD" class="nav-link">
                                    <i class="fa fa-file-word-o  fa-2x fa-lg text-light"></i>
                                </a>
                            </th>
                        </tr>

                        <tr>
                            <th class="h6" scope="row"> EVALUACION ALUMNO </th>
                            <th></th>
                            <th class="text-center">
                                <a id="botonEVALALUMNPDF" class="nav-link">
                                    <i class="fa fa-file-pdf-o  fa-2x fa-lg text-danger"></i>
                                </a>
                            </th>
                            <th class="text-center">
                                <a id="botonEVALALUMNWORD" class="nav-link">
                                    <i class="fa fa-file-word-o  fa-2x fa-lg text-light"></i>
                                </a>
                            </th>
                        </tr>
                        <tr>
                            <th class="h6" scope="row"> EVALUACION DE CURSO E INSTRUCTOR </th>
                            <th></th>
                            <th class="text-center">
                                <a id="botonEVALINSTRUCTORPDF" class="nav-link">
                                    <i class="fa fa-file-pdf-o  fa-2x fa-lg text-danger"></i>
                                </a>
                            </th>
                            <th class="text-center">
                                <a id="botonEVALINSTRUCTORWORD" class="nav-link">
                                    <i class="fa fa-file-word-o  fa-2x fa-lg text-light"></i>
                                </a>
                            </th>
                        </tr>



                        <tr>
                            <th colspan="4"></th>
                        </tr>
                    </tbody>
                </table>

                <input type="text" hidden id="idCurso" value="{{$idCurso}}">
            </div>
        </div>
        <br>
    </div>
</form>



@section('script_content_js')
<script defer>
    $(document).ready(function() {
        var $form = $("#creacion");

        $("#botonCARTADESCPDF").click(function() {
            $('#creacion').attr('action', "{{route('DescargarPaqueteria',$idCurso)}}");
            $('#creacion').attr('target', "_blank");
            $form.append("<input type='hidden' name='paqueteria' value='carta_descriptiva'/>");
            $('#creacion').submit();
        });
        $("#botonEVALALUMNPDF").click(function() {
            $('#creacion').attr('action', "{{route('DescargarPaqueteria',$idCurso)}}");
            $('#creacion').attr('target', "_blank");
            $form.append("<input type='hidden' name='paqueteria' value='eval_alumno'/>");
            $('#creacion').submit();
        });
        $("#botonEVALINSTRUCTORPDF").click(function() {
            $('#creacion').attr('action', "{{route('DescargarPaqueteria',$idCurso)}}");
            $('#creacion').attr('target', "_blank");
            $form.append("<input type='hidden' name='paqueteria' value='eval_instructor'/>");
            $('#creacion').submit();
        });
        $("#botonMANUALDIDPDF").click(function() {
            $('#creacion').attr('action', "{{route('DescargarPaqueteria',$idCurso)}}");
            $('#creacion').attr('target', "_blank");
            $form.append("<input type='hidden' name='paqueteria' value='manual_didactico'/>");
            $('#creacion').submit();
        });
        $("#generarMemoValiBtn").click(function() {
            if ($('#memo').val() === '') {
                $('#memo_alert').css('display', 'block');
                return;
            }
            $('#memo_alert').css('display', 'none');
            $('#creacion').attr('action', "{{route('generar.memo.validacion',$idCurso)}}");
            $('#creacion').attr('target', "_blank");
            $('#creacion').submit();
        });

        $('#responderSoli').click(function() {

            idCurso = $('#idCurso').val();
            console.log(idCurso);
            if (($("#observaciones").val() != '' && $("#tipoAccion").val() !== null) || ($("#tipoAccion").val() == 'PREVALIDACION ACEPTADA')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    url: "/buzon/pre-validacion/respuesta/" + idCurso,
                    dataType: "json",
                    data: {
                        'accion': $("#tipoAccion").val(),
                        'observaciones': $("#observaciones").val(),
                        'idCurso': idCurso,
                    },
                    success: function(data) { // console.log(data); 
                        console.log(data);
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest);
                    }
                });
            }
        })
    });
</script>
@endsection
@endsection