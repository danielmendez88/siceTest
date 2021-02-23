<!-- Creado por Orlando Chávez -->
@extends('theme.sivyc.layout')
@section('title', 'Modificacion de Solicitud de Pago | Sivyc Icatech')
@section('content')
    <div class="container g-pt-50">
        <form action="{{ route('savemod-solpa') }}" method="post" id="mod_solpa" enctype="multipart/form-data">
            @csrf
            <div style="text-align: right;width:62%">
                <label for="titulo"><h1>Modificación de Solicitud de Pago</h1></label>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputobservacion" class="control-label"><b>Observaciones de Rechazo</b></label>
                    <textarea cols="4" rows="4" type="text" class="form-control" readonly aria-required="true" id="observacion" name="observacion">{{$datap->observacion}}</textarea>
                </div>
            </div>
            <hr style="border-color:dimgray">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputno_contrato">Confirmacion de Numero de Contrato</label>
                    <input id="no_contrato" name="no_contrato" value="{{$datac->numero_contrato}}" disabled class="form-control">
                </div>
                <div class="form-group col-md-4">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputfolio">Confirmacion de Numero de Suficiencia</label>
                    <input id="no_suficiencia" name="no_suficiencia" value="{{$dataf->folio_validacion}}" disabled class="form-control">
                </div>
            </div>
            <hr style="border-color:dimgray">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputno_memo">Numero de Memorandum</label>
                    <input id="no_memo" name="no_memo" type="text" class="form-control" value="{{$datap->no_memo}}">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputelaboro">Nombre de Quien Elabora</label>
                    <input id="nombre_elabora" name="nombre_elabora" type="text" class="form-control" value="{{$elaboro->nombre}} {{$elaboro->apellidoPaterno}} {{$elaboro->apellidoMaterno}}">
                    <input id="id_elabora" name="id_elabora" hidden value="{{$directorio->solpa_elaboro}}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputnombre_para">Nombre del Destinatario</label>
                    <input id="destino" name="destino" type="text" class="form-control" value="{{$para->nombre}} {{$para->apellidoPaterno}} {{$para->apellidoMaterno}}">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputpuesto_para">Puesto del Destinatario</label>
                    <input id="destino_puesto" readonly name="destino_puesto" type="text" class="form-control" value="{{$para->puesto}}">
                    <input id="id_destino" name="id_destino" hidden value="{{$directorio->solpa_para}}">
                </div>
            </div>
            <hr style="border-color:dimgray">
            <h2>Documentación para Soporte de Pago</h2>
            <br>
            <label class="text-justify">
                <h6>En caso de que la documentación este erronea
                <br>favor de subir la indicada, de lo contrario dejar sin seleccionar archivos en las opciones</h6>
            </label>
            <div class="form-row">
                @if($datac->arch_factura == NULL)
                    <div class="form-group col-md-3">
                        <label for="inputarch_factura" class="control-label">Factura de Instructor</label>
                        <input type="file" accept="application/pdf" class="form-control" id="arch_factura" name="arch_factura" placeholder="Archivo PDF">
                    </div>
                @else
                <div class="form-group col-md-3">
                    <label for="input arch_factura" class="control-label"><h4>La Factura de Instructor ya fue Cargada.</h4></label>
                </div>
                @endif
                <div class="form-group col-md-3">
                    <label for="inputliquido" class="control-label">Importe Liquido en Factura</label>
                    <input type="text" name="liquido" id="liquido" class="form-control" value="{{$datap->liquido}}">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputarch_asistencia" class="control-label">Lista de asistencia</label>
                    <input type="file" accept="application/pdf" name="arch_asistencia" id="arch_asistencia" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputarch_evidencia" class="control-label">Evidencia Fotográfica</label>
                    <input type="file" accept="application/pdf" name="arch_evidencia" id="arch_evidencia" class="form-control">
                </div>
            </div>
            <br>
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label class="text-justify"><h6>La extension del archivo debe ser PDF
                           <br>Se recomienda comprimir el pdf <a href='https://smallpdf.com/es/comprimir-pdf' target="blank">aqui</a>
                           <br>Peso maximo: 4 MB
                    </label></h6>
                </div>
            </div>
            <hr style="border-color:dimgray">
            <div class="form-row">
                <div class="form-group col-md-9">
                    <h2>Vista de Datos Bancarios</h2>
                </div>
                <div class="pull-right">
                    <button type="button" id="mod-datosBancarios" class="btn btn-warning btn-primary" >Modificar Datos Bancarios</button>
                </div>
            </div>
            <small>
                Esta sección es opcional, favor de confirmar que el documento de dato bancario sea el correcto, de lo contrario,
                proceda a seleccionar el botón de modificación para subir el archivo correcto y corregir los campos
                "nombre de banco", "número de cuenta" y "clabe interbancaria"
            </small>
            <br>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label></label>
                    <a class="btn btn-info form-control" href={{$bancario->archivo_bancario}} download>Datos Bancarios</a><br>
                </div>
                <div class="form-group col-md-2"></div>
                <div class="form-group col-md-4">
                    <label for="inputarch_bancario" class="control-label">Modificar Archivo de Datos Bancarios</label>
                    <input type="file" accept="application/pdf" name="arch_bancario" id="arch_bancario" class="form-control" disabled>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputnombre_banco" class="control-label">Nombre de Banco</label>
                    <input type="text" name="nombre_banco" id="nombre_banco" class="form-control" disabled>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputnumero_cuenta" class="control-label">Número de Cuenta</label>
                    <input type="text" name="numero_cuenta" id="numero_cuenta" class="form-control" disabled>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputclabe" class="control-label">Clabe Interbancaria</label>
                    <input type="text" name="clabe" id="clabe" class="form-control" disabled>
                </div>
            </div>
            <hr style="border-color:dimgray">
            <h2>Con Copia Para</h2>
            <br>
            <!-- START CCP -->
                <h3>CCP 1</h3>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputnombre_ccp1">Nombre</label>
                        <input id="ccp1" name="ccp1" type="text" class="form-control" value="{{$ccp1->nombre}} {{$ccp1->apellidoPaterno}} {{$ccp1->apellidoMaterno}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputpuesto_para">Puesto</label>
                        <input id="ccpa1" readonly name="ccpa1" type="text" class="form-control" value="{{$ccp1->puesto}}">
                        <input id="id_ccp1" name="id_ccp1" hidden value="{{$directorio->solpa_ccp1}}">
                    </div>
                </div>
                <h3>CCP 2</h3>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputnombre_ccp2">Nombre</label>
                        <input id="ccp2" name="ccp2" type="text" class="form-control" value="{{$ccp2->nombre}} {{$ccp2->apellidoPaterno}} {{$ccp2->apellidoMaterno}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputpuesto_para">Puesto</label>
                        <input id="ccpa2" readonly name="ccpa2" type="text" class="form-control" value="{{$ccp2->puesto}}">
                        <input id="id_ccp2" name="id_ccp2" hidden value="{{$directorio->solpa_ccp2}}">
                    </div>
                </div>
                <h3>CCP 3</h3>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputnombre_ccp3">Nombre</label>
                        <input id="ccp3" name="ccp3" type="text" class="form-control" value="{{$ccp3->nombre}} {{$ccp3->apellidoPaterno}} {{$ccp3->apellidoMaterno}}">>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputpuesto_para">Puesto</label>
                        <input id="ccpa3" readonly name="ccpa3" type="text" class="form-control" value="{{$ccp3->puesto}}">
                        <input id="id_ccp3" name="id_ccp3" hidden value="{{$directorio->solpa_ccp3}}">
                    </div>
                </div>
            <!-- END CC -->
            <input hidden id='id_folio' name="id_folio" value="{{$dataf->id_folios}}">
            <input hidden id='id_contrato' name="id_contrato" value="{{$datac->id_contrato}}">
            <input hidden id='id_instructor' name="id_instructor" value="{{$bancario->idins}}">
            <input hidden id="id_pago" name="id_pago" value="{{$datap->id}}">
            <div class="pull-left">
                <a class="btn btn-danger" href="{{URL::previous()}}">Regresar</a>
            </div>
            <div class="pull-right">
                <button type="submit" class="btn btn-primary" >Guardar</button>
            </div>
            <br>
        </form>
        <br>
    </div>
@endsection
@section('script_content_js')
<script src="{{ asset("js/validate/autocomplete.js") }}"></script>
<script src="{{ asset("js/validate/orlandoBotones.js") }}"></script>
@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(function(){

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#mod-datosBancarios").click(function(e){
            e.preventDefault();
            $.ajax({
                success: function(){
                    $('#arch_bancario').prop("disabled", false)
                    $('#arch_bancario').prop("required", true)
                    $('#nombre_banco').prop("disabled", false)
                    $('#nombre_banco').prop("required", true)
                    $('#numero_cuenta').prop("disabled", false)
                    $('#numero_cuenta').prop("required", true)
                    $('#clabe').prop("disabled", false)
                    $('#clabe').prop("required", true)
                }
            });
        });
    });
</script>
@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
