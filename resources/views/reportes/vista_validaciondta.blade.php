<!--Creado por Julio Alcaraz-->
@extends('theme.sivyc.layout')
<!--llamar a la plantilla -->
@section('title', 'Cursos enviados a Dirección Técnica Académica | SIVyC Icatech')
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

        @media all and (max-width:500px){
            table{
                width:100%;
            }
            
            td{
                display:block;
                width:100%;
            }
            
            tr{
                display:block;
                margin-bottom:30px;
            }
        }
    </style>
@endsection
<!--seccion-->
@section('content')
    <div class="container g-pt-50">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>VALIDACIÓN DE CURSOS</h2>

                    {!! Form::open(['route' => 'alumnos.index', 'method' => 'GET', 'class' => 'form-inline' ]) !!}
                        <select name="busqueda_aspirante" class="form-control mr-sm-2" id="busqueda_aspirante">
                            <option value="">BUSCAR POR TIPO</option>
                            <option value="curp_aspirante">CURP</option>
                            <option value="nombre_aspirante">NOMBRE</option>
                        </select>
                        
                        <button class="btn btn-outline-info my-2 my-sm-0" type="submit">BUSCAR</button>
                    {!! Form::close() !!}
                </div>

                <div class="pull-right">
                    
                </div>
            </div>
        </div>
        <hr style="border-color:dimgray">
            <div class="table-responsive container-fluid">
                <table  id="table-instructor" class="table table-bordered table-responsive-md Datatables">
                    <caption>CURSOS VALIDADOS ENVIADOS A DIRECCIÓN TÉCNICA ACADÉMICA</caption>
                    <thead>
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
                        @foreach ($cursos_validar as $datas)
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
                    <tfoot>
                        <tr>
                            <td colspan="122">
                               
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <br>
    </div>
    <br>
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

        $('#enviardta').click(function(){
            $("#exampleModalCenter").modal("show");
        });

        $('#close_btn_modal_send_dta').click(function(){
            $("#numero_memo").rules('remove', 'required', 'extension', 'filesize');
            $("input[id*=numero_memo]").removeClass("error"); // workaround
            $("#exampleModalCenter").modal("hide");
        });

        $("#selectAll").click(function() {
            $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
        });
    });
</script>
@endsection