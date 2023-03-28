<!--Creado por Orlando Chavez-->
@extends('theme.sivyc.layout')
<!--llamar a la plantilla -->
@section('Cursos', 'SUPRE | SIVyC Icatech')
<!--seccion-->
@section('content')
<style>
    * {
        box-sizing: border-box;
    }

    #myInput {
        background-image: url('img/search.png');
        background-position: 5px 10px;
        background-repeat: no-repeat;
        background-size: 32px;
        width: 100%;
        font-size: 16px;
        padding: 12px 20px 12px 40px;
        border: 1px solid #ddd;
        margin-bottom: 12px;
    }
</style>
<div class="container g-pt-50">
 



    <h2>Buzon Solicitudes de Paqueterias</h2>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-nuevo-tab" data-toggle="pill" href="#pills-nuevo" role="tab" aria-controls="pills-autorizados" aria-selected="true">Nueva</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-autorizados-tab" data-toggle="pill" href="#pills-autorizados" role="tab" aria-controls="pills-autorizados" aria-selected="true">Autorizados</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-solicitados-tab" data-toggle="pill" href="#pills-solicitados" role="tab" aria-controls="pills-solicitados" aria-selected="false">Solicitados</a>
        </li>
    </ul>

    <hr style="border-color:dimgray">
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-nuevo" role="tabpanel" aria-labelledby="pills-nuevo-tab">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Catalogo de Cursos</h2>

                        {!! Form::open(['route' => 'buzon.paqueterias', 'method' => 'GET', 'class' => 'form-inline' ]) !!}
                        <select name="tipo_curso" class="form-control mr-sm-2" id="tipo_curso">
                            <option value="">BUSCAR POR TIPO</option>
                            <option value="especialidad">ESPECIALIDAD</option>
                            <option value="curso">CURSO</option>
                            <option value="duracion">DURACIÓN</option>
                            <option value="modalidad">MODALIDAD</option>
                            <option value="clasificacion">CLASIFICACIÓN</option>
                            <option value="anio">AÑO</option>
                        </select>

                        {!! Form::text('busquedaPorCurso', null, ['class' => 'form-control mr-sm-2', 'placeholder' => 'BUSCAR', 'aria-label' => 'BUSCAR', 'value' => 1]) !!}
                        <button class="btn btn-outline-info my-2 my-sm-0" type="submit">BUSCAR</button>
                        {!! Form::close() !!}

                    </div>
                    <br>
                    
                </div>
            </div>

            <table id="table-instructor" class="table table-bordered Datatables">
                <caption>Catalogo de Cursos</caption>
                <thead>
                    <tr>
                        <th scope="col">Especialidad</th>
                        <th scope="col">Curso</th>
                        <th scope="col">Tipo de Curso</th>
                        <th scope="col">Duración</th>
                        <th scope="col">Modalidad</th>
                        <th scope="col">Clasificación</th>
                        <th scope="col">Costo</th>
                        @can('paqueteriasdidacticas')
                        <th scope="col">Paqueterias</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @if(isset($data))
                    @foreach ($data as $itemData)
                    <tr>
                        <th scope="row">{{$itemData->nombre}}</th>
                        <td>{{$itemData->nombre_curso}}</td>
                        <td>{{$itemData->tipo_curso}}</td>
                        <td>{{$itemData->horas}}</td>
                        <td>{{$itemData->modalidad}}</td>
                        <td>{{$itemData->clasificacion}}</td>
                        <td>{{$itemData->costo}}</td>

                       
                        @can('paqueteriasdidacticas')
                        <td>
                            <a href="{{route('paqueteriasDidacticas',$itemData->id)}}" class="btn btn-warning btn-circle m-1 btn-circle-sm" title="Paquetes">
                                <i class="fa fa-folder"></i>
                            </a>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                    @endif
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
        </div>
        <div class="tab-pane fade" id="pills-autorizados" role="tabpanel" aria-labelledby="pills-autorizados-tab">

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Curso</th>
                            <th scope="col">Especialidad</th>
                            <th scope="col">Modalidad</th>
                            <th scope="col">Fecha Solicitud</th>
                            <th scope="col" width="86px">Fecha Respuesta de Solicitud</th>
                            <th scope="col" width="86px">Estatus</th>
                            <th scope="col" width="7%">Acciones</th>



                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cursos as $curso)
                        @if($curso->estatus_paqueteria == 'AUTORIZADO')
                        <tr>
                            <td>{{ $curso->nombre_curso }}</td>                            
                            <td>{{ $curso->modalidad }}</td>
                            <td>{{ $curso->fecha }}</td>
                            <td>{{ $curso->fechaumod }}</td>
                            <td>{{ $curso->estatus_paqueteria }}</td>
                            <td>
                                @can('paqueteriasdidacticas.validar')
                                <a href="{{route('paqueteriasDidacticas',$curso->idcurso)}}" class="btn btn-warning btn-circle m-1 btn-circle-sm" title="Validar Paqueterias Didacticas">
                                    <i class="fa fa-folder"></i>
                                </a>
                                @endcan
                                @can('paqueteriasdidacticas.crear')
                                <a href="{{route('paqueteriasDidacticas',$curso->idcurso)}}" class="btn btn-warning btn-circle m-1 btn-circle-sm" title="Modificar Paqueterias Didacticas">
                                    <i class="fa fa-folder"></i>
                                </a>

                                @endcan
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>


        </div>

        <div class="tab-pane fade " id="pills-solicitados" role="tabpanel" aria-labelledby="pills-solicitados-tab">

            <table id="table-solicitados" class="table table-bordered Datatables">
                <caption>Buzon de paqueterias </caption>
                <thead>
                    <tr>
                        <th scope="col">Curso</th>
                        <th scope="col">Especialidad</th>
                        <th scope="col">Fecha Solicitud</th>
                        <th scope="col">Fecha Respuesta de Solicitud</th>
                        <th scope="col">Estatus</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    @foreach($cursos as $curso)
                    @if(($rolUser->slug == 'dta' && $curso->estatus_paqueteria != 'EN CAPTURA') || $rolUser->slug != 'dta')
                    @if( $curso->estatus_paqueteria != 'AUTORIZADO' && $curso->estatus_paqueteria != '')
                    <tr>
                        <td>{{ $curso->nombre_curso }}</td>                        
                        <td>{{ $curso->fecha }}</td>
                        <td>{{ $curso->fechaumod }}</td>
                        <td>{{ $curso->estatus_paqueteria }}</td>
                        <td>
                            @can('paqueteriasdidacticas.validar')
                            <a href="{{route('paqueteriasDidacticas',$curso->idcurso)}}" class="btn btn-warning btn-circle m-1 btn-circle-sm" title="Validar Paqueterias Didacticas">
                                <i class="fa fa-folder"></i>
                            </a>
                            @endcan
                            @can('paqueteriasdidacticas.crear')
                            <a href="{{route('paqueteriasDidacticas',$curso->idcurso)}}" class="btn btn-warning btn-circle m-1 btn-circle-sm" title="Modificar Paqueterias Didacticas">
                                <i class="fa fa-folder"></i>
                            </a>

                            @endcan
                        </td>
                    </tr>
                    @endif
                    @endif
                    @endforeach
                </tfoot>
            </table>

        </div>
    </div>


    <br>

    <br>
    @endsection