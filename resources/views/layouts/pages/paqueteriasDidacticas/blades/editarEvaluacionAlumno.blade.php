<hr style="border-color:dimgray">
<label>
    <h2>EEVALUACIÓN DE APRENDIZAJE AL ALUMNO</h2>
</label>

<hr style="border-color:dimgray">
<div class="form-row">
    <div class="card-paq col-md-12">
        <div class="contentBx col-md-12">
            <div class="form-group col-md-12 col-sm-12">
                <label for="instrucciones" class="control-label">INSTRUCCIONES</label>
                <textarea placeholder="Agrege aqui las instrucciones para la evaluacion del alumno" class="form-control" id="instrucciones" name="instrucciones" cols="15" rows="5">{{ $instrucciones }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="row col-md-12" id="preguntas-area-parent">
    <input type="number" hidden id="numPreguntas" name="numPreguntas" value="1">
    @foreach($evaluacionAlumno as $index => $preguntas)
    
    <div class="card-paq col-md-12">
        <div class="contentBx col-md-12">
            <br>
            <div class="row col-md-12" id="pregunta{{ $index+1 }}">
                <div class="form-row col-md-12 hideable">
                    <!-- selects -->

                    <div class="form-group col-md-6 col-sm-6">
                        <select onchange="cambiarTipoPregunta(this)" class="form-control" name="pregunta{{  $index+1 }}-tipo">
                            <option value="multiple" {{$preguntas->tipo == 'multiple' ? 'selected' : ''}} >Multiple</option>
                            <option value="abierta" {{$preguntas->tipo == 'abierta' ? 'selected' : ''}}>Abierta</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6 col-sm-6">

                        <select class="form-control contenidoTematicoPregunta" name="pregunta{{ $index+1 }}-contenidoT">
                            <option selected value="{{ $preguntas->contenidoTematico }}">{{ $preguntas->contenidoTematico}}</option>
                        </select>
                    </div>

                </div>
                <div class="form-row col-md-7 col-sm-12">
                    <div class="form-group col-md-12 col-sm-10">
                        <input placeholder="Pregunta sin texto" type="text" class="form-control resp-abierta g-input" name="pregunta{{ $index+1 }}" value="{{ old('pregunta1', $preguntas->descripcion)}}">
                    </div>
                </div>



                <div class="form-row col-md-7 opcion-area-p1" id="pregunta{{ $index+1 }}-opc">
                    <input type="text" hidden id="pregunta{{ $index+1 }}-opc-answer" name="pregunta{{ $index+1 }}-opc-answer" value=" {{ $preguntas->respuesta }}" >
                    <?php $abecedario = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'Ñ', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'); ?>
                    @foreach($preguntas->opciones as $indice => $opcion)
                    <div class="input-group mb-3 ">
                        
                        
                        <div class="input-group-text">
                            <input type="radio" onclick="setAceptedAnswer(this)" name="pregunta{{ $index+1 }}-opc-correc[]" {{ $preguntas->respuesta === $abecedario[$indice] ? 'checked' : '' }}>
                        </div>

                        &nbsp;&nbsp;&nbsp;
                        
                        <input placeholder="Opcion" type="text" class="form-control resp-abierta multiple" name="pregunta{{ $index+1 }}-opc[]" value="{{ old('pregunta-$index+1-opc[]', $opcion) }} ">
                        <a class="btn btn-warning btn-circle m-1 btn-circle-sm" onclick="removerOpcion(this)">
                            <i class="fa fa-minus"></i>
                        </a>
                    </div>
                    @endforeach
                </div>

                <div class="form-row col-md-6 opcion-area-pregunta{{ $index+1 }} hideable">
                    <div class="input-group mb-3">
                        <a style="cursor: default;" onclick="agregarOpcion(this)">Agregar opcion</a>
                    </div>
                </div>

                <div class="form-row col-md-7 respuesta-abierta-area ra-p1" style="display: none">
                    <div class="input-group mb-3">
                        <input placeholder="Texto de la respuesta abierta" name="pregunta{{ $index+1 }}-resp-abierta" type="text" class="form-control resp-abierta">
                    </div>
                </div>
            </div>

            <div class="row opciones col-md-12 hideable">
                <div class="col-md-10">
                    <div class="form-group col-md-4">
                        <a style="cursor: default;" onclick="agregarPregunta(this)" class="btn btn-success">Agregar Pregunta</a>
                    </div>
                </div>
                @if($index > 0)
                <div class="form-row col-md-2" >
                    <div class="form-group col-md-1 col-sm-6">

                        <button type="button" class="btn btn-danger" onclick="removerPregunta(this)">
                            <i class="fa fa-trash"></i>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
    
</div>


@can('paqueteriasdidacticas.crear')
@if($curso->estatus_paqueteria != 'ENVIADO A PREVALIDACION' && $curso->estatus_paqueteria!= 'AUTORIZADO')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            
            
            <a onclick="save('evaluacion')" type="submit" class="btn btn-primary">Guardar</a>
            
        </div>
    </div>
</div>
@endif
@endcan