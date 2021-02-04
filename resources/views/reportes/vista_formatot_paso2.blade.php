<!--Creado por Julio Alcaraz-->
@extends('theme.sivyc.layout')
<!--llamar a la plantilla -->
@section('title', 'FORMATO T PASO 2 | SIVyC Icatech')
@section('content_script_css')
    <style>
        #spinner:not([hidden]) {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #spinner::after {
        content: "";
        width: 80px;
        height: 80px;
        border: 2px solid #f3f3f3;
        border-top: 3px solid #f25a41;
        border-radius: 100%;
        will-change: transform;
        animation: spin 1s infinite linear
        }

        @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
        }
    </style>
@endsection
<!--seccion-->
@section('content')
    <div class="container g-pt-50">
        <div class="alert"></div>
        <div class="row">
            <div class="col-lg-8 margin-tb">
                <div>
                    <h3><b>ENVÍO PARA VALIDACIÓN DE DIRECCIÓN TÉCNICA ACADÉMICA</b></h3>
                </div>
            </div>
        </div>
        
        {{-- {{ Form::open(['route' => 'formatot.cursos', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
            <div class="form-row">
                <div class="form-group col-md-4">
                    {{ Form::text('anio', null , ['class' => 'form-control  mr-sm-1', 'placeholder' => 'AÑO A REPORTAR']) }}
                </div>
                <div class="form-group col-md-4">
                    {!! Form::submit( 'FILTRAR', ['id'=>'formatot', 'class' => 'btn btn-outline-info my-2 my-sm-0 waves-effect waves-light', 'name' => 'submitbutton'])!!}
                </div>
            </div>
        {!! Form::close() !!}
             --}}
        <hr style="border-color:dimgray">
        @if (isset($varcursospaso2) )
            @if ($varcursospaso2->isEmpty())
            <h2><b>NO HAY REGISTROS PARA MOSTRAR</b></h2>
            @else  
                <form id="dtaformSendDocument" enctype="multipart/form-data" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="file" name="cargar_archivo_formato_t" id="cargar_archivo_formato_t" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <button input type="submit" id="enviardta" name="enviardta"  class="btn btn-danger">
                                <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                ENVIAR A VALIDACIÓN DE DTA
                            </button> 
                        </div>
                    </div>        
                </form>       
                <div class="table-responsive">     
                    <table  id="table-911" class="table" style='width: 100%'>                
                        <thead class="thead-dark">
                            <tr align="center">
                                <th scope="col">UNIDAD</th>
                                <th scope="col">PLANTEL</th>
                                <th scope="col">ESPECIALIDAD</th>
                                <th scope="col">CURSO</th>
                                <th scope="col">CLAVE</th>
                                <th scope="col">MOD</th>
                                <th scope="col">DURA</th>
                                <th scope="col">TURNO</th>
                                <th scope="col">DIAI</th>
                                <th scope="col">MESI</th>
                                <th scope="col">DIAT</th>
                                <th scope="col">MEST</th>
                                <th scope="col">PERI</th>
                                <th scope="col">HORAS</th>
                                <th scope="col">DIAS</th>
                                <th scope="col">HORARIO</th>
                                <th scope="col">INSCRITOS</th>
                                <th scope="col">FEM</th>
                                <th scope="col">MAS</th>
                                <th scope="col">EGRESADO</th>
                                <th scope="col">EMUJER</th>
                                <th scope="col">EHOMBRE</th>
                                <th scope="col">DESER</th>
                                <th scope="col">COSTO</th>
                                <th scope="col">TOTAL</th>
                                <th scope="col">ETMUJER</th>
                                <th scope="col">ETHOMBRE</th>
                                <th scope="col">EPMUJER</th>
                                <th scope="col">EPHOMBRE</th>
                                <th scope="col">ESPECIFICO</th>
                                <th scope="col">MVALIDA</th>
                                <th scope="col">ESPACIO FISICO</th>
                                <th scope="col">INSTRUCTOR</th>
                                <th scope="col">ESCOLARIDAD</th>
                                <th scope="col">DOCUMENTO</th>
                                <th scope="col">SEXO</th>
                                <th scope="col">MEMO VALIDACION</th>
                                <th scope="col">MEMO EXONERACION</th>
                                <th scope="col">TRABAJAN</th>
                                <th scope="col">NO TRABAJAN</th>
                                <th scope="col">DISCAPACITADOS</th>
                                <th scope="col">MIGRANTE</th>
                                <th scope="col">INDIGENA</th>
                                <th scope="col">ETNIA</th>
                                <th scope="col">PROGRAMA</th>
                                <th scope="col">MUNICIPIO</th>
                                <th scope="col">DEPENDENCIA BENEFICIADA</th>
                                <th scope="col">GENERAL</th>
                                <th scope="col">SECTOR</th>
                                <th scope="col">VALIDACION PAQUETERIA</th>
                                <th scope="col">IEDADM1</th>
                                <th scope="col">IEDADH1</th>
                                <th scope="col">IEDADM2</th>
                                <th scope="col">IEDADH2</th>
                                <th scope="col">IEDADM3</th>
                                <th scope="col">IEDADH3</th>
                                <th scope="col">IEDADM4</th>
                                <th scope="col">IEDADH4</th>
                                <th scope="col">IEDADM5</th>
                                <th scope="col">IEDADH5</th>
                                <th scope="col">IEDADM6</th>
                                <th scope="col">IEDADH6</th>
                                <th scope="col">IEDADM7</th>
                                <th scope="col">IEDADH7</th>
                                <th scope="col">IEDADM8</th>
                                <th scope="col">IEDADH8</th>
                                <th scope="col">IESCOLM1</th>
                                <th scope="col">IESCOLH1</th>
                                <th scope="col">IESCOLM2</th>
                                <th scope="col">IESCOLH2</th>
                                <th scope="col">IESCOLM3</th>
                                <th scope="col">IESCOLH3</th>
                                <th scope="col">IESCOLM4</th>
                                <th scope="col">IESCOLH4</th>
                                <th scope="col">IESCOLM5</th>
                                <th scope="col">IESCOLH5</th>
                                <th scope="col">IESCOLM6</th>
                                <th scope="col">IESCOLH6</th>
                                <th scope="col">IESCOLM7</th>
                                <th scope="col">IESCOLH7</th>
                                <th scope="col">IESCOLM8</th>
                                <th scope="col">IESCOLH8</th>
                                <th scope="col">IESCOLM9</th>
                                <th scope="col">IESCOLH9</th>
                                <th scope="col">AESCOLM1</th>
                                <th scope="col">AESCOLH1</th>
                                <th scope="col">AESCOLM2</th>
                                <th scope="col">AESCOLH2</th>
                                <th scope="col">AESCOLM3</th>
                                <th scope="col">AESCOLH3</th>
                                <th scope="col">AESCOLM4</th>
                                <th scope="col">AESCOLH4</th>
                                <th scope="col">AESCOLM5</th>
                                <th scope="col">AESCOLH5</th>
                                <th scope="col">AESCOLM6</th>
                                <th scope="col">AESCOLH6</th>
                                <th scope="col">AESCOLM7</th>
                                <th scope="col">AESCOLH7</th>
                                <th scope="col">AESCOLM8</th>
                                <th scope="col">AESCOLH8</th>
                                <th scope="col">AESCOLM9</th>
                                <th scope="col">AESCOLH9</th>
                                <th scope="col">NAESCOLM1</th>
                                <th scope="col">NAESCOLH1</th>
                                <th scope="col">NAESCOLM2</th>
                                <th scope="col">NAESCOLH2</th>
                                <th scope="col">NAESCOLM3</th>
                                <th scope="col">NAESCOLH3</th>
                                <th scope="col">NAESCOLM4</th>
                                <th scope="col">NAESCOLH4</th>
                                <th scope="col">NAESCOLM5</th>
                                <th scope="col">NAESCOLH5</th>
                                <th scope="col">NAESCOLM6</th>
                                <th scope="col">NAESCOLH6</th>
                                <th scope="col">NAESCOLM7</th>
                                <th scope="col">NAESCOLH7</th>
                                <th scope="col">NAESCOLM8</th>
                                <th scope="col">NAESCOLH8</th>
                                <th scope="col">NAESCOLM9</th>
                                <th scope="col">NAESCOLH9</th>
                                <th scope="col" style="width:50%">OBSERVACIONES</th>                                       
                            </tr>
                        </thead>
                        <tbody style="height: 300px; overflow-y: auto">
                            @foreach ($varcursospaso2 as $datas)
                                <tr align="center">
                                    <td style="width:3%">{{ $datas->unidad }}</td>
                                    <td style="width:3%">{{ $datas->plantel }}</td>
                                    <td style="width:3%">{{ $datas->espe }}</td>
                                    <td style="width:3%"><div style = "width:200px; word-wrap: break-word">{{ $datas->curso }}</div></td>
                                    <td style="width:3%"><div style = "width:200px; word-wrap: break-word">{{ $datas->clave }}</div></td>
                                    <td style="width:3%">{{ $datas->mod }}</td>
                                    <td style="width:3%">{{ $datas->dura }}</td>
                                    <td style="width:3%">{{ $datas->turno }}</td>
                                    <td style="width:3%">{{ $datas->diai }}</td>
                                    <td style="width:3%">{{ $datas->mesi }}</td>
                                    <td style="width:3%">{{ $datas->diat }}</td>
                                    <td style="width:3%">{{ $datas->mest }}</td>
                                    <td style="width:3%">{{ $datas->pfin }}</td>
                                    <td style="width:3%">{{ $datas->horas }}</td>
                                    <td style="width:3%"><div style = "width:200px; word-wrap: break-word">{{ $datas->dia }}</div></td>
                                    <td style="width:3%"><div style = "width:200px; word-wrap: break-word">{{ $datas->horario }}</div></td>
                                    <td style="width:3%">{{ $datas->tinscritos }}</td>
                                    <td style="width:3%">{{ $datas->imujer }}</td>
                                    <td style="width:3%">{{ $datas->ihombre }}</td>
                                    <td style="width:3%">{{ $datas->egresado }}</td>
                                    <td style="width:3%">{{ $datas->emujer }}</td>
                                    <td style="width:3%">{{ $datas->ehombre }}</td>
                                    <td style="width:3%">{{ $datas->desertado }}</td>
                                    <td style="width:3%">{{ $datas->costo }}</td>
                                    <td style="width:3%">{{ $datas->ctotal }}</td>
                                    <td style="width:3%">{{ $datas->etmujer }}</td>
                                    <td style="width:3%">{{ $datas->ethombre }}</td>
                                    <td style="width:3%">{{ $datas->epmujer }}</td>
                                    <td style="width:3%">{{ $datas->ephombre }}</td>
                                    <td style="width:3%"><div style = "width:200px; word-wrap: break-word">{{ $datas->cespecifico }}</div></td>
                                    <td style="width:3%"><div style = "width:200px; word-wrap: break-word">{{ $datas->mvalida }}</div></td>
                                    <td style="width:3%"><div style = "width:200px; word-wrap: break-word">{{ $datas->efisico }}</div></td>
                                    <td style="width:3%"><div style = "width:200px; word-wrap: break-word">{{ $datas->nombre }}</div></td>
                                    <td style="width:3%">{{ $datas->grado_profesional }}</td>
                                    <td style="width:3%">{{ $datas->estatus }}</td>
                                    <td style="width:3%">{{ $datas->sexo }}</td>
                                    <td style="width:3%">{{ $datas->memorandum_validacion }}</td>
                                    <td style="width:3%">{{ $datas->mexoneracion }}</td>
                                    <td style="width:3%">{{ $datas->empleado }}</td>
                                    <td style="width:3%">{{ $datas->desempleado }}</td>
                                    <td style="width:3%">{{ $datas->discapacidad }}</td>
                                    <td style="width:3%">{{ $datas->migrante }}</td>
                                    <td style="width:3%">{{ $datas->indigena }}</td>
                                    <td style="width:3%">{{ $datas->etnia }}</td>
                                    <td style="width:3%">{{ $datas->programa }}</td>
                                    <td style="width:3%">{{ $datas->muni }}</td>
                                    <td style="width:3%"><div style = "width:200px; word-wrap: break-word">{{ $datas->depen }}</div></td>
                                    <td style="width:3%">{{ $datas->cgeneral }}</td>
                                    <td style="width:3%">{{ $datas->sector }}</td>
                                    <td style="width:3%">{{ $datas->mpaqueteria }}</td>
                                    <td style="width:3%">{{ $datas->iem1 }}</td>
                                    <td style="width:3%">{{ $datas->ieh1 }}</td>
                                    <td style="width:3%">{{ $datas->iem2 }}</td>
                                    <td style="width:3%">{{ $datas->ieh2 }}</td>
                                    <td style="width:3%">{{ $datas->iem3 }}</td>
                                    <td style="width:3%">{{ $datas->ieh3 }}</td>
                                    <td style="width:3%">{{ $datas->iem4 }}</td>
                                    <td style="width:3%">{{ $datas->ieh4 }}</td>
                                    <td style="width:3%">{{ $datas->iem5 }}</td>
                                    <td style="width:3%">{{ $datas->ieh5 }}</td>
                                    <td style="width:3%">{{ $datas->iem6 }}</td>
                                    <td style="width:3%">{{ $datas->ieh6 }}</td>
                                    <td style="width:3%">{{ $datas->iem7 }}</td>
                                    <td style="width:3%">{{ $datas->ieh7 }}</td>
                                    <td style="width:3%">{{ $datas->iem8 }}</td>
                                    <td style="width:3%">{{ $datas->ieh8 }}</td>
                                    <td style="width:3%">{{ $datas->iesm1 }}</td>
                                    <td style="width:3%">{{ $datas->iesh1 }}</td>
                                    <td style="width:3%">{{ $datas->iesm2 }}</td>
                                    <td style="width:3%">{{ $datas->iesh2 }}</td>
                                    <td style="width:3%">{{ $datas->iesm3 }}</td>
                                    <td style="width:3%">{{ $datas->iesh3 }}</td>
                                    <td style="width:3%">{{ $datas->iesm4 }}</td>
                                    <td style="width:3%">{{ $datas->iesh4 }}</td>
                                    <td style="width:3%">{{ $datas->iesm5 }}</td>
                                    <td style="width:3%">{{ $datas->iesh5 }}</td>
                                    <td style="width:3%">{{ $datas->iesm6 }}</td>
                                    <td style="width:3%">{{ $datas->iesh6 }}</td>
                                    <td style="width:3%">{{ $datas->iesm7 }}</td>
                                    <td style="width:3%">{{ $datas->iesh7 }}</td>
                                    <td style="width:3%">{{ $datas->iesm8 }}</td>
                                    <td style="width:3%">{{ $datas->iesh8 }}</td>
                                    <td style="width:3%">{{ $datas->iesm9 }}</td>
                                    <td style="width:3%">{{ $datas->iesh9 }}</td>
                                    <td style="width:3%">{{ $datas->aesm1 }}</td>
                                    <td style="width:3%">{{ $datas->aesh1 }}</td>
                                    <td style="width:3%">{{ $datas->aesm2 }}</td>
                                    <td style="width:3%">{{ $datas->aesh2 }}</td>
                                    <td style="width:3%">{{ $datas->aesm3 }}</td>
                                    <td style="width:3%">{{ $datas->aesh3 }}</td>
                                    <td style="width:3%">{{ $datas->aesm4 }}</td>
                                    <td style="width:3%">{{ $datas->aesh4 }}</td>
                                    <td style="width:3%">{{ $datas->aesm5 }}</td>
                                    <td style="width:3%">{{ $datas->aesh5 }}</td>
                                    <td style="width:3%">{{ $datas->aesm6 }}</td>
                                    <td style="width:3%">{{ $datas->aesh6 }}</td>
                                    <td style="width:3%">{{ $datas->aesm7 }}</td>
                                    <td style="width:3%">{{ $datas->aesh7 }}</td>
                                    <td style="width:3%">{{ $datas->aesm8 }}</td>
                                    <td style="width:3%">{{ $datas->aesh8 }}</td>
                                    <td style="width:3%">{{ $datas->aesm9 }}</td>
                                    <td style="width:3%">{{ $datas->aesh9 }}</td>
                                    <td style="width:3%">{{ $datas->naesm1 }}</td>
                                    <td style="width:3%">{{ $datas->naesh1 }}</td>
                                    <td style="width:3%">{{ $datas->naesm2 }}</td>
                                    <td style="width:3%">{{ $datas->naesh2 }}</td>
                                    <td style="width:3%">{{ $datas->naesm3 }}</td>
                                    <td style="width:3%">{{ $datas->naesh3 }}</td>
                                    <td style="width:3%">{{ $datas->naesm4 }}</td>
                                    <td style="width:3%">{{ $datas->naesh4 }}</td>
                                    <td style="width:3%">{{ $datas->naesm5 }}</td>
                                    <td style="width:3%">{{ $datas->naesh5 }}</td>
                                    <td style="width:3%">{{ $datas->naesm6 }}</td>
                                    <td style="width:3%">{{ $datas->naesh6 }}</td>
                                    <td style="width:3%">{{ $datas->naesm7 }}</td>
                                    <td style="width:3%">{{ $datas->naesh7 }}</td>
                                    <td style="width:3%">{{ $datas->naesm8 }}</td>
                                    <td style="width:3%">{{ $datas->naesh8 }}</td>
                                    <td style="width:3%">{{ $datas->naesm9 }}</td>
                                    <td style="width:3%">{{ $datas->naesh9 }}</td>
                                    <td><div style = "width:700px; word-wrap: break-word">{{ $datas->tnota }}</div></td>                      
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @else
            <div align='center'>>
                <h2>
                    <b>NO HAY REGISTROS PARA MOSTRAR</b>
                </h2>
            </div >
        @endif
        <br>
    </div>
    <!--MODAL-->
    <!-- ESTO MOSTRARÁ EL SPINNER -->
    <div hidden id="spinner"></div>
    <!--MODAL ENDS-->
@endsection
@section('script_content_js')
<script src="{{ asset('js/scripts/datepicker-es.js') }}"></script>
<script type="text/javascript">
    $(function(){

        document.querySelector('#spinner').setAttribute('hidden', '');

        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, 'El TAMAÑO DEL ARCHIVO DEBE SER MENOR A {0} bytes.');

        $('#dtaformSendDocument').validate({
            rules: {
                "cargar_archivo_formato_t": {
                    required: true, 
                    extension: "pdf", 
                    filesize: 2000000
                }
            },
            messages: {
                "cargar_archivo_formato_t": {
                    required: "ARCHIVO REQUERIDO",
                    extension: "SÓLO SE ACEPTAN DOCUMENTOS PDF"
                }
            },
            submitHandler: function(form, event){
                event.preventDefault();
                /***
                * memorandum_validacion
                */
                var formData = new FormData(form);
                var _url = "{{route('formatot.send.dta')}}";
                var requested = $.ajax
                ({
                    url: _url,
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $("#exampleModalCenter").modal("hide");
                        document.querySelector("#spinner").removeAttribute('hidden');
                    },
                    success: function(response){
                        if (response === 1) {
                            $("#dtaform").trigger("reset");
                            $( ".alert" ).addClass( "alert-success");
                            $(".alert").append( "<b>CURSOS VALIDADOS ENVIADOS A DIRECCIÓN TÉCNICA ACADÉMICA</b>" )
                        }
                    },
                    complete:function(data){
                        // escondemos el modales
                        document.querySelector('#spinner').setAttribute('hidden', '');
                    },
                    error: function(jqXHR, textStatus){
                        //jsonValue = jQuery.parseJSON( jqXHR.responseText );
                        //document.querySelector('#spinner').setAttribute('hidden', '');
                        console.log(jqXHR.responseText);
                        alert( "Hubo un error: " + jqXHR.status );
                    }
                });

                $.when(requested).then(function(data, textStatus, jqXHR ){
                    if (jqXHR.status === 200) {
                        document.querySelector('#spinner').setAttribute('hidden', '');
                    }
                });
            }
        }); // configurar el validador

        // $('#enviardta').click(function(){
        //     $("#exampleModalCenter").modal("show");
        // });

        // $('#close_btn_modal_send_dta').click(function(){
        //     $("#numero_memo").rules('remove', 'required', 'extension', 'filesize');
        //     $("input[id*=numero_memo]").removeClass("error"); // workaround
        //     $("#exampleModalCenter").modal("hide");
        // });

        // $("#selectAll").click(function() {
        //     $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
        // });
    });
</script>
@endsection