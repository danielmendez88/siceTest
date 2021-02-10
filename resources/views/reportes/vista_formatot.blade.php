!--Creado por Julio Alcaraz-->
@extends('theme.sivyc.layout')
<!--llamar a la plantilla -->
@section('title', 'APERTURAS | SIVyC Icatech')
<!--seccion-->
@section('content')
    <div class="container g-pt-80"> 
        <div class="row">
            <h4>Reporte Formato T</h4>  
        </div>
        <div class="row">
            <div class="pull-left">
                {{ Form::open(['route' => 'formatot.cursos', 'method' => 'post', 'class' => 'form-inline', 'enctype' => 'multipart/form-data']) }}
                <select class="form-control" id="turno" name="mes">
                    <option>--SELECIONAR--</option>
                    <option>Enero</option>
                    <option>Febrero</option>
                    <option>Marzo</option>
                    <option>Abril</option>
                    <option>Mayo</option>
                    <option>Junio</option>
                    <option>Julio</option>
                    <option>Agosto</option>
                    <option>Septiembre</option>
                    <option>Octubre</option>
                    <option>Noviembre</option>
                    <option>Diciembre</option>
                </select>
                {{ Form::text('año', null , ['class' => 'form-control  mr-sm-1', 'placeholder' => 'AÑO A REPORTAR']) }}
                {!! Form::submit( 'BUSCAR', ['id'=>'formatot', 'class' => 'btn btn-dark', 'name' => 'submitbutton'])!!}
                {!! Form::close() !!}
            </div> 
        </div>
        <hr style="border-color:dimgray">
        @if (isset($var_cursos) )
            @if (is_null($var_cursos))
            <h2><b>NO HAY REGISTROS PARA MOSTRAR</b></h2>
            @else 
                <form id="dtaformGetDocument" method="POST" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <input type="text" class="form-control mr-sm-1" name="numero_memo" id="numero_memo" placeholder="NÚMERO DE MEMORANDUM">
                        </div>
                        <div class="form-group col-md-3">
                            <button input type="submit" id="generarMemoAFirma" name="generarMemoAFirma"  class="btn btn-danger my-2 my-sm-0 waves-effect waves-light">
                                <i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i>
                                GENERAR MEMORANDUM
                            </button> 
                        </div>
                        <div class="form-group col-md-3">
                            <button input type="button" id="enviarDTA" style="{{ $enFirma->isEmpty() ? 'display: none' : '' }}" name="enviarDTA"  class="btn btn-success my-2 my-sm-0 waves-effect waves-light">
                                <i class="fa fa-paper-plane fa-2x" aria-hidden="true"></i>
                                ENVIAR A VALIDACIÓN DE DTA
                            </button> 
                        </div>
                        <div class="form-group col-md-3">
                            <button type="button" id="mod_format" name="mod_format" style="{{ $enFirma->isEmpty() ? 'display: none' : '' }}"  class="btn btn-warning my-2 my-sm-0 waves-effect waves-light">
                                <i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>
                                Modificar Campos
                            </button>
                        </div>
                    </div> 
                    <div class="table-responsive">     
                        <table  id="table-911" class="table" style='width: 100%'>                
                            <thead class="thead-dark">
                                <tr align="center">
                                    <th scope="col">
                                        <div style = "width:100px; word-wrap: break-word">
                                            SELECCIONAR/QUITAR
                                            <input type="checkbox" id="selectAll" checked {{ $enFirma->isEmpty() ? '' : 'disabled'  }}/>
                                        </div>
                                    </th>
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
                            <tbody style="height: 300px; overflow-y: auto">
                                @foreach ($var_cursos as $datas)
                                    <tr align="center">
                                        <td><input type="checkbox" id="cb1" name="chkcursos_list[]" value="{{  $datas->id_tbl_cursos }}" checked {{ $datas->estadocurso == 'EN_FIRMA' ? 'disabled' : '' }}/></td></td>
                                        <td>{{ $datas->unidad }}</td>
                                        <td>{{ $datas->plantel }}</td>
                                        <td>{{ $datas->espe }}</td>
                                        <td><div style = "width:200px; word-wrap: break-word">{{ $datas->curso }}</div></td>
                                        <td><div style = "width:200px; word-wrap: break-word">{{ $datas->clave }}</div></td>
                                        <td>{{ $datas->mod }}</td>
                                        <td>{{ $datas->dura }}</td>
                                        <td>{{ $datas->turno }}</td>
                                        <td>{{ $datas->diai }}</td>
                                        <td>{{ $datas->mesi }}</td>
                                        <td>{{ $datas->diat }}</td>
                                        <td>{{ $datas->mest }}</td>
                                        <td>{{ $datas->pfin }}</td>
                                        <td>{{ $datas->horas }}</td>
                                        <td><div style = "width:200px; word-wrap: break-word">{{ $datas->dia }}</div></td>
                                        <td><div style = "width:200px; word-wrap: break-word">{{ $datas->horario }}</div></td>
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
                                        <td><div style = "width:200px; word-wrap: break-word">{{ $datas->cespecifico }}</div></td>
                                        <td><div style = "width:200px; word-wrap: break-word">{{ $datas->mvalida }}</div></td>
                                        <td><div style = "width:200px; word-wrap: break-word">{{ $datas->efisico }}</div></td>
                                        <td><div style = "width:200px; word-wrap: break-word">{{ $datas->nombre }}</div></td>
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
                                        <td><div style = "width:300px; word-wrap: break-word">{{ $datas->depen }}</div></td>
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
                                        <td><div style = "width:800px; word-wrap: break-word">{{ $datas->tnota }}</div></td>                      
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>          
            @endif
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
              <h5 class="modal-title" id="enviar_cursos_dta"><b>ADJUNTAR Y ENVIAR A VALIDACIÓN DTA</b></h5>
            </div>
            <form id="formSendDta" enctype="multipart/form-data" method="POST" action="{{ route('formatot.send.dta') }}">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input type="file" name="cargar_archivo_formato_t" id="cargar_archivo_formato_t" class="form-control">
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
    <script src="{{ asset('js/scripts/datepicker-es.js') }}"></script>
@endsection