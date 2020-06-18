<!--Creado por Daniel Méndez Cruz-->
@extends('theme.sivyc.layout')
<!--llamar a la plantilla -->
@section('title', 'Alumnos | SIVyC Icatech')
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
                    <h2>Alumnos Matriculados</h2>
                </div>
            </div>
        </div>
        <hr style="border-color:dimgray">

            <table  id="table-instructor" class="table table-bordered Datatables">
                <caption>Catalogo de Alumnos</caption>
                <thead>
                    <tr>
                        <th scope="col">N° CONTROL</th>
                        <th scope="col">NOMBRE</th>
                        <th width="160px">ACCIONES</th>
                        <th scope="col">MODIFICAR</th>
                        <th scope="col">SID</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumnos as $itemData)
                        <tr>
                            <td>{{$itemData->no_control}}</td>
                            <td scope="row">{{$itemData->nombrealumno}} {{$itemData->apellidoPaterno}} {{$itemData->apellidoMaterno}}</td>
                            <td>
                                <a href="{{route('alumnos.inscritos.detail', ['id' => base64_encode($itemData->id_registro)])}}" class="btn btn-success btn-circle m-1 btn-circle-sm" data-toggle="tooltip" data-placement="top" title="VER REGISTRO">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{route('alumnos.update.registro', ['id' => base64_encode($itemData->id_registro)])}}" class="btn btn-warning btn-circle m-1 btn-circle-sm isDisabled" data-toggle="tooltip" data-placement="top" title="MODIFICAR REGISTRO">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{route('documento.sid', ['nocontrol' => base64_encode($itemData->no_control)])}}" class="btn btn-danger btn-circle m-1 btn-circle-sm" data-toggle="tooltip" target="_blank" data-placement="top" title="DESCARGAR SID">
                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                    </tr>
                </tfoot>
            </table>
        <br>
    </div>
    <br>
@endsection
