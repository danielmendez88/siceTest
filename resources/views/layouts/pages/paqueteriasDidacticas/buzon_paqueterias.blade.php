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
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif



    <h2>Buzon Solicitudes de Paqueterias</h2>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-autorizados-tab" data-toggle="pill" href="#pills-autorizados" role="tab" aria-controls="pills-autorizados" aria-selected="true">Autorizados</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-solicitados-tab" data-toggle="pill" href="#pills-solicitados" role="tab" aria-controls="pills-solicitados" aria-selected="false">Solicitados</a>
        </li>
    </ul>

    <hr style="border-color:dimgray">
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-autorizados" role="tabpanel" aria-labelledby="pills-autorizados-tab">

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
                        @if($curso->estatus_paqueteria == 'VALIDO')
                        <tr>
                            <td>{{ $curso->nombre_curso }}</td>
                            <td>{{ $curso->nivel_estudio }}</td>
                            <td>{{ $curso->modalidad }}</td>
                            <td>{{ $curso->fecha }}</td>
                            <td>{{ $curso->fechaumod }}</td>
                            <td>{{ $curso->estatus_paqueteria }}</td>
                            <td>
                                @can('paqueteriasdidacticas.validar')
                                <a href="{{route('buzon.ver.paqueteria',$curso->idcurso)}}" class="btn btn-warning btn-circle m-1 btn-circle-sm" title="Validar Paqueterias Didacticas">
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
                    @if( $curso->estatus_paqueteria != 'VALIDO' && $curso->estatus_paqueteria != '')
                    <tr>
                        <td>{{ $curso->nombre_curso }}</td>
                        <td>{{ $curso->nivel_estudio }}</td>
                        <td>{{ $curso->fecha }}</td>
                        <td>{{ $curso->fechaumod }}</td>
                        <td>{{ $curso->estatus_paqueteria }}</td>
                        <td>
                            @can('paqueteriasdidacticas.validar')
                            <a href="{{route('buzon.ver.paqueteria',$curso->idcurso)}}" class="btn btn-warning btn-circle m-1 btn-circle-sm" title="Validar Paqueterias Didacticas">
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