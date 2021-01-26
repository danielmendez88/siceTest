<!--Creado por Julio Alcaraz-->
@extends('theme.sivyc.layout')
<!--llamar a la plantilla -->
@section('title', 'APERTURAS | SIVyC Icatech')
<!--seccion-->
@section('content')
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
    <div class="container g-pt-50">
        <div class="row">
            <div class="col-lg-8 margin-tb">
                <div>
                    <h3><b>GENERACIÓN DEL FORMATO T</b></h3>
                </div>
            </div>
        </div>
        
        {{ Form::open(['route' => 'formatot.cursos', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
            <div class="form-row">
                <div class="form-group col-md-4">
                    {{ Form::text('anio', null , ['class' => 'form-control  mr-sm-1', 'placeholder' => 'AÑO A REPORTAR']) }}
                </div>
                <div class="form-group col-md-4">
                    {!! Form::submit( 'FILTRAR', ['id'=>'formatot', 'class' => 'btn btn-outline-info my-2 my-sm-0 waves-effect waves-light', 'name' => 'submitbutton'])!!}
                </div>
            </div>
        {!! Form::close() !!}
            
        <hr style="border-color:dimgray">
        @if (isset($var_cursos) )
            @if (is_null($var_cursos))
            <h2><b>NO HAY REGISTROS PARA MOSTRAR</b></h2>
            @else  
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <input type="checkbox" id="selectAll" checked/>
                        <label for='selectAll'><b>SELECCIONAR/DESELECCIONAR TODO</b></label>
                    </div>
                    <div class="form-group col-md-4">
                        <button input type="button" id="generar_memo" name="generar_memo"  class="btn btn-danger">
                           <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                            GENERAR MEMO DE VALIDACIÓN
                        </button> 
                    </div>
                    <div class="form-group col-md-4">
                        <button input type="button" id="enviardta" name="enviardta"  class="btn btn-success">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            ENVIAR CURSOS VALIDADOS A DTA
                        </button> 
                    </div>
                </div>               
                <div class="table-responsive" >     
                    <table  id="table-911" class="table">                
                        <thead class="thead-dark">
                            <tr align="center">
                                <th scope="col">ENVIAR</th>
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
                                <th scope="col" WIDTH="500">OBSERVACIONES</th>                                       
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($var_cursos as $datas)
                                <tr align="center">
                                    <td><input type="checkbox" id="cb1" name="chkcursos_list[]" value="{{  $datas->id_tbl_cursos }}" checked/></td></td>
                                    <td>{{ $datas->unidad }}</td>
                                    <td>{{ $datas->plantel }}</td>
                                    <td>{{ $datas->espe }}</td>
                                    <td>{{ $datas->curso }}</td>
                                    <td>{{ $datas->clave }}</td>
                                    <td>{{ $datas->mod }}</td>
                                    <td>{{ $datas->dura }}</td>
                                    <td>{{ $datas->turno }}</td>
                                    <td>{{ $datas->diai }}</td>
                                    <td>{{ $datas->mesi }}</td>
                                    <td>{{ $datas->diat }}</td>
                                    <td>{{ $datas->mest }}</td>
                                    <td>{{ $datas->pfin }}</td>
                                    <td>{{ $datas->horas }}</td>
                                    <td>{{ $datas->dia }}</td>
                                    <td>{{ $datas->horario }}</td>
                                    <td>{{ $datas->tinscritos }}</td>
                                    <td>{{ $datas->imujer }}</td>
                                    <td>{{ $datas->ihombre }}</td>
                                    <td>{{ $datas->egresado }}</td>
                                    <td>{{ $datas->emujer }}</td>
                                    <td>{{ $datas->ehombre }}</td>
                                    <td>{{ $datas->desertado }}</td>
                                    <td>{{ $datas->costo }}</td>
                                    <td>{{ $datas->ctotal }}</td>
                                    <td>{{ $datas->etmujer }}</td>
                                    <td>{{ $datas->ethombre }}</td>
                                    <td>{{ $datas->epmujer }}</td>
                                    <td>{{ $datas->ephombre }}</td>
                                    <td>{{ $datas->cespecifico }}</td>
                                    <td>{{ $datas->mvalida }}</td>
                                    <td>{{ $datas->efisico }}</td>
                                    <td>{{ $datas->nombre }}</td>
                                    <td>{{ $datas->grado_profesional }}</td>
                                    <td>{{ $datas->estatus }}</td>
                                    <td>{{ $datas->sexo }}</td>
                                    <td>{{ $datas->memorandum_validacion }}</td>
                                    <td>{{ $datas->mexoneracion }}</td>
                                    <td>{{ $datas->empleado }}</td>
                                    <td>{{ $datas->desempleado }}</td>
                                    <td>{{ $datas->discapacidad }}</td>
                                    <td>{{ $datas->migrante }}</td>
                                    <td>{{ $datas->indigena }}</td>
                                    <td>{{ $datas->etnia }}</td>
                                    <td>{{ $datas->programa }}</td>
                                    <td>{{ $datas->muni }}</td>
                                    <td>{{ $datas->depen }}</td>
                                    <td>{{ $datas->cgeneral }}</td>
                                    <td>{{ $datas->sector }}</td>
                                    <td>{{ $datas->mpaqueteria }}</td>
                                    <td>{{ $datas->iem1 }}</td>
                                    <td>{{ $datas->ieh1 }}</td>
                                    <td>{{ $datas->iem2 }}</td>
                                    <td>{{ $datas->ieh2 }}</td>
                                    <td>{{ $datas->iem3 }}</td>
                                    <td>{{ $datas->ieh3 }}</td>
                                    <td>{{ $datas->iem4 }}</td>
                                    <td>{{ $datas->ieh4 }}</td>
                                    <td>{{ $datas->iem5 }}</td>
                                    <td>{{ $datas->ieh5 }}</td>
                                    <td>{{ $datas->iem6 }}</td>
                                    <td>{{ $datas->ieh6 }}</td>
                                    <td>{{ $datas->iem7 }}</td>
                                    <td>{{ $datas->ieh7 }}</td>
                                    <td>{{ $datas->iem8 }}</td>
                                    <td>{{ $datas->ieh8 }}</td>
                                    <td>{{ $datas->iesm1 }}</td>
                                    <td>{{ $datas->iesh1 }}</td>
                                    <td>{{ $datas->iesm2 }}</td>
                                    <td>{{ $datas->iesh2 }}</td>
                                    <td>{{ $datas->iesm3 }}</td>
                                    <td>{{ $datas->iesh3 }}</td>
                                    <td>{{ $datas->iesm4 }}</td>
                                    <td>{{ $datas->iesh4 }}</td>
                                    <td>{{ $datas->iesm5 }}</td>
                                    <td>{{ $datas->iesh5 }}</td>
                                    <td>{{ $datas->iesm6 }}</td>
                                    <td>{{ $datas->iesh6 }}</td>
                                    <td>{{ $datas->iesm7 }}</td>
                                    <td>{{ $datas->iesh7 }}</td>
                                    <td>{{ $datas->iesm8 }}</td>
                                    <td>{{ $datas->iesh8 }}</td>
                                    <td>{{ $datas->iesm9 }}</td>
                                    <td>{{ $datas->iesh9 }}</td>
                                    <td>{{ $datas->aesm1 }}</td>
                                    <td>{{ $datas->aesh1 }}</td>
                                    <td>{{ $datas->aesm2 }}</td>
                                    <td>{{ $datas->aesh2 }}</td>
                                    <td>{{ $datas->aesm3 }}</td>
                                    <td>{{ $datas->aesh3 }}</td>
                                    <td>{{ $datas->aesm4 }}</td>
                                    <td>{{ $datas->aesh4 }}</td>
                                    <td>{{ $datas->aesm5 }}</td>
                                    <td>{{ $datas->aesh5 }}</td>
                                    <td>{{ $datas->aesm6 }}</td>
                                    <td>{{ $datas->aesh6 }}</td>
                                    <td>{{ $datas->aesm7 }}</td>
                                    <td>{{ $datas->aesh7 }}</td>
                                    <td>{{ $datas->aesm8 }}</td>
                                    <td>{{ $datas->aesh8 }}</td>
                                    <td>{{ $datas->aesm9 }}</td>
                                    <td>{{ $datas->aesh9 }}</td>
                                    <td>{{ $datas->naesm1 }}</td>
                                    <td>{{ $datas->naesh1 }}</td>
                                    <td>{{ $datas->naesm2 }}</td>
                                    <td>{{ $datas->naesh2 }}</td>
                                    <td>{{ $datas->naesm3 }}</td>
                                    <td>{{ $datas->naesh3 }}</td>
                                    <td>{{ $datas->naesm4 }}</td>
                                    <td>{{ $datas->naesh4 }}</td>
                                    <td>{{ $datas->naesm5 }}</td>
                                    <td>{{ $datas->naesh5 }}</td>
                                    <td>{{ $datas->naesm6 }}</td>
                                    <td>{{ $datas->naesh6 }}</td>
                                    <td>{{ $datas->naesm7 }}</td>
                                    <td>{{ $datas->naesh7 }}</td>
                                    <td>{{ $datas->naesm8 }}</td>
                                    <td>{{ $datas->naesh8 }}</td>
                                    <td>{{ $datas->naesm9 }}</td>
                                    <td>{{ $datas->naesh9 }}</td>
                                    <td WIDTH="500">{{ $datas->tnota }}</td>                      
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>          
            @endif
        @else
            <h2><b>NO HAY REGISTROS PARA MOSTRAR</b></h2>
        @endif
        <br>
    </div>
    <!--MODAL-->
    <!-- ESTO MOSTRARÁ EL SPINNER -->
    <div hidden id="spinner"></div>
    <!--MODAL ENDS-->
    <!--MODAL FORMULARIO-->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="enviar_cursos_dta"><b>ENVIAR  CURSOS VALIDADOS A DTA</b></h5>
            </div>
            <form id="dtaform" enctype="multipart/form-data" method="POST">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="numero_memo">NÚMERO DE MEMORANDUM</label>
                            <input type="text" class="form-control" name="numero_memo" id="numero_memo" placeholder="NÚMERO DE MEMORANDUM">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="memorandum_validacion">ENVIAR MEMO DE VALIDACIÓN</label>
                            <input type="file" accept="application/pdf" class="form-control" id="memorandum_validacion" name="memorandum_validacion" placeholder="ENVIAR MEMO DE VALIDACIÓN">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="send_to_dta">ENVIAR</button>
                <button type="button" id="close_btn_modal_send_dta" class="btn btn-danger">CERRAR</button>
                </div>
            </form>
          </div>
        </div>
    </div>
    <!--MODAL FORMULARIO ENDS-->
@endsection
@section('script_content_js')
<script src="{{ asset('js/scripts/datepicker-es.js') }}"></script>
<script type="text/javascript">
    $(function(){

        document.querySelector('#spinner').setAttribute('hidden', '');

        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, 'El TAMAÑO DEL ARCHIVO DEBE SER MENOR A {0} bytes.');

        $('#dtaform').validate({
            rules: {
                "numero_memo" : {
                    required: true
                },
                "memorandum_validacion": {
                    required: true, 
                    extension: "pdf", 
                    filesize: 2000000
                }
            },
            messages: {
                numero_memo: {
                    required: "CAMPO REQUERIDO"
                },
                "memorandum_validacion": {
                    required: "ARCHIVO REQUERIDO",
                    accept: "SÓLO SE ACEPTAN DOCUMENTOS PDF"
                }
            },
            submitHandler: function(form, event){
                event.preventDefault();
                var check_cursos = new Array();
                $('input[name="chkcursos_list[]"]:checked').each(function() {
                    check_cursos.push(this.value);
                });
                /***
                * memorandum_validacion
                */
                var formData = new FormData(form);
                formData.append("check_cursos_dta", check_cursos);
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
                        document.querySelector("#spinner").removeAttribute('hidden');
                    },
                    success: function(response){ 
                        console.log(response);
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

        $('#enviardta').click(function(){
            $("#exampleModalCenter").modal("show");
        });

        $('#close_btn_modal_send_dta').click(function(){
            $("#numero_memo").rules('remove', 'required', 'extension', 'filesize');
            $("input[id*=numero_memo]").removeClass("error"); // workaround
            $("#exampleModalCenter").modal("hide");
        });
        
        //document.querySelector("#spinner").removeAttribute('hidden');
        
        $('#generar_memo').click(function(){
            var url = "{{route('formatot.send.dta')}}";
            var myCheckboxes = new Array();
            $('input[name="chkcursos_list[]"]:checked').each(function() {
                 myCheckboxes.push(this.value);
            });

            var memo = $('#numero_memo').val();
            console.log(myCheckboxes);
            var chk = JSON.stringify(myCheckboxes)
            var solicitud = $.ajax
                ({
                    url: url,
                    method: 'POST',
                    data: { chk: myCheckboxes, memo: memo},
                    dataType: 'json',
                    beforeSend: function(){
                        document.querySelector("#spinner").removeAttribute('hidden');
                    },
                    success: function(response){
                        console.log(response);
                        alert( "CURSOS VALIDADOS ENVIADOS A DTA EXITOSAMENTE! ");
                    },
                    complete:function(data){
                        // escondemos el modales
                        document.querySelector('#spinner').setAttribute('hidden', '');
                    },
                    error: function(jqXHR, textStatus){
                        //jsonValue = jQuery.parseJSON( jqXHR.responseText );
                        document.querySelector('#spinner').setAttribute('hidden', '');
                        console.log(jqXHR.status);
                        alert( "Hubo un error: " + jqXHR.status );
                    }
                });

                $.when(solicitud).then(function(data, textStatus, jqXHR ){
                    if (jqXHR.status === 200) {
                        document.querySelector('#spinner').setAttribute('hidden', '');
                    }
                });
            
            
            //console.log(sel);
        });

        $("#selectAll").click(function() {
            $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
        });
    });
</script>
@endsection