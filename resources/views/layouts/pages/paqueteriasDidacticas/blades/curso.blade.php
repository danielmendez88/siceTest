<hr style="border-color:dimgray">
<label>
    <h2>INFORMACIÓN TÉCNICA DEL CURSO</h2>
</label>

<hr style="border-color:dimgray">
<div class="form-row">
    <!-- Unidad -->
    <div class="form-group col-md-6">
        <label for="areaCursos" class="control-label">Nombre del curso</label>
        <input placeholder="Nombre del curso" type="text" class="form-control" id="nombrecurso" name="nombrecurso" value="{{old('nombrecurso', $curso->nombre_curso)}}">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="entidadfederativa" class="contro-label">Entidad Federativa</label>
        <input placeholder="Entidad Federativa" type="text" class="form-control" id="entidadfederativa" name="entidadfederativa">
    </div>
    <div class="form-group col-md-4">
        <label for="cicloescolar" class="control-label">Ciclo Escolar</label>
        <input placeholder="Ciclo escolar" type="text" class="form-control" id="cicloescolar" name="cicloescolar">
    </div>
    <div class="form-group col-md-4">
        <label for="programaestrategico" class="control-label">Programa estrategico (Caso aplicable )</label>
        <input placeholder="Programa Estrategico" type="text" class="form-control" id="programaestrategico" name="programaestrategico">
    </div>
    <div class="form-group col-md-4">
        <label for="modalidad" class="control-label">Modalidad</label>
        <select class="form-control" id="modalidad" name="modalidad">
            <option value="" selected disabled>--SELECCIONAR--</option>
            <option value="EXT" {{$curso->modalidad == 'EXT' ? 'selected' : ''}}>EXT</option>
            <option value="CAE" {{$curso->modalidad == 'CAE' ? 'selected' : ''}}>CAE</option>
        </select>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-4">
        <label for="tipo" class="contro-label">Tipo</label>
        <select class="form-control" id="tipo" name="tipo">
            <option value="" selected disabled>--SELECCIONAR--</option>
            <option value="A DISTANCIA" {{$curso->tipo_curso == 'A DISTANCIA' ? 'selected' : ''}}>A DISTANCIA</option>
            <option value="PRESENCIAL" {{$curso->tipo_curso == 'PRESENCIAL' ? 'selected' : ''}}>PRESENCIAL</option>
            <option value="A DISTANCIA Y PRESENCIAL">A DISTANICA Y PRESENCIAL</option>
        </select>
    </div>
    <div class="form-group col-md-4">
        <label for="perfilidoneo" class="control-label">Perfil Idoneo del Instructor</label>
        <input placeholder="Pefil idoneo" type="text" class="form-control" id="perfilidoneo" name="perfilidoneo">
    </div>
    <div class="form-group col-md-4">
        <label for="duracion" class="control-label">Duracion en horas</label>
        <input placeholder="Horas" type="number" class="form-control" id="duracion" name="duracion" value="{{old('duracion', $curso->duracion)}}">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="formacionlaboral" class="contro-label">Campo de Formacion Laboral Profesional</label>
        <input placeholder="Formacion Laboral" type="text" class="form-control" id="formacionlaboral" name="formacionlaboral">
    </div>
    <div class="form-group col-md-4">
        <label for="especialidad" class="control-label">Especialidad  </label>
        <input placeholder="Especialidad" type="text" class="form-control " id="especialidad" name="especialidad" onkeyup="buscarEspecialidad()">
        <ul id="searchResult" class="searchResult" ></ul>
    </div>
    <div class="form-group col-md-4">
        <label for="publico" class="control-label">Publico o personal al que va dirigido</label>
        <textarea placeholder="Publico o personal al que va dirigido" class="form-control" id="publico" name="publico" cols="15" rows="5"></textarea>
    </div>
</div>

<hr style="border-color:dimgray">
<label>
    <h2>INFORMACION ACADEMICA DEL CURSO</h2>
</label>
<hr style="border-color:dimgray">
<div class="form-row">

    <div class="row col-md-7 col-sm-12">
        <div class="form-group col-md-12 col-sm-12">
            <label for="aprendizajeesperado" class="control-label">Objetivo General (Aprendizaje Esperado)</label>
            <textarea placeholder="Aprendizaje Esperado" class="form-control col-md-12" id="aprendizajeesperado" name="aprendizajeesperado" cols="20" rows="5"></textarea>
        </div>
    </div>

    <div class="row col-md-5 col-sm-12" id="row-criterios">
        <div class="form-group col-md-5 col-sm-5">
            <label for="criterio" class="control-label">Proceso de evaluacion</label>
            <input placeholder="P.E. Examen" type="text" class="form-control" id="criterio" name="criterio">
        </div>
        <div class="form-group col-md-4 col-sm-4">
            <label for="ponderacion" class="control-label">Ponderacion</label>
            <input placeholder="%" type="number" class="form-control" id="ponderacion" name="ponderacion">
        </div>

        <div class="form-group col-md-2 col-sm-2">
            <a class="btn btn-warning" onclick="agregarponderacion()">Agregar</a>
        </div>

        <div class="form group col-md-12 col-sm-12">
            <table id="" class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Criterio</th>
                        <th>%</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tEvaluacion">
                </tbody>
            </table>
        </div>

    </div>
    <input hidden="true" name="ponderacion" id="storePonderacion" class="@error('ponderacion')  is-invalid @enderror" value="{{old('ponderacion')}}">

</div>

<div class="form-row">
    <label for="objetivos" class="control-label">Objetivos especificos por tema:</label>
    <textarea placeholder="Objetivos especificos por tema" class="form-control" id="objetivoespecifico" name="objetivoespecifico" cols="15" rows="5"></textarea>
</div>

<div class="form-group col-md-4">
        <label for="transversabilidad" class="control-label">Transversabilidad con otros Cursos </label>
        <input placeholder="Transversabilidad" type="text" class="form-control" id="transversabilidad" name="transversabilidad">
    </div>

<br>
<div class="form-row">
    <div class="form-group col-md-3 col-sm-6">
        <label for="contenidotematico" class="control-label">Contenido Tematico</label>
        <input placeholder="Contenido Tematico" type="text" class="form-control" id="contenidotematico" name="contenidotematico" >
    </div>
    <div class="form-group col-md-3 col-sm-6">
        <label for="estrategiadidactica" class="control-label">Estrategia Didactica</label>
        <input placeholder="Contenido Tematico" type="text" class="form-control" id="estrategiadidactica" name="estrategiadidactica" >
    </div>
    <div class="form-group col-md-3 col-sm-6">
        <label for="procesoevaluacion" class="control-label">Proceso Evaluacion</label>
        <input placeholder="Proceso Evaluacion" type="text" class="form-control" id="procesoevaluacion" name="procesoevaluacion" >
    </div>
    <div class="form-group col-md-2 col-sm-6">
        <label for="duracion" class="control-label">Duracion</label>
        <input placeholder="Duracion" type="text" class="form-control" id="duracionT" name="duracionT" >
    </div>
    <div class="form-group col-md-2 col-sm-6">
        <label for="contenidoExtra" class="control-label">Contenido Extra</label>
        <input placeholder="Duracion" type="text" class="form-control" id="contenidoExtra" name="contenidoExtra" >
    </div>
    <div class="form-group col-md-1 col-sm-2">
        <a class="btn btn-warning" onclick="agregarContenidoT()">Agregar</a>
    </div>

</div>
<div class="form-row">
    <div class="form group col-md-12 col-sm-12">
        <table id="" class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Contenido Tematico</th>
                    <th>Estrategia Didactica</th>
                    <th>Proceso Evaluacion</th>
                    <th>Duracion</th>
                    <th>Contenido Extra</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tTemario">
            </tbody>
        </table>
    </div>
</div>
<input hidden ="true" name="contenidoT" id="storeContenidoT" class="@error('contenidoT')  is-invalid @enderror" >

<br>
<div class="form-row">
    <label for="objetivos" class="control-label">Observaciones:</label>
    <textarea placeholder="Observaciones" class="form-control" id="observaciones" name="observaciones" cols="15" rows="5"></textarea>
</div>
<br>

<div class="form-row">
    <div class="form-group col-md-3 col-sm-6">
        <label for="elementoapoyo" class="control-label">Elementos de Apoyo</label>
        <input placeholder="Elementos de Apoyo" type="text" class="form-control" id="elementoapoyo" name="elementoapoyo" >
    </div>
    <div class="form-group col-md-3 col-sm-6">
        <label for="auxenseñanza" class="control-label">Auxiliares de la enseñanza</label>
        <input placeholder="Auxiliares de le enseñanza" type="text" class="form-control" id="auxenseñanza" name="auxenseñanza" >
    </div>
    <div class="form-group col-md-3 col-sm-6">
        <label for="referencias" class="control-label">Referencias</label>
        <input placeholder="Proceso Evaluacion" type="text" class="form-control" id="referencias" name="referencias" >
    </div>
    <div class="form-group col-md-1 col-sm-2">
        <a class="btn btn-warning" onclick="agregarRecursosD()">Agregar</a>
    </div>

</div>
<div class="form-row">
    <div class="form group col-md-12 col-sm-12">
        <table id="" class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Elementos de Apoyo</th>
                    <th>Auxiliares de la enseñanzas</th>
                    <th>Referecias</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tRecursosD">
            </tbody>
        </table>
    </div>
</div>

<input hidden ="true" name="recursosD" id="storeRecursosD" class="@error('recursosD')  is-invalid @enderror" >