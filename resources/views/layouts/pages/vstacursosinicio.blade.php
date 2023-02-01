<!--Creado por Orlando Chavez-->
@extends('theme.sivyc.layout')
<!--llamar a la plantilla -->
@section('Cursos', 'SUPRE | SIVyC Icatech')
<!--seccion-->
@section('title', 'Catálogo de Cursos | SIVyC ICATECH')
@section('content')
    <link rel="stylesheet" href="{{asset('css/global.css') }}" />
    <div class="card-header">
        Catálogos / Cursos
    </div>

    <div class="card card-body" style=" min-height:450px;"> 
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12 margin-tb">
                    {!! Form::open(['route' => 'curso-inicio', 'method' => 'GET', 'class' => 'form-inline' ]) !!}
                        <select name="tipo_curso" class="form-control mr-sm-2" id="tipo_curso">
                            <option value="">BUSCAR POR</option>
                            <option value="especialidad">ESPECIALIDAD</option>
                            <option value="curso">CURSO</option>
                            <option value="duracion">DURACIÓN</option>
                            <option value="modalidad">MODALIDAD</option>
                            <option value="clasificacion">CLASIFICACIÓN</option>
                            <option value="anio">AÑO</option>
                        </select>
                        {!! Form::text('busquedaPorCurso', null, ['class' => 'form-control mr-sm-2', 'placeholder' => 'BUSCAR', 'aria-label' => 'BUSCAR', 'value' => 1]) !!}                       
                        {{ Form::submit('BUSCAR', ['id'=>'buscar','class' => 'btn']) }}
                    {!! Form::close() !!}
                <div class="pull-right">
                    @can('academico.catalogo.cursos')                     
                        <a class="btn btn-warning text-dark" href="{{route('academico.exportar.cursos')}}">EXPORTAR CURSOS ACTIVOS &nbsp;&nbsp;<i  class="fa fa-file-excel-o fa-2x fa-lg text-dark"></i></a>
                    @endcan
                    @can('academico.catalogo.cursosall')
                        <a class="btn btn-warning text-dark" href="{{route('academico.exportar.cursosall')}}">EXPORTAR TODOS LOS CURSOS &nbsp;&nbsp;<i  class="fa fa-file-excel-o fa-2x fa-lg text-dark"></i></a>
                    @endcan
                    @can('cursos.create')
                        <a class="btn" href="{{route('frm-cursos')}}">NUEVO CURSO</a>
                    @endcan                   
                </div>
            </div>
        </div>
        <table  id="table-instructor" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">ESPECIALIDAD</th>
                    <th scope="col">SERVICIO</th>
                    <th scope="col">CURSO</th>
                    <th scope="col">CAPACITACIÓN</th>
                    <th scope="col">DURACIÓN</th>
                    <th scope="col">MODALIDAD</th>
                    <th scope="col">CLASIFICACIÓN</th>
                    <th scope="col">COSTO</th>
                    <th scope="col">ESTATUS</th>
                    @can('cursos.show')
                        <th scope="col">EDITAR</th>
                    @endcan
                    <th scope="col">VER</th>
                    <th scope="col">CARTA DESCRIP</th>
                    @can('paqueteriasdidacticas')
                    <th scope="col">PAQUETERIAS</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $itemData)
                @php 
                    $servicio = $itemData->servicio;
                @endphp
                    <tr>
                        <th scope="row">{{$itemData->nombre}}</th>
                        <td>{{$servicio}}</td>
                        <td>{{$itemData->nombre_curso}}</td>
                        <td>{{$itemData->tipo_curso}}</td>
                        <td>{{$itemData->horas}}</td>
                        <td>{{$itemData->modalidad}}</td>
                        <td>{{$itemData->clasificacion}}</td>
                        <td>{{$itemData->costo}}</td>
                        <td>{{$itemData->estado}}</td>
                        @can('cursos.show')
                        <td>
                            <a class="nav-link" alt="Editar Registro" href="{{route('cursos-catalogo.show',['id' => base64_encode($itemData->id)])}}">
                                <i  class="fa fa-edit  fa-2x fa-lg text-success"></i>
                            </a>
                        </td>
                        @endcan
                        <td>
                            <a class="nav-link" alt="Ver Registro" href="{{route('cursos-catalogo.show',['id' => base64_encode($itemData->id)])}}" data-toggle="modal" data-placement="top" data-target="#fullHeightModalRight"
                                data-id="{{$itemData->id}}">
                                <i  class="fa fa-search  fa-2x fa-lg text-primary"></i>
                            </a>
                        </td>
                        <td>
                            @if($itemData->file_carta_descriptiva)
                            
                                <a class="nav-link"  alt="Descargar PDF" href="{{env('APP_URL').'/'.'storage'.$itemData->file_carta_descriptiva}}" target="_blank">
                                    <i  class="fa fa-file-pdf  fa-2x fa-lg text-danger"></i>
                                </a>
                                 
                            @endif
                        </td>                   
                        @can('paqueteriasdidacticas')
                        <td>
                            <a href="{{route('paqueteriasDidacticas',$itemData->id)}}" class="nav-link" title="Paquetes">
                            <i class="fa fa-2x fa-folder text-muted"></i>
                            </a>
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8">
                        {{ $data->appends(request()->query())->links() }}
                    </td>
                </tr>
            </tfoot>
        </table>
        <br>
        <!-- Full Height Modal Right -->
        <div class="modal fade right" id="fullHeightModalRight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">            
            <div class="modal-dialog modal-full-height modal-right" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title w-100" id="myModalLabel"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="contextoModalBody"></div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Full Height Modal Right -->
    </div>
    <br>
@endsection
@section('script_content_js')
    <script src="{{ asset('js/catalogos/cursos.js') }}"></script>
@endsection