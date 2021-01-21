!--Creado por Julio Alcaraz-->
@extends('theme.sivyc.layout')
<!--llamar a la plantilla -->
@section('title', '911 | SIVyC Icatech')
<!--seccion-->
@section('content')
    <div class="container g-pt-50"> 
        <div class="row">
            <h4>Reporte 911<br>Unidad de Capacitacion Catazaja</br>Turno Vespertino</br></h4>  
        </div>
        <div class="row">
            <div class="pull-left">
                {{ Form::open(['route' => 'reportes.vista_911', 'method' => 'post', 'class' => 'form-inline', 'enctype' => 'multipart/form-data' ]) }}
                {{ Form::date('fecha_inicio', null , ['class' => 'form-control  mr-sm-1', 'placeholder' => 'FECHA INICIO']) }}
                {{ Form::date('fecha_termino', null , ['class' => 'form-control  mr-sm-1', 'placeholder' => 'FECHA TERMINO']) }}              
                <select class="form-control" id="turno" name="turno">
                    <option>--SELECIONAR--</option>
                    <option>Matutino</option>
                    <option>Vespertino</option>
                </select>
                <button input type="submit" class="btn btn-dark">Filtrar</button>
                {!! Form::close() !!}
            </div> 
        </div>   
        <hr style="border-color:dimgray">          
            @if ($var_cursos->isEmpty())
                <div>No hay Registros para mostrar</div>
            @else       
                <div class="table-responsive" >     
                    <table  id="table-911" class="table">                
                        <thead class="thead-dark">
                            <tr align="center">
                                <th scope="col">Clave especialidad</th>
                                <th scope="col">Nombre especialidad</th>
                                <th scope="col">Grupos</th>
                                <th scope="col">Inscripcion<br>Hombres < 15 </br></th>
                                <th scope="col">Inscripcion<br>Mujeres < 15 </br></th>
                                <th scope="col">Existencia<br>Hombres < 15 </br></th>
                                <th scope="col">Existencia<br>Mujeres < 15 </br></th>
                                <th scope="col">Acreditados<br>Hombres < 15 </br></th>
                                <th scope="col">Acreditados<br>Mujeres < 15 </br></th>
                                <th scope="col">Inscripcion<br>Hombres 15 - 19</br></th>
                                <th scope="col">Inscripcion<br>Mujeres 15 - 19</br></th>
                                <th scope="col">Existencia<br>Hombres 15 - 19</br></th>
                                <th scope="col">Existencia<br>Mujeres 15 - 19</br></th>
                                <th scope="col">Acreditados<br>Hombres 15 - 19</br></th>
                                <th scope="col">Acreditados<br>Mujeres 15 - 19</br></th>                                       
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($var_cursos as $datas)
                                <tr align="center">
                                    <td>{{ $datas->clave }}</td>
                                    <td>{{ $datas->nombre }}</td>
                                    <td>{{ $datas->tgrupos }}</td>
                                    <td>{{ $datas->th }}</td>
                                    <td>{{ $datas->tm }}</td>
                                    <td>{{ $datas->th }}</td>
                                    <td>{{ $datas->tm }}</td>
                                    <td>{{ $datas->tacreh }}</td>
                                    <td>{{ $datas->tacrem }}</td>                        
                                    <td>{{ $datas->th2 }}</td>
                                    <td>{{ $datas->tm2 }}</td>
                                    <td>{{ $datas->th2 }}</td>
                                    <td>{{ $datas->tm2 }}</td>
                                    <td>{{ $datas->tacreh2 }}</td>
                                    <td>{{ $datas->tacrem2 }}</td>                        
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>   
            @endif            
        </table>
        <br>
        <button input type="submit" class="btn btn-dark">Generar</button>
    </div>    
    <script src="{{ asset('js/scripts/datepicker-es.js') }}"></script>
@endsection