<?php
/**
 * Elaborado por Daniel Méndez Cruz v.1.0
 */
namespace App\Http\Controllers\webController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\curso;
use App\Models\especialidad;
use App\Models\Area;
use App\Models\tbl_unidades;

class CursosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = curso::SELECT('cursos.id', 'cursos.nombre_curso', 'cursos.modalidad', 'cursos.horas', 'cursos.horas', 'cursos.clasificacion', 'cursos.costo',
        'cursos.duracion', 'cursos.objetivo', 'cursos.perfil', 'cursos.solicitud_autorizacion',
        'cursos.fecha_validacion', 'cursos.memo_validacion', 'cursos.memo_actualizacion', 'cursos.fecha_actualizacion', 'cursos.unidad_amovil', 'especialidades.nombre')
        ->WHERE('cursos.id', '!=', '0')
        ->LEFTJOIN('especialidades', 'especialidades.id', '=', 'cursos.id_especialidad')->GET();
        return view('layouts.pages.vstacursosinicio',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $especialidad = new especialidad();
        $especialidades = $especialidad->all();
        $unidades = new tbl_unidades();
        $unidadesMoviles = $unidades->SELECT('ubicacion')->GROUPBY('ubicacion')->GET();
        $area = new Area();
        $areas = $area->all();
        // mostramos el formulario de cursos
        return view('layouts.pages.frmcursos', compact('especialidades', 'areas', 'unidadesMoviles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            //validación de archivos

            $cursos = new curso;
            $cursos->nombre_curso = trim($request->nombrecurso);
            $cursos->modalidad = trim($request->modalidad);
            $cursos->clasificacion = trim($request->clasificacion);
            $cursos->costo = trim($request->costo);
            $cursos->horas = trim($request->duracion);
            $cursos->objetivo = trim($request->objetivo);
            $cursos->perfil = trim($request->perfil);
            $cursos->fecha_validacion = $cursos->setFechaAttribute($request->fecha_validacion);
            $cursos->fecha_actualizacion = $cursos->setFechaAttribute($request->fecha_actualizacion);
            $cursos->descripcion = trim($request->descripcionCurso);
            $cursos->no_convenio = trim($request->no_convenio);
            $cursos->id_especialidad = $request->especialidadCurso;
            $cursos->unidad_amovil = trim($request->unidad_accion_movil);
            $cursos->area = $request->areaCursos;
            $cursos->solicitud_autorizacion = $request->solicitud_autorizacion;
            $cursos->memo_actualizacion = trim($request->memo_actualizacion);
            $cursos->memo_validacion = trim($request->memo_validacion);
            $cursos->cambios_especialidad = trim($request->cambios_especialidad);
            $cursos->nivel_estudio = trim($request->nivel_estudio);
            $cursos->categoria = trim($request->categoria);
            $cursos->tipo_cursos = $request->tipo_curso;
            $cursos->save();

            # ==================================
            # Aquí tenemos el id recién guardado
            # ==================================
            $cursosId = $cursos->id;

            // validamos si hay archivos
            if ($request->hasFile('documento_solicitud_autorizacion')) {
                # Carga el archivo y obtener la url
                $documento_solicitud_autorizacion = $request->file('documento_solicitud_autorizacion'); # obtenemos el archivo
                $url_solicitud_autorizacion = $this->uploaded_file($documento_solicitud_autorizacion, $cursosId, 'documento_solicitud_autorizacion'); #invocamos el método
                // guardamos en la base de datos
                $cursoUpdate = curso::find($cursosId);
                $cursoUpdate->documento_solicitud_autorizacion = $url_solicitud_autorizacion;
                $cursoUpdate->save();
            }

            // validamos el siguiente archivo
            if ($request->hasFile('documento_memo_validacion')) {
                # Carga el archivo y obtener la url
                $documento_memo_validacion = $request->file('documento_memo_validacion'); # obtenemos el archivo
                $url_memo_validacion = $this->uploaded_file($documento_memo_validacion, $cursosId, 'documento_memo_validacion'); #invocamos el método
                // guardamos en la base de datos
                $cursoUp = curso::find($cursosId);
                $cursoUp->documento_memo_validacion = $url_memo_validacion;
                $cursoUp->save();
            }

            // validamos el siguiente archivo
            if ($request->hasFile('documento_memo_actualizacion')) {
                # Carga el archivo y obtener la url
                $documento_memo_actualizacion = $request->file('documento_memo_actualizacion'); # obtenemos el archivo
                $url_memo_actualizacion = $this->uploaded_file($documento_memo_actualizacion, $cursosId, 'documento_memo_actualizacion'); #invocamos el método
                // guardamos en la base de datos
                $cursoU = curso::find($cursosId);
                $cursoU->documento_memo_actualizacion = $url_memo_actualizacion;
                $cursoU->save();
            }

            return redirect()->route('curso-inicio')->with('success', 'Nuevo Curso Agregado!');
        } catch (Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        try {
            //consulta sql
            $area = new Area();
            $areas = $area->all();

            $Especialidad = new especialidad();
            $especialidades = $Especialidad->all();
            $unidades = new tbl_unidades();
            $unidadesMoviles = $unidades->SELECT('ubicacion')->GROUPBY('ubicacion')->GET();

            $idCurso = base64_decode($id);
            $curso = new curso();
            $cursos = $curso::SELECT('cursos.id','cursos.nombre_curso','cursos.modalidad','cursos.horas','cursos.clasificacion',
                    'cursos.costo','cursos.duracion','cursos.tipo_curso',
                    'cursos.objetivo','cursos.perfil','cursos.solicitud_autorizacion','cursos.fecha_validacion','cursos.memo_validacion',
                    'cursos.memo_actualizacion','cursos.fecha_actualizacion','cursos.unidad_amovil','cursos.descripcion','cursos.no_convenio',
                    'especialidades.nombre AS especialidad', 'cursos.id_especialidad',
                    'cursos.area', 'cursos.cambios_especialidad', 'cursos.nivel_estudio', 'cursos.categoria', 'cursos.documento_memo_validacion',
                    'cursos.documento_memo_actualizacion', 'cursos.documento_solicitud_autorizacion')
                    ->WHERE('cursos.id', '=', $idCurso)
                    ->LEFTJOIN('especialidades', 'especialidades.id', '=' , 'cursos.id_especialidad')
                    ->GET();

            $fechaVal = $curso->getMyDateFormat($cursos[0]->fecha_validacion);
            $fechaAct = $curso->getMyDateFormat($cursos[0]->fecha_actualizacion);

            return view('layouts.pages.frmedit_curso', compact('cursos', 'areas', 'especialidades', 'fechaVal', 'fechaAct', 'unidadesMoviles'));

        } catch (\Throwable $th) {
            //throw $th;
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    protected function get_by_area($idAreas)
    {
        if (isset($idAreas)){
            /*Aquí si hace falta habrá que incluir la clase municipios con include*/
            $idAreas = $idAreas;
            $Especialidad = new especialidad();

            $Especialidades = $Especialidad->WHERE('id_areas', '=', $idAreas)->GET();

            /*Usamos un nuevo método que habremos creado en la clase municipio: getByDepartamento*/
            $json=json_encode($Especialidades);
        }else{
            $json=json_encode(array('error'=>'No se recibió un valor de id de Especialidad para filtar'));
        }

        return $json;
    }

    protected function get_by_id($idCurso)
    {
        if (isset($idCurso)) {
            # code...
            $cursos = new curso();
            $curso = $cursos::SELECT('cursos.id','cursos.nombre_curso','cursos.modalidad','cursos.horas','cursos.clasificacion',
                    'cursos.costo','cursos.duracion',
                    'cursos.objetivo','cursos.perfil','cursos.solicitud_autorizacion','cursos.fecha_validacion','cursos.memo_validacion',
                    'cursos.memo_actualizacion','cursos.fecha_actualizacion','cursos.unidad_amovil','cursos.descripcion','cursos.no_convenio',
                    'especialidades.nombre AS especialidad',
                    'cursos.area', 'cursos.cambios_especialidad', 'cursos.nivel_estudio', 'cursos.categoria',
                    'cursos.documento_memo_validacion',
                    'cursos.documento_memo_actualizacion', 'cursos.documento_solicitud_autorizacion')
                    ->WHERE('cursos.id', '=', $idCurso)
                    ->LEFTJOIN('especialidades', 'especialidades.id', '=' , 'cursos.id_especialidad')
                    ->GET();

            $json= response()->json($curso, 200);
        } else {
            $json=json_encode(array('error'=>'No se recibió un valor de id de Curso para filtar'));
        }
        return $json;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // modificacion de un recurso guardado
        if (isset($id)) {
            $cursos = new curso();
            # code...
            $array = [
                'nombre_curso' => trim($request->nombrecurso),
                'modalidad' => trim($request->modalidad),
                'horas' => trim($request->duracion),
                'clasificacion' => trim($request->clasificacion),
                'costo' => trim($request->costo),
                'objetivo' => trim($request->objetivo),
                'perfil' => trim($request->perfil),
                'fecha_validacion' => $cursos->setFechaAttribute($request->fecha_validacion),
                'fecha_actualizacion' => $cursos->setFechaAttribute($request->fecha_actualizacion),
                'descripcion' => trim($request->descripcionCurso),
                'no_convenio' => trim($request->no_convenio),
                'id_especialidad' => trim($request->especialidadCurso),
                'unidad_amovil' => trim($request->unidad_accion_movil),
                'area' => $request->areaCursos,
                'solicitud_autorizacion' => (isset($request->solicitud_autorizacion)) ? $request->solicitud_autorizacion : false,
                'memo_actualizacion' => trim($request->memo_actualizacion),
                'memo_validacion' => trim($request->memo_validacion),
                'cambios_especialidad' => trim($request->cambios_especialidad),
                'nivel_estudio' => trim($request->nivel_estudio),
                'categoria' => trim($request->categoria),
                'tipo_curso' => trim($request->tipo_curso)
            ];

            $cursos->WHERE('id', '=', $id)->UPDATE($array);
            # ==================================
            # Aquí modificamos el curso con id
            # ==================================

            // validamos si hay archivos
            if ($request->hasFile('documento_solicitud_autorizacion')) {
                // obtenemos el valor de documento_solicitud_autorizacion
                $cursos = new curso();
                $curso = $cursos->WHERE('id', '=', $id)->GET();
                // checamos que no sea nulo
                if (!is_null($curso[0]->documento_solicitud_autorizacion)) {
                    # si no está nulo
                    $docSolicitudAutorizacion = explode("/",$curso[0]->documento_solicitud_autorizacion, 5);
                    //dd($docSolicitudAutorizacion[4]);
                    //dd(Storage::exists($docSolicitudAutorizacion[4]));
                    if (Storage::exists($docSolicitudAutorizacion[4])) {
                        # checamos si hay un documento de ser así procedemos a eliminarlo
                        Storage::delete($docSolicitudAutorizacion[4]);
                    }
                }

                # Carga el archivo y obtener la url
                $documento_solicitud_autorizacion = $request->file('documento_solicitud_autorizacion'); # obtenemos el archivo
                $url_solicitud_autorizacion = $this->uploaded_file($documento_solicitud_autorizacion, $id, 'documento_solicitud_autorizacion_update'); #invocamos el método
                // guardamos en la base de datos
                $cursoUpdate = curso::find($id);
                $cursoUpdate->documento_solicitud_autorizacion = $url_solicitud_autorizacion;
                $cursoUpdate->update([
                    'documento_solicitud_autorizacion' => $url_solicitud_autorizacion
                ]);
            }

            // validamos el siguiente archivo
            if ($request->hasFile('documento_memo_validacion')) {
                # Carga el archivo y obtener la url
                $cursos = new curso();
                $curso = $cursos->WHERE('id', '=', $id)->GET();

                if (!is_null($curso[0]->documento_memo_validacion)) {
                    # si no está nulo
                    $docMemoValidacion = explode("/",$curso[0]->documento_memo_validacion, 5);
                    // validación de documento en el servidor
                    if (Storage::exists($docMemoValidacion[4])) {
                        # checamos si hay un documento de ser así procedemos a eliminarlo
                        Storage::delete($docMemoValidacion[4]);
                    }
                }

                $documento_memo_validacion = $request->file('documento_memo_validacion'); # obtenemos el archivo
                $url_memo_validacion = $this->uploaded_file($documento_memo_validacion, $id, 'documento_memo_validacion_update'); #invocamos el método
                // guardamos en la base de datos
                $cursoUp = curso::find($id);
                $cursoUp->documento_memo_validacion = $url_memo_validacion;
                $cursoUp->update([
                    'documento_memo_validacion' => $url_memo_validacion
                ]);
            }

            // validamos el siguiente archivo
            if ($request->hasFile('documento_memo_actualizacion')) {
                # Carga el archivo y obtener la url
                $cursos = new curso();
                $curso = $cursos->WHERE('id', '=', $id)->GET();
                if (!is_null($curso[0]->documento_memo_actualizacion)) {
                    # si no está nulo
                    $docMemoActualizacion = explode("/", $curso[0]->documento_memo_actualizacion, 5);
                    // validación de documento en el servidor
                    if (Storage::exists($docMemoActualizacion[4])) {
                        # checamos si hay un documento de ser así procedemos a eliminarlo
                        Storage::delete($docMemoActualizacion[4]);
                    }
                }

                $documento_memo_actualizacion = $request->file('documento_memo_actualizacion'); # obtenemos el archivo
                $url_memo_actualizacion = $this->uploaded_file($documento_memo_actualizacion, $id, 'documento_memo_actualizacion_update'); #invocamos el método
                // guardamos en la base de datos
                $cursoU = curso::find($id);
                $cursoU->documento_memo_actualizacion = $url_memo_actualizacion;
                $cursoU->update([
                    'documento_memo_actualizacion' => $url_memo_actualizacion
                ]);
            }

            $nombreCurso = $request->nombrecurso;
            return redirect()->route('curso-inicio')
                    ->with('success', sprintf('CURSO %s  ACTUALIZADO EXTIOSAMENTE!', $nombreCurso));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function uploaded_file($file, $id, $name)
    {
        $tamanio = $file->getClientSize(); #obtener el tamaño del archivo del cliente
        $extensionFile = $file->getClientOriginalExtension(); // extension de la imagen
        # nuevo nombre del archivo
        $documentFile = trim($name."_".date('YmdHis')."_".$id.".".$extensionFile);
        $file->storeAs('/uploadFiles/cursos/'.$id, $documentFile); // guardamos el archivo en la carpeta storage
        $documentUrl = Storage::url('/uploadFiles/cursos/'.$id."/".$documentFile); // obtenemos la url donde se encuentra el archivo almacenado en el servidor.
        return $documentUrl;
    }
}
