<!-- Creado por Orlando Chávez -->
@extends('theme.sivyc.layout')
@section('title', 'Instructor | Sivyc Icatech')
<head>
    <style>
        .switch {
          position: relative;
          display: inline-block;
          width: 90px;
          height: 34px;
        }

        .switch input {
          opacity: 0;
          width: 0;
          height: 0;
        }

        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          -webkit-transition: .4s;
          transition: .4s;
        }
        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          -webkit-transition: .4s;
          transition: .4s;
        }
        .slider:before {
          position: absolute;
          content: "";
          height: 26px;
          width: 26px;
          left: 4px;
          bottom: 4px;
          background-color: white;
          -webkit-transition: .4s;
          transition: .4s;
        }

        input:checked + .slider {
          background-color: #2196F3;
        }

        input:focus + .slider {
          box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
          -webkit-transform: translateX(50px);
          -ms-transform: translateX(50px);
          transform: translateX(50px);
        }

        /* Rounded sliders */
        .slider.round {
          border-radius: 34px;
        }

        .slider.round:before {
          border-radius: 50%;
        }
    </style>
</head>
@section('content')
    <link rel="stylesheet" href="{{asset('css/supervisiones/global.css') }}" />
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="card-header">
        <h1>Ver Instructor<h1>
    </div>
    <div class="card card-body">
        <h2>Vista de Documentos</h2>
        <div class="form-row">
            @if ($datains->archivo_ine != NULL)
                <a class="btn btn-danger" href={{$datains->archivo_ine}} target="_blank">Comprobante INE</a><br>
            @endif
            @if ($datains->archivo_domicilio != NULL)
                <a class="btn btn-danger" href={{$datains->archivo_domicilio}} target="_blank">Comprobante de Domicilio</a><br>
            @endif
            @if ($datains->archivo_curp != NULL)
                <a class="btn btn-danger" href={{$datains->archivo_curp}} target="_blank">CURP</a><br>
            @endif
            @if ($datains->archivo_alta != NULL)
                <a class="btn btn-danger" href={{$datains->archivo_alta}} target="_blank">Alta de Instructor</a><br>
            @endif
        </div>
        <div class="form-row">
            @if ($datains->archivo_bancario != NULL)
                <a class="btn btn-danger" href={{$datains->archivo_bancario}} target="_blank">Datos Bancarios</a><br>
            @endif
            @if ($datains->archivo_rfc != NULL)
                <a class="btn btn-danger" href={{$datains->archivo_rfc}} target="_blank">RFC/Constancia Fiscal</a><br>
            @endif
            @if ($datains->archivo_fotografia != NULL)
                <a class="btn btn-danger" href={{$datains->archivo_fotografia}} target="_blank">Fotografía</a><br>
            @endif
            @if ($datains->archivo_estudios != NULL)
                <a class="btn btn-danger" href={{$datains->archivo_estudios}} target="_blank">Estudios</a><br>
            @endif
            @if ($datains->archivo_otraid != NULL)
                <a class="btn btn-danger" href={{$datains->archivo_otraid}} target="_blank">Otra Identificación</a><br>
            @endif
        </div>
        <form id="registerinstructor"  method="POST" action="{{ route('saveins') }}" enctype="multipart/form-data">
            @csrf
                <br>
                <label><h2>Datos Personales</h2></label>
                <div style="text-align: right;width:100%">
                    @can('instructor.editar_fase2')
                        <button type="button" id="mod_instructor_fase2" class="btn btn-warning btn-lg">Modificar Campos</button>
                    @endcan
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputnombre">Nombre</label>
                        <input name='nombre' id='nombre' value="{{$datains->nombre }}" type="text" disabled class="form-control" aria-required="true">
                        <input name="id" id="id" value="{{$datains->id }}" hidden>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputapellido_paterno">Apellido Paterno</label>
                        <input name='apellido_paterno' id='apellido_paterno' value="{{$datains->apellidoPaterno }}" type="text" class="form-control" aria-required="true" disabled>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputapellido_materno">Apellido Materno</label>
                        <input name='apellido_materno' id='apellido_materno' value="{{$datains->apellidoMaterno}}" type="text" class="form-control" aria-required="true" disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputcurp">CURP</label>
                        <input name='curp' id='curp' value="{{$datains->curp}}" type="text" disabled class="form-control" disabled aria-required="true">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputrfc">RFC/Constancia Fiscal</label>
                        <input name='rfc' id='rfc' value="{{$datains->rfc}}" type="text" disabled class="form-control" disabled aria-required="true">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputfolio_ine">Folio INE</label>
                        <input name='folio_ine' id='folio_ine' value="{{$datains->folio_ine }}" type="text" disabled class="form-control" disabled aria-required="true">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputsexo">Sexo</label>
                        <select class="form-control" name="sexo" id="sexo" disabled>
                            @if ($datains->sexo == 'MASCULINO')
                                <option selected value='MASCULINO'>Masculino</option>
                                <option value='FEMENINO'>Femenino</option>
                            @else
                                <option value='MASCULINO'>Masculino</option>
                                <option selected value='FEMENINO'>Femenino</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-gorup col-md-4">
                        <label for="inputestado_civil">Estado Civil</label>
                        <select class="form-control" name="estado_civil" id="estado_civil" disabled>
                            @if($estado_civil != NULL)
                                <option selected value="{{$estado_civil->nombre}}">{{$estado_civil->nombre}}</option>
                            @endif
                            @foreach ($lista_civil as $item)
                                <option value="{{$item->nombre}}">{{$item->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputfecha_nacimiento">Fecha de Nacimiento</label>
                        <input name='fecha_nacimientoins' id='fecha_nacimientoins' value="{{$datains->fecha_nacimiento}}" type="date" disabled class="form-control" aria-required="true">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputentidad">Entidad</label>
                        <select class="form-control" name="entidad" id="entidad" onchange="local2()" disabled>
                            <option value="sin especificar">Sin Especificar</option>
                            @foreach ($estados as $items)
                                <option value="{{$items->id}}" @if($datains->entidad == $items->nombre) selected @endif>{{$items->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputmunicipio">Municipio</label>
                        <select class="form-control" name="municipio" id="municipio" onchange="local()" disabled required>
                            <option value="">Sin Especificar</option>
                            @foreach ($municipios as $item)
                                <option value="{{$item->id}}" @if($datains->municipio == $item->muni) selected @endif>{{$item->muni}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--<div class="form-group col-md-3">
                        <label for="inputasentamiento">Asentamientos</label>
                        <input name='asentamiento' id='asentamiento' type="text" class="form-control" aria-required="true" disabled value="{datains->asentamiento}}">
                    </div>-->
                    <div class="form-group col-md-3">
                        <label for="inputmunicipio">Localidad</label>
                        <select class="form-control" name="localidad" id="localidad" disabled required>
                            @if ($localidades == NULL)
                                <option value="">SELECCIONE</option>
                            @else
                                @foreach ($localidades as $itemx)
                                    <option value="{{$itemx->clave}}" @if($datains->clave_loc == $itemx->clave) selected @endif>{{$itemx->localidad}}</option>
                                @endforeach

                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-7">
                        <label for="inputdomicilio">Direccion de Domicilio</label>
                        <input name="domicilio" id="domicilio" value="{{$datains->domicilio }}" type="text" disabled class="form-control" aria-required="true">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputtelefono">Numero de Telefono Personal</label>
                        <input name="telefono" id="telefono" value="{{$datains->telefono }}" type="tel" disabled class="form-control" aria-required="true" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputcorreo">Correo Electronico</label>
                        <input name="correo" id="correo" value="{{$datains->correo }}" type="email" disabled class="form-control" placeholder="correo_electronico@ejemplo.com" aria-required="true" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputbanco">Nombre del Banco</label>
                        <input name="banco" id="banco" value="{{$datains->banco }}" type="text" disabled class="form-control" aria-required="true">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputclabe">Clabe Interbancaria</label>
                        <input name="clabe" id="clabe" value="{{$datains->interbancaria }}" type="text" disabled class="form-control" aria-required="true">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputnumero_cuenta">Numero de Cuenta</label>
                        <input name="numero_cuenta" value="{{$datains->no_cuenta }}" id="numero_cuenta" type="text" disabled class="form-control" aria-required="true">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputarch_ine">Archivo INE</label>
                        <input type="file" accept="application/pdf" class="form-control" id="arch_ine" name="arch_ine" placeholder="Archivo PDF" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputarch_domicilio">Archivo Comprobante de Domicilio</label>
                        <input type="file" accept="application/pdf" class="form-control" id="arch_domicilio" name="arch_domicilio" placeholder="Archivo PDF" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputarch_curp">Archivo CURP</label>
                        <input type="file" accept="application/pdf" class="form-control" id="arch_curp" name="arch_curp" placeholder="Archivo PDF" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputarch_alta">Archivo Alta de Instructor</label>
                        <input type="file" accept="application/pdf" class="form-control" id="arch_alta" name="arch_alta" placeholder="Archivo PDF" disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputarch_banco">Archivo Datos Bancarios</label>
                        <input type="file" accept="application/pdf" class="form-control" id="arch_banco" name="arch_banco" placeholder="Archivo PDF" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputarch_rfc">RFC/Constancia Fiscal</label>
                        <input type="file" accept="application/pdf" class="form-control" id="arch_rfc" name="arch_rfc" placeholder="Archivo PDF" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputarch_foto">Archivo Fotografia</label>
                        <input type="file" accept="image/jpeg" class="form-control" id="arch_foto" name="arch_foto" placeholder="Archivo PDF" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputarch_estudio">Archivo Grado de Estudios</label>
                        <input type="file" accept="application/pdf" class="form-control" id="arch_estudio" name="arch_estudio" placeholder="Archivo PDF" disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputarch_id">Archivo Otra Identificación</label>
                        <input type="file" accept="application/pdf" class="form-control" id="arch_id" name="arch_id" placeholder="Archivo PDF" disabled>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="extracurricular"><h3>Registro de Capacitador Externo STPS</h3></label>
                        <textarea name="stps" id="stps" cols="6" rows="4" class="form-control">{{$datains->stps}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="extracurricular"><h3>Estandar CONOCER</h3></label>
                        <textarea name="conocer" id="conocer" cols="6" rows="4" class="form-control">{{$datains->conocer}}</textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="extracurricular"><h3>Datos Extracurriculares</h3></label>
                        <textarea name="extracurricular" id="extracurricular" cols="6" rows="10" class="form-control">{{$datains->extracurricular}}</textarea>
                    </div>
                </div>
                <hr style="border-color:dimgray">
                <label><h2>Datos Academicos</h2></label>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputunidad_registra">Unidad que Registra</label>
                        <select class="form-control" name="unidad_registra" id="unidad_registra" disabled>
                            <option value="{{$unidad->cct}}">{{$unidad->unidad}}</option>
                            @foreach ($lista_unidad as $value )
                                <option value="{{$value->cct}}">{{$value->unidad}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputnumero_control">Numero de Control</label>
                        <input id="numero_control" name="numero_control" value="{{$datains->numero_control }}" type="text" disabled class="form-control" aria-required="true">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputhonorario">Regimen</label>
                        <select class="form-control" name="honorario" id="honorario" disabled>
                            <option selected value="HONORARIOS" @if ($datains->tipo_honorario == 'HONORARIOS') selected @endif>Honorarios</option>
                            <option value="ASIMILADO" @if ($datains->tipo_honorario == 'ASIMILADOS') selected @endif>Asimilados a Salarios</option>
                            <option value="AMBOS" @if ($datains->tipo_honorario == 'AMBOS') selected @endif>Honorarios y Asimilado a Salarios</option>
                        </select>
                    </div>
                </div>
                <br>
                <label><h4>Perfiles Profesionales</h4></label>
                @if (count($perfil) > 0)
                    <table class="table table-bordered table-responsive-md" id="table-perfprof">
                        <thead>
                            <tr>
                                <th scope="col">Grado Profesional</th>
                                <th scope="col">Area de la Carrera</th>
                                <th scope="col">Estatus</th>
                                <th scope="col">Nombre de Institucion</th>
                                <th width="85px">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($perfil as $item)
                                <tr>
                                    <th scope="row">{{$item->grado_profesional}}</th>
                                    <td>{{ $item->area_carrera }}</td>
                                    <td>{{ $item->estatus }}</td>
                                    <td>{{ $item->nombre_institucion }}</td>
                                    <td>
                                        @can('instructor.editar_fase2')
                                            <a class="btn btn-info" href="{{route('instructor-perfilmod', ['id' => $item->id, 'idins' => $datains->id])}}">Modificar</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                <div class="alert alert-warning">
                    <strong>Info!</strong> No hay Registros
                  </div>
                @endif
                <br>
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <caption>Lista de Perfiles Profesionales</caption>
                        </div>
                        <div class="pull-right">
                            @can('instructor.editar_fase2')
                                <a class="btn btn-info" href="{{route('instructor-perfil', ['id' => $datains->id])}}">Agregar Perfil Profesional</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <br>
                <label><h4>Cursos Validados para Impartir</h4></label>
                @if (count($validado) > 0)
                <table class="table table-bordered table-responsive-md" id="table-perfprof">
                    <thead>
                        <tr>
                            <th scope="col">Especialidad</th>
                            <th scope="col">Memo. Validación</th>
                            <th scope="col">Fecha de Validación</th>
                            <th scope="col">Criterio Pago</th>
                            <th scope="col">Obsevaciones</th>
                            <th scope="col">Activo</th>
                            <th width="85px">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($validado as $item)
                            <tr>
                                <th scope="row">{{$item->nombre}}</th>
                                <td>{{ $item->memorandum_validacion}}</td>
                                <td>{{ $item->fecha_validacion}}</td>
                                <td style="text-align: center;">{{ $item->criterio_pago_id }}</td>
                                <td>{{ $item->observacion }}</td>
                                <td>
                                    @if ($item->activo == TRUE)
                                        ACTIVO
                                    @else
                                        INACTIVO
                                    @endif
                                </td>
                                <td>
                                    @can('instructor.editar_fase2')
                                        <!--<a class="btn btn-info" href="{ route('instructor-editespectval', ['id' => item->especialidadinsid,'idins' => datains->id]) }}">Modificar</a>-->
                                        <a class="btn btn-info" href="{{ route('instructor-editespectval', ['id' => $item->espinid, 'idins' => $datains->id]) }}">Modificar</a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-warning">
                    <strong>Info!</strong> No hay Registros
                </div>
            @endif
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <caption>Lista de Cursos Validados para Impartir</caption>
                        </div>
                        <div class="pull-right">
                            @can('instructor.editar_fase2')
                                <a class="btn btn-info" href="{{ route('instructor-curso', ['id' => $datains->id]) }}">Agregar Curso Validado para Impartir</a>
                            @endcan
                        </div>
                    </div>
                </div>
                @can('instructor.altabaja')
                    <hr style="border-color:dimgray">
                    <label><h2>Estado General del Instructor</h2></label>
                    <div class="form-group col-md-4">
                        @if ($datains->estado == true)
                            <label class="switch">
                                <input id="estado" name="estado" type="checkbox" checked onclick="leyenda()">
                                <span class="slider round"></span>
                            </label>
                            <h5><p id="text1">Instructor Activo</p><p id="text2" style="display:none">Instructor Inactivo</p></h5>
                        @else
                            <label class="switch">
                                <input id="estado" name="estado" type="checkbox" onclick="leyenda()">
                                <span class="slider round"></span>
                            </label>
                            <h5><p id="text1" style="display:none">Instructor Activo</p><p id="text2">Instructor Inactivo</p></h5>
                        @endif
                    </div>
                    <label><h2>Alta/Baja al Instructor</h2></label>
                    <div class="form-group col-md-8">
                        <a class="btn btn-danger" href="{{ route('instructor-alta_baja', ['id' => $datains->id]) }}" >Alta/Baja</a>
                        <footer>El instructor dado de baja puede ser dado de alta de nuevo en cualquier momento necesario y viceversa.</footer>
                    </div>
                @endcan
                <hr style="border-color:dimgray">
                <br>
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <a class="btn btn-danger" href="{{URL::previous()}}">Regresar</a>
                        </div>
                        <div  class="pull-right">
                            <button disabled id="savemodbuttonins" type="submit" class="btn btn-primary" >Guardar Cambios</button>
                        </div>
                    </div>
                </div>
            <br>
        </form>
        <!--Modal-->
        <div class="modal fade" id="alta_bajaModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmar Proceso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Está seguro de cambiar el status del instructor?
                    </div>
                    <div class="modal-footer">
                        <form action="" id="validarForm" method="get">
                            @csrf
                            <input type="hidden" name="id">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success">Validar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function leyenda() {
            var checkBox = document.getElementById("estado");
            var text1 = document.getElementById("text1");
            var text2 = document.getElementById("text2");
            if (checkBox.checked == true){
            text1.style.display = "block";
            text2.style.display = "none";
            } else {
                text1.style.display = "none";
                text2.style.display = "block";
            }
        }
    </script>
@endsection
@section('script_content_js')
<script src="{{ asset("js/validate/orlandoBotones.js") }}"></script>
<script>
    function local() {
        // var x = document.getElementById("municipio").value;
        // console.log(x);

        var valor = document.getElementById("municipio").value;
        var datos = {valor: valor};
        var url = '/instructores/busqueda/localidad';
        var request = $.ajax
        ({
            url: url,
            method: 'POST',
            data: datos,
            dataType: 'json'
        });

        request.done(( respuesta) =>
        {
            $("#localidad").empty();
            var selectL = document.getElementById('localidad'),
            option,
            i = 0,
            il = respuesta.length;
            // console.log(il);
            // console.log( respuesta[1].id)
            for (; i < il; i += 1)
            {
                newOption = document.createElement('option');
                newOption.value = respuesta[i].clave;
                newOption.text=respuesta[i].localidad;
                // selectL.appendChild(option);
                selectL.add(newOption);
            }
        });
    }

    function local2() {
        // var x = document.getElementById("municipio").value;
        // console.log(x);

        var valor = document.getElementById("entidad").value;
        var datos = {valor: valor};
        // console.log('hola');
        var url = '/instructores/busqueda/municipio';
        var request = $.ajax
        ({
            url: url,
            method: 'POST',
            data: datos,
            dataType: 'json'
        });

        request.done(( respuesta) =>
        {
            $("#municipio").empty();
            var selectL = document.getElementById('municipio'),
            option,
            i = 0,
            il = respuesta.length;
            // console.log(il);
            // console.log( respuesta[1].id)
            for (; i < il; i += 1)
            {
                newOption = document.createElement('option');
                newOption.value = respuesta[i].id;
                newOption.text=respuesta[i].muni;
                // selectL.appendChild(option);
                selectL.add(newOption);
            }
        });
    }
</script>
@endsection

