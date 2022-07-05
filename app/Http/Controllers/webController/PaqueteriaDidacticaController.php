<?php

namespace App\Http\Controllers\webController;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\curso;
use App\Models\PaqueteriasDidacticas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaqueteriaDidacticaController extends Controller
{
    //
    public function index($idCurso)
    {
        $curso = new curso();
        $curso=$curso::SELECT('cursos.id','cursos.estado','cursos.nombre_curso','cursos.modalidad','cursos.horas','cursos.clasificacion',
        'cursos.costo','cursos.duracion','cursos.tipo_curso','cursos.documento_memo_validacion','cursos.documento_memo_actualizacion','cursos.documento_solicitud_autorizacion',
        'cursos.objetivo','cursos.perfil','cursos.solicitud_autorizacion','cursos.fecha_validacion','cursos.memo_validacion',
        'cursos.memo_actualizacion','cursos.fecha_actualizacion','cursos.unidad_amovil','cursos.descripcion','cursos.no_convenio',
        'especialidades.nombre AS especialidad', 'cursos.id_especialidad',
                    'cursos.area', 'cursos.cambios_especialidad', 'cursos.nivel_estudio', 'cursos.categoria', 'cursos.documento_memo_validacion',
                    'cursos.documento_memo_actualizacion', 'cursos.documento_solicitud_autorizacion',
                    'cursos.rango_criterio_pago_minimo', 'rango_criterio_pago_maximo','cursos.observacion',
                    'cursos.grupo_vulnerable', 'cursos.dependencia')
                    ->WHERE('cursos.id', '=', $idCurso)
                    ->LEFTJOIN('especialidades', 'especialidades.id', '=' , 'cursos.id_especialidad')
                    ->first();
                    
        $area = Area::find($curso->area);
        
        $paqueterias = PaqueteriasDidacticas::toBase()->where([['id_curso', $idCurso], ['estatus', 1]])->first();
        $cartaDescriptiva = [];
        $contenidoT = [];
        $evaluacionAlumno = [];
        if (isset($paqueterias)) {
            $cartaDescriptiva = json_decode($paqueterias->carta_descriptiva);
            $contenidoT = json_decode($cartaDescriptiva->contenidoTematico);
            $evaluacionAlumno = ($paqueterias->eval_alumno);
            

            
        }
        return view('layouts.pages.paqueteriasDidacticas.paqueterias_didacticas', compact('idCurso', 'curso', 'area' ,'paqueterias', 'cartaDescriptiva', 'contenidoT', 'evaluacionAlumno'));
    }

    public function store(Request $request, $idCurso)
    {
        

        $this->validate($request, [
            'entidadfederativa' => 'required',
            'cicloescolar' => 'required',
            'programaestrategico' => 'required',
        ]);

        $preguntas = ['instrucciones' => $request->instrucciones];

        $curso = new curso();
        $curso=$curso::SELECT('cursos.id','cursos.estado','cursos.nombre_curso','cursos.modalidad','cursos.horas','cursos.clasificacion',
                    'cursos.costo','cursos.duracion','cursos.tipo_curso','cursos.documento_memo_validacion','cursos.documento_memo_actualizacion','cursos.documento_solicitud_autorizacion',
                    'cursos.objetivo','cursos.perfil','cursos.solicitud_autorizacion','cursos.fecha_validacion','cursos.memo_validacion',
                    'cursos.memo_actualizacion','cursos.fecha_actualizacion','cursos.unidad_amovil','cursos.descripcion','cursos.no_convenio',
                    'especialidades.nombre AS especialidad', 'cursos.id_especialidad',
                    'cursos.area', 'cursos.cambios_especialidad', 'cursos.nivel_estudio', 'cursos.categoria', 'cursos.documento_memo_validacion',
                    'cursos.documento_memo_actualizacion', 'cursos.documento_solicitud_autorizacion',
                    'cursos.rango_criterio_pago_minimo', 'rango_criterio_pago_maximo','cursos.observacion',
                    'cursos.grupo_vulnerable', 'cursos.dependencia')
                    ->WHERE('cursos.id', '=', $idCurso)
                    ->LEFTJOIN('especialidades', 'especialidades.id', '=' , 'cursos.id_especialidad')
                    ->first();
        $area = Area::find($curso->area);
        $cartaDescriptiva = [
            'nombrecurso' => $curso->nombre_curso,
            'entidadfederativa' => $request->entidadfederativa,
            'cicloescolar' => $request->cicloescolar,
            'programaestrategico' => $request->programaestrategico,
            'modalidad' => $curso->modalidad,
            'tipo' => $curso->tipo_curso,
            'perfilidoneo' => $curso->perfil,
            'duracion' => $curso->horas,
            'formacionlaboral' => $area->formacion_profesional,
            'especialidad' => $curso->especialidad,
            'publico' => $request->publico,
            'aprendizajeesperado' => $request->aprendizajeesperado,
            'criterio' => $request->criterio,
            'ponderacion' => $request->ponderacion,
            'objetivoespecifico' => $request->objetivoespecifico,
            'transversabilidad' => $request->transversabilidad,
            'contenidoTematico' => $request->contenidoT,
            'observaciones' => $request->observaciones,
            'elementoapoyo' => $request->elementoapoyo,
            'auxenseñanza' => $request->auxenseñanza,
            'referencias' => $request->referencias,
        ];

        
        
        
        $i = 0;
        $contPreguntas = 0;

        $auxContPreguntas = $request->numPreguntas;

        while (true) { //ciclo para encontrar las preguntas del formulario
            $i++;
            if ($contPreguntas == $auxContPreguntas-1)
                break;

            $numPregunta = 'pregunta' . $i;
            $tipoPregunta = 'pregunta' . $i . '-tipo';
            $opcPregunta = 'pregunta' . $i . '-opc';
            $respuesta = 'pregunta' . $i . '-opc-answer';

            $contenidoT = 'pregunta' . $i . '-contenidoT';

            if ($request->$numPregunta != null) {
                if ($request->$tipoPregunta == 'multiple') {
                    $tempPregunta = [
                        'descripcion' => $request->$numPregunta,
                        'tipo' => $request->$tipoPregunta,
                        'opciones' => $request->$opcPregunta,
                        'respuesta' => $request->$respuesta,
                        'contenidoTematico' => $request->$contenidoT,
                    ];
                } else {
                    $respuesta = 'pregunta' . $i . '-resp-abierta';
                    $tempPregunta = [
                        'descripcion' => $request->$numPregunta,
                        'tipo' => $request->$tipoPregunta,
                        'opciones' => $request->$opcPregunta,
                        'respuesta' => $request->$respuesta,
                        'contenidoTematico' => $request->$contenidoT,
                    ];
                }
                array_push($preguntas, $tempPregunta);
                $contPreguntas++;
            }
        }


        DB::beginTransaction();
        try {
            $paqueteriasDidacticas = PaqueteriasDidacticas::toBase()->where([['id_curso', $idCurso], ['estatus', 1]])->first();
            
            if (isset($paqueteriasDidacticas)) {
                DB::table('paqueterias_didacticas')
                ->where('id_curso', $idCurso)
                ->update([
                    'carta_descriptiva' => json_encode($cartaDescriptiva),
                    'eval_alumno' => json_encode($preguntas),
                    'updated_at' => Carbon::now(),
                    'id_user_updated' => Auth::id()
                ]);
            } else {
                PaqueteriasDidacticas::create([
                    'id_curso' => $idCurso,
                    'carta_descriptiva' => json_encode($cartaDescriptiva),
                    'eval_alumno' => json_encode($preguntas),
                    'estatus' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                    'id_user_created' => Auth::id(),
                ]);
            }
            DB::commit();
            return redirect()->route('curso-inicio')->with('success', 'SE HA GUARDADO LA PAQUETERIA DIDACTICA!');
        } catch (\Exception $e) {
            throw $e;
            DB::rollback();

            return redirect()->route('curso-inicio')->with('error', 'HUBO UN ERROR AL GUARDAR LA PAQUETERIA DIDACTICA!');
        }
    }

    function uploadImg(Request $request)
    {
        $archivo = $request->file('upload') ?? null;
        $nombre = $archivo->getClientOriginalName();
        $destino = 'storage/img/paqueterias';


        $url = $request->upload->move($destino, $nombre);

        return response()->json([
            'url' => $url
        ]);
    }

    public function buscadorEspecialidades(Request $request)
    {
        $especialidades = DB::table('especialidades')
            ->where('nombre', 'like', '%' . $request->especialidad . '%')
            ->get();
        return response()->json($especialidades);
    }


    public function DescargarPaqueteria($idCurso)
    {
        $paqueteriasDidacticas = PaqueteriasDidacticas::toBase()->where([['id_curso', $idCurso], ['estatus', 1]])->first();
        
        // 
        $cartaDescriptiva = json_decode($paqueteriasDidacticas->carta_descriptiva);


        $cartaDescriptiva->ponderacion = json_decode($cartaDescriptiva->ponderacion);
        $cartaDescriptiva->contenidoTematico = json_decode($cartaDescriptiva->contenidoTematico);


        $curso = curso::toBase()->where('id', $idCurso)->first();

        $pdf = \PDF::loadView('layouts.pages.paqueteriasDidacticas.pdf.cartaDescriptiva', compact('cartaDescriptiva'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('paqueteriaDidactica.pdf');
    }
    public function DescargarPaqueteriaEvalAlumno($idCurso)
    {
        $paqueteriasDidacticas = PaqueteriasDidacticas::toBase()->where([['id_curso', $idCurso], ['estatus', 1]])->first();
        $cartaDescriptiva = json_decode($paqueteriasDidacticas->carta_descriptiva);
        $evalAlumno = json_decode($paqueteriasDidacticas->eval_alumno);
        $curso = curso::toBase()->where('id', $idCurso)->first();
        $abecedario = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'Ñ', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $pdf = \PDF::loadView('layouts.pages.paqueteriasDidacticas.pdf.eval_alumno_pdf', compact('evalAlumno', 'abecedario', 'curso', 'cartaDescriptiva'));

        return $pdf->stream('EvaluacionAlumno.pdf');
    }

    public function DescargarPaqueteriaEvalInstructor()
    {
        $pdf = \PDF::loadView('layouts.pages.paqueteriasDidacticas.pdf.evaInstructorCurso_pdf');
        return $pdf->stream('evaluacionInstructor');
    }
    public function DescargarManualDidactico($idCurso)
    {
        $curso = curso::toBase()->where('id', $idCurso)->first();
        $paqueterias = PaqueteriasDidacticas::toBase()->where([['id_curso', $idCurso], ['estatus', 1]])->first();
        
        $pdf = \PDF::loadView('layouts.pages.paqueteriasDidacticas.pdf.manualDidactico_pdf', compact('curso', 'paqueterias'));
        return $pdf->stream('manualDidactico');
    }
    
}
