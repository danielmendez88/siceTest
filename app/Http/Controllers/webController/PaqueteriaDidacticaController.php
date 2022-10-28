<?php

namespace App\Http\Controllers\webController;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\curso;
use App\Models\CursoTemp;
use App\Models\ImgPaqueterias;
use App\Models\PaqueteriasDidacticas;
use App\Models\Unidad;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class PaqueteriaDidacticaController extends Controller
{
    public function buzon(Request $request)
    {
        $buscar_curso = $request->get('busquedaPorCurso');
        $tipoCurso = $request->get('tipo_curso');

        $unidadUser = Auth::user()->unidad;

        $userId = Auth::user()->id;

        $roles = DB::table('role_user')
            ->LEFTJOIN('roles', 'roles.id', '=', 'role_user.role_id')
            ->SELECT('roles.slug AS role_name')
            ->WHERE('role_user.user_id', '=', $userId)
            ->GET();

        if($roles[0]->role_name == 'admin' || $roles[0]->role_name == 'auxiliar_paqueteias-todos' || $roles[0]->role_name == 'titular-innovacion')
        {
        $data = curso::searchporcurso($tipoCurso, $buscar_curso)->WHERE('cursos.id', '!=', '0')
        ->LEFTJOIN('especialidades', 'especialidades.id', '=', 'cursos.id_especialidad')
        ->PAGINATE(25, ['cursos.id', 'cursos.nombre_curso', 'cursos.modalidad', 'cursos.horas', 'cursos.clasificacion',
                   'cursos.costo', 'cursos.objetivo', 'cursos.perfil', 'cursos.solicitud_autorizacion',
                   'cursos.fecha_validacion', 'cursos.memo_validacion', 'cursos.memo_actualizacion',
                   'cursos.fecha_actualizacion', 'cursos.unidad_amovil', 'especialidades.nombre',
                   'cursos.tipo_curso', 'cursos.rango_criterio_pago_minimo', 'cursos.rango_criterio_pago_maximo']);
        }
        else
        {
            $data = curso::searchporcurso($tipoCurso, $buscar_curso)->WHERE('cursos.id', '!=', '0')
            ->WHERE('cursos.estado', '=', true)
            ->LEFTJOIN('especialidades', 'especialidades.id', '=', 'cursos.id_especialidad')
            ->PAGINATE(25, ['cursos.id', 'cursos.nombre_curso', 'cursos.modalidad', 'cursos.horas', 'cursos.clasificacion',
                       'cursos.costo', 'cursos.objetivo', 'cursos.perfil', 'cursos.solicitud_autorizacion',
                       'cursos.fecha_validacion', 'cursos.memo_validacion', 'cursos.memo_actualizacion',
                       'cursos.fecha_actualizacion', 'cursos.unidad_amovil', 'especialidades.nombre',
                       'cursos.tipo_curso', 'cursos.rango_criterio_pago_minimo', 'cursos.rango_criterio_pago_maximo']);
        }
        
        // 'MON-DD-YYYY HH12:MIPM'  2
        $buscar_curso = $request->get('busquedaPorCurso');
        $tipoCurso = $request->get('tipo_curso');
        $cursos = CursoTemp::searchporcurso($tipoCurso, $buscar_curso)->WHERE('active', 1)
            ->LEFTJOIN('especialidades', 'especialidades.id', '=', 'cursos_temp.id_especialidad')
            ->SELECT(
                DB::raw('cursos_temp.id as idCurso'),
                DB::raw('to_char(cursos_temp.updated_at::timestamp,\'TMDay, DD" de "TMMonth" del "YYYY A las HH12:MIPM\') as fecha'),
                DB::raw('to_char(cursos_temp.fecha_u_mod::timestamp,\'TMDay, DD" de "TMMonth" del "YYYY A las HH12:MIPM\') as fechaUmod'),
                DB::raw('*')
            )
            ->PAGINATE(25);

            $rolUser = User::SELECT(
                DB::raw('users.id as userId, users.name as usuario, roles.id as role_id, roles.name, roles.slug'),
            )
            ->WHERE('users.id',Auth::id())
            ->LEFTJOIN('role_user', 'role_user.user_id', '=', 'users.id')
            ->LEFTJOIN('roles', 'roles.id', '=', 'role_user.role_id')
            ->first();
        
            // dd($cursos->toArray(), $rolUser);
        return view('layouts.pages.paqueteriasDidacticas.buzon_paqueterias', compact('cursos','rolUser','data'));
    }

    public function index($idCurso)
    {
        $curso = new CursoTemp();
        $curso = $curso::SELECT(
            DB::raw('cursos_temp.id as idCurso'),
                DB::raw('to_char(cursos_temp.updated_at::timestamp,\'TMDay, DD" de "TMMonth" del "YYYY\') as fecha'),
                DB::raw('*')
        )
            ->WHERE('cursos_temp.id', '=', $idCurso)
            ->LEFTJOIN('especialidades', 'especialidades.id', '=', 'cursos_temp.id_especialidad')
            ->first();
        $area = Area::find($curso->area);

        $cartaDescriptiva = [
            'nombrecurso' => $curso->nombre_curso,
            'entidadfederativa' => '',
            'cicloescolar' => '',
            'programaestrategico' => '',
            'modalidad' => $curso->modalidad,
            'tipo' => $curso->tipo_curso,
            'perfilidoneo' => $curso->perfil,
            'duracion' => $curso->horas,
            'formacionlaboral' => $area->formacion_profesional,
            'especialidad' => $curso->especialidad,
            'publico' => '',
            'aprendizajeesperado' => '',
            'criterio' => '',
            'ponderacion' => '',
            'objetivoespecifico' => '',
            'transversabilidad' => '',
            'contenidoTematico' => '',
            'observaciones' => '',
            'elementoapoyo' => '',
            'auxenseñanza' => '',
            'referencias' => '',
        ];

        DB::beginTransaction();
        try { //se guarda la informacion inicial de la paqueteria
            $paqueteriasDidacticas = CursoTemp::toBase()->where([['id', $idCurso], ['active', 1]])->first();
            
            if (!isset($paqueteriasDidacticas)) {
                DB::table('cursos_temp')
                ->where('id', $idCurso)
                ->update([
                    'carta_descriptiva' => json_encode($cartaDescriptiva),
                    'eval_alumno' => json_encode(''),
                    
                    'active' => true,
                    'updated_at' => Carbon::now(),
                    'fecha_alta' => Carbon::now(), 
                    'id_user_created' => Auth::id(),
                ]);
                
            }
            DB::commit();
        } catch (\Exception $e) {
            
            DB::rollback();
            return redirect()->route('curso-inicio')->with('error', 'HUBO UN ERROR INESPERADO!');
        }
        $cartaDescriptiva = [];
        $contenidoT = [];
        $evaluacionAlumno = [];
        $instrucciones = '';
        // dd(gettype($evaluacionAlumno));
        if (isset($paqueteriasDidacticas)) {
            
            $cartaDescriptiva = json_decode($paqueteriasDidacticas->carta_descriptiva);
            $contenidoT = json_decode($cartaDescriptiva->contenidoTematico ?? '');
            $evaluacionAlumno = json_decode($paqueteriasDidacticas->eval_alumno );
            $instrucciones = $evaluacionAlumno->instrucciones ?? '';
            unset($evaluacionAlumno->instrucciones);
            
        }
        
        $fechaActual = Carbon::now();
        
        
        return view('layouts.pages.paqueteriasDidacticas.paqueterias_didacticas', compact('idCurso', 'curso', 'area', 'paqueteriasDidacticas', 'cartaDescriptiva', 'contenidoT', 'evaluacionAlumno', 'instrucciones', 'fechaActual'));
    }

    public function verPaqueterias($idCurso)
    {
        $curso = CursoTemp::toBase()->where([['id', $idCurso],['active',1]])->first();

        $cartaDescriptiva = json_decode($curso->carta_descriptiva);
        $contenidoT = json_decode($cartaDescriptiva->contenidoTematico ?? '');
        $evaluacionAlumno = ($curso->eval_alumno);
        
        $fechaActual = Carbon::now();
        return view('layouts.pages.paqueteriasDidacticas.blades.validacionPaqueteria', compact('idCurso', 'curso', 'cartaDescriptiva', 'contenidoT', 'evaluacionAlumno', 'fechaActual'));
    }
        
    public function store(Request $request, $idCurso)
    {

        
        
        $urlImagenes = [];
        $preguntas = [];

        $curso = new CursoTemp();
        
        $curso = $curso::SELECT('cursos_temp.id','cursos_temp.estado','cursos_temp.nombre_curso','cursos_temp.modalidad','cursos_temp.horas','cursos_temp.clasificacion','cursos_temp.costo','cursos_temp.duracion','cursos_temp.tipo_curso','cursos_temp.documento_memo_validacion','cursos_temp.documento_memo_actualizacion','cursos_temp.documento_solicitud_autorizacion','cursos_temp.objetivo','cursos_temp.perfil','cursos_temp.solicitud_autorizacion','cursos_temp.fecha_validacion','cursos_temp.memo_validacion','cursos_temp.memo_actualizacion','cursos_temp.fecha_actualizacion','cursos_temp.unidad_amovil','cursos_temp.descripcion','cursos_temp.no_convenio','especialidades.nombre AS especialidad','cursos_temp.id_especialidad','cursos_temp.area','cursos_temp.cambios_especialidad','cursos_temp.nivel_estudio','cursos_temp.categoria','cursos_temp.documento_memo_validacion','cursos_temp.documento_memo_actualizacion','cursos_temp.documento_solicitud_autorizacion','cursos_temp.rango_criterio_pago_minimo','rango_criterio_pago_maximo','cursos_temp.observacion','cursos_temp.grupo_vulnerable',  'cursos_temp.dependencia'
        )
            ->WHERE('cursos_temp.id', '=', $idCurso)
            ->LEFTJOIN('especialidades', 'especialidades.id', '=', 'cursos_temp.id_especialidad')
            ->first();
            
        $area = Area::find($curso->area);
        $cartaDescriptiva = [
            'nombrecurso' => $curso->nombre_curso,
            'entidadfederativa' => $request->entidadfederativa,
            'cicloescolar' => $request->cicloescolar,
            'programaestrategico' => $request->programaestrategico,
            'modalidad' => $curso->modalidad,
            'tipo' => $request->tipo,
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
        
        
        
        if($request->blade === 'evaluacion' || $request->blade === 'ambos' || $request->numPreguntas>0  ){
            $preguntas = ['instrucciones' => $request->instrucciones];
            foreach($request->toArray() as $key => $value) {
                $i++;
                $numPregunta = 'pregunta' . $i;
                $tipoPregunta = 'pregunta' . $i . '-tipo';
                $opcPregunta = 'pregunta' . $i . '-opc';
                $respuesta = 'pregunta' . $i . '-opc-answer';
    
                $contenidoT = 'pregunta' . $i . '-contenidoT';
    
                if($request->$numPregunta){
                    
                    if ($request->$tipoPregunta == 'multiple') {
                        $tempPregunta = [
                            'descripcion' => $request->$numPregunta ?? 'N/A',
                            'tipo' => $request->$tipoPregunta ?? 'N/A',
                            'opciones' => $request->$opcPregunta,
                            'respuesta' => $request->$respuesta ?? 'N/A',
                            'contenidoTematico' => $request->$contenidoT ?? 'N/A',
                        ];
                    } else {
                        $respuesta = 'pregunta' . $i . '-resp-abierta';
                        $tempPregunta = [
                            'descripcion' => $request->$numPregunta ?? 'N/A',
                            'tipo' => $request->$tipoPregunta ?? 'N/A',
                            'opciones' => $request->$opcPregunta,
                            'respuesta' => $request->$respuesta ?? 'N/A',
                            'contenidoTematico' => $request->$contenidoT ?? 'N/A',
                        ];
                    }
                    array_push($preguntas, $tempPregunta);
                    
                }
            }
        }


        DB::beginTransaction();
        try {

            DB::table('cursos_temp')
                ->where('id', $idCurso)
                ->update([
                    'carta_descriptiva' => json_encode($cartaDescriptiva),
                    'eval_alumno' => json_encode($preguntas),
                    'estatus_paqueteria' => 'EN CAPTURA',
                    'active' => true,
                    'tipoSoli' => $request->tipoSoli,
                    'motivoSoli' => $request->motivoSoli,
                    'updated_at' => Carbon::now(),
                    'id_user_updated' => Auth::id(),
                    'fecha_u_mod' => Carbon::now(), 
                ]);


            $cursoTemp = CursoTemp::find($idCurso);
            $cursoHistory = $cursoTemp->replicate();
            $cursoHistory->setTable('cursos_history');
            $cursoHistory->save();

            DB::table('cursos_history')
                ->where('id', $cursoHistory->id)
                ->update([
                    'id_curso' => $idCurso,
                    'movimiento' => 'EN CAPTURA'
                ]);

            DB::commit();
            return redirect()->route('paqueteriasDidacticas',$idCurso)->with('success', 'SE HA GUARDADO LA PAQUETERIA DIDACTICA!');
        } catch (\Exception $e) {
            throw $e;
            DB::rollback();

            return redirect()->route('paqueteriasDidacticas',$idCurso)->with('error', 'HUBO UN ERROR AL GUARDAR LA PAQUETERIA DIDACTICA!');
        }
    }


    public function enviar_pre_validacion(Request $request, $idCurso)
    {
        DB::beginTransaction();
        try {
            DB::table('cursos_temp')
                ->where('id', $idCurso)
                ->update([
                    'tipoSoli' => $request->tipoSoli,
                    'motivoSoli' => $request->motivoSoli,
                    'estatus_paqueteria' => 'ENVIADO A PREVALIDACION',
                    'observaciones' => null,
                    'active' => true,
                    'updated_at' => Carbon::now(),
                    'id_user_updated' => Auth::id()
                ]);


            $cursoTemp = CursoTemp::find($idCurso);
            $cursoHistory = $cursoTemp->replicate();
            $cursoHistory->setTable('cursos_history');
            $cursoHistory->id_curso = $idCurso;
            $cursoHistory->movimiento = 'ENVIADO A PREVALIDACION';
            $cursoHistory->save();


            DB::commit();
            return redirect()->route('buzon.paqueterias')->with('success', 'SE HA GUARDADO LA PAQUETERIA DIDACTICA!');
        } catch (\Exception $e) {
            throw $e;
            DB::rollback();

            return redirect()->route('buzon.paqueterias')->with('error', 'HUBO UN ERROR AL GUARDAR LA PAQUETERIA DIDACTICA!');
        }
    }

    public function retornar_pre_validacion(Request $request, $idCurso)
    {
        DB::beginTransaction();
        
        
        try {
            DB::table('cursos_temp')
                ->where('id', $idCurso)
                ->update([
                    'estatus_paqueteria' => $request->accion,
                    'observaciones' => $request->observaciones ?? '',
                    'active' => true,
                    'updated_at' => Carbon::now(),
                    'fecha_u_mod' => Carbon::now(),
                    'id_user_updated' => Auth::id()
                ]);

            $cursoTemp = CursoTemp::find($idCurso);
            $cursoHistory = $cursoTemp->replicate();
            $cursoHistory->setTable('cursos_history');
            $cursoHistory->id_curso = $idCurso;
            $cursoHistory->movimiento = $request->accion;
            $cursoHistory->save();

            DB::commit();
            return redirect()->route('paqueteriasDidacticas',$idCurso)->with('success', 'SE HA GUARDADO LA PAQUETERIA DIDACTICA!');
        } catch (\Exception $e) {
            throw $e;
            DB::rollback();

            return redirect()->route('curso-inicio')->with('warnining', 'HUBO UN ERROR AL GUARDAR LA PAQUETERIA DIDACTICA!');
        }
    }



    public function buscadorEspecialidades(Request $request)
    {
        $especialidades = DB::table('especialidades')
            ->where('nombre', 'like', '%' . $request->especialidad . '%')
            ->get();
        return response()->json($especialidades);
    }


    public function DescargarPaqueteria(Request $request, $idCurso)
    {
        $paqueteriasDidacticas = CursoTemp::toBase()->where([['id', $idCurso], ['active', 1]])->first();
        if (!isset($paqueteriasDidacticas)) {
            return redirect()->back()->with('warning', 'No se puede generar pdf con la informacion actual');
        }
        
        $cartaDescriptiva = json_decode($paqueteriasDidacticas->carta_descriptiva);
        
        switch($request->paqueteria){
            case 'eval_alumno':
                $evalAlumno = json_decode($paqueteriasDidacticas->eval_alumno);
                if (!isset($evalAlumno) || !isset($paqueteriasDidacticas)) {
                    return redirect()->back()->with('warning', 'No se puede generar pdf con la informacion actual');
                }
                $curso = curso::toBase()->where('id', $idCurso)->first();
                $abecedario = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'Ñ', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
                $pdf = \PDF::loadView('layouts.pages.paqueteriasDidacticas.pdf.eval_alumno_pdf', compact('evalAlumno', 'abecedario', 'curso', 'cartaDescriptiva'));
        
                return $pdf->stream('EvaluacionAlumno.pdf');
                break;

            case 'eval_instructor':
                $pdf = \PDF::loadView('layouts.pages.paqueteriasDidacticas.pdf.evaInstructorCurso_pdf');
                return $pdf->stream('evaluacionInstructor');
                break;
            
            case 'manual_didactico':
                $contenidos = json_decode($cartaDescriptiva->contenidoTematico ?? '');

                if ($contenidos == null)
                    return redirect()->back()->with('warning', 'No se puede generar pdf con la informacion actual');
    
                $info_manual_didactico = [];
                $replace = array(request()->getSchemeAndHttpHost() . '/', '\\');
                foreach ($contenidos as $manual) {
                    $manual->contenidoExtra = str_replace($replace, '', $manual->contenidoExtra);
                }
        
                $curso = curso::toBase()->where('id', $idCurso)->first();
                
                $pdf = \PDF::loadView('layouts.pages.paqueteriasDidacticas.pdf.manualDidactico_pdf', compact('curso', 'paqueteriasDidacticas', 'contenidos', 'cartaDescriptiva'));
                return $pdf->stream('manualDidactico');
                break;

            default:
                $cartaDescriptiva->ponderacion = json_decode($cartaDescriptiva->ponderacion);
                $cartaDescriptiva->contenidoTematico = json_decode($cartaDescriptiva->contenidoTematico);
        
        
                $curso = curso::toBase()->where('id', $idCurso)->first();
        
                $pdf = \PDF::loadView('layouts.pages.paqueteriasDidacticas.pdf.cartaDescriptiva', compact('cartaDescriptiva'));
                $pdf->setPaper('A4', 'landscape');
                return $pdf->stream('paqueteriaDidactica.pdf');
                break;
        }
        
        
    }

   
    public function GenerarSoliValidacionPaqueteria(Request $request, $idCurso)
    {
        
        $memo = $request->memo;
        $curso = CursoTemp::toBase()->where('id', $idCurso)->first();
        $user_created = User::find(Auth::id());
        $today = date("D M d, Y G:i");
        $fecha = Carbon::parse($today);
        $date = $fecha->locale(); //con esto revise que el lenguaje fuera es 
        $fecha_actual = $fecha->day.' de '.$fecha->monthName.' del '. $fecha->year; //y con esta obtengo el mes al fin en español!
        
        $unidad = Unidad::toBase()->where('id',$user_created->unidad)->first();
        
        
        $pdf = \PDF::loadView('layouts.pages.paqueteriasDidacticas.pdf.memo_soli_validacion_paqueteria', compact('curso','user_created', 'fecha_actual', 'unidad', 'memo'));
        return $pdf->stream('Memoramdum Solicitud Validacion de Paqueterias.pdf');
    }
    public function StoreSoliValidacionPaqueteria(Request $request, $idCurso){
        
        if (!$request->hasFile('doc_memo')) {
            return ;
        }
        Validator::make($request->all(), [
            'doc_memo' => 'mimes:pdf|max:10240'
        ]);
        
        $file_memo = $request->file('doc_memo'); 
        DB::beginTransaction();
        try {
            DB::table('cursos_temp')
            ->where('id', $idCurso)
            ->update([
                'estatus_paqueteria' => 'PENDIENTE POR TURNAR',
                'updated_at' => Carbon::now(),
                'id_user_updated' => Auth::id()
            ]);
            $cursoTemp = CursoTemp::find($idCurso);
            $cursoHistory = $cursoTemp->replicate();
            $cursoHistory->setTable('cursos_history');
            $cursoHistory->id_curso = $idCurso;
            $cursoHistory->movimiento = 'PENDIENTE POR TURNAR';
            $cursoHistory->save();


            $this->upload_memo_file($file_memo, $idCurso, 'paqueterias','memo_soli_paqueteria'); 
            DB::commit();
            return redirect()->route('paqueteriasDidacticas',$idCurso)->with('success', 'EL DOCUMENTO SE HA SUBIDO CON EXITO');
            
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return redirect()->route('paqueteriasDidacticas',$idCurso)->with('error', 'HA OCURRIDO UN ERRO AL SUBIR EL DOCUMENTO');
        }
    }
    public function StoreMemoValidacionPaqueteria(Request $request, $idCurso){
        
        if (!$request->hasFile('doc_memo')) {
            return ;
        }
        Validator::make($request->all(), [
            'doc_memo' => 'mimes:pdf|max:10240'
        ]);
        
        $file_memo = $request->file('doc_memo'); 
        DB::beginTransaction();
        try {
            DB::table('cursos_temp')
            ->where('id', $idCurso)
            ->update([
                'estatus_paqueteria' => 'AUTORIZADO',
                'fecha_u_mod' => Carbon::now(),
                'id_user_updated' => Auth::id()
            ]);
            $cursoTemp = CursoTemp::find($idCurso);
            $cursoHistory = $cursoTemp->replicate();
            $cursoHistory->setTable('cursos_history');
            $cursoHistory->id_curso = $idCurso;
            $cursoHistory->movimiento = 'AUTORIZADO';
            $cursoHistory->save();


            $this->upload_memo_file($file_memo, $idCurso, 'paqueterias','memo_validacion_paqueteria'); 
            DB::commit();
            return redirect()->route('paqueteriasDidacticas',$idCurso)->with('success', 'EL DOCUMENTO SE HA SUBIDO CON EXITO');
            
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return redirect()->route('paqueteriasDidacticas',$idCurso)->with('error', 'HA OCURRIDO UN ERRO AL SUBIR EL DOCUMENTO');
        }
    }

    public function GenerarMemoValidacionPaqueteria(Request $request, $idCurso){

        
        $memo = $request->memo;
        $curso = CursoTemp::toBase()->where('id', $idCurso)->first();
        
        $user_created = User::find(Auth::id());
        $today = date("D M d, Y G:i");
        $fecha = Carbon::parse($today);
        $date = $fecha->locale(); //con esto revise que el lenguaje fuera es 
        $fecha_actual = $fecha->day.' de '.$fecha->monthName.' del '. $fecha->year; //y con esta obtengo el mes al fin en español!
        
        $unidad = Unidad::toBase()->where('id',$user_created->unidad)->first();
        
        $carta_descriptiva = json_decode($curso->carta_descriptiva);
        
        $pdf = \PDF::loadView('layouts.pages.paqueteriasDidacticas.pdf.memo_validacion_paqueteria', compact('curso','user_created', 'fecha_actual', 'unidad', 'memo', 'carta_descriptiva'));
        return $pdf->stream('Memoramdum Validacion de Paqueterias.pdf');
    }

    protected function upload_memo_file($file, $idCurso, $subpath, $tipo) {
        
        $extensionFile = $file->getClientOriginalExtension(); 
        if($extensionFile == '') 
            $extensionFile = 'pdf';
        
        $documentFile = trim($tipo.".".$extensionFile);
        $path = '/'.$subpath.'/id_curso_'.$idCurso.'/'.$documentFile;
        Storage::disk('custom_folder_1')->put($path, file_get_contents($file));
        $documentUrl = Storage::disk('custom_folder_1')->url('/uploadFiles'.$path); // obtenemos la url donde se encuentra el archivo almacenado en el servidor.
        return $documentUrl;
    }

    protected function downloadSoliValidacionPaqueteria($idCurso){
        $path = Storage::disk('custom_folder_1')->getAdapter()->getPathPrefix();
        $archivo_memo = '/paqueterias/id_curso_'.$idCurso.'/memo_soli_paqueteria.pdf';
        $path = $path.''.$archivo_memo;
        
        // dd(Storage::disk('custom_folder_1')->getAdapter()->getPathPrefix());
        return response()->file($path);
        
        if (Storage::exists($archivo_memo)) {
            dd('exist');
        }else{
            return response()->json('doesntExist');
        }
    }
    public function TurnarDta($idCurso){
        DB::beginTransaction();
        try {
            DB::table('cursos_temp')
                ->where('id', $idCurso)
                ->update([                   
                    'estatus_paqueteria' => 'TURNADO A DTA',
                    'updated_at' => Carbon::now(),
                    'id_user_updated' => Auth::id()
                ]);


            $cursoTemp = CursoTemp::find($idCurso);
            $cursoHistory = $cursoTemp->replicate();
            $cursoHistory->setTable('cursos_history');
            $cursoHistory->id_curso = $idCurso;
            $cursoHistory->movimiento = 'TURNADO A DTA';
            $cursoHistory->save();


            DB::commit();
            return redirect()->route('buzon.paqueterias')->with('success', 'SE HA TURNADO A DTA!');
        } catch (\Exception $e) {
            throw $e;
            DB::rollback();
            return redirect()->route('buzon.paqueterias')->with('error', 'HUBO UN ERROR AL TURNAR LA SOLICITUD!');
        }

        $curso = curso::toBase()->where('id', $idCurso)->first();
        $pdf = \PDF::loadView('layouts.pages.paqueteriasDidacticas.pdf.manualDidactico_pdf', compact('curso', 'paqueteriasDidacticas','contenidos', 'carta_descriptiva'));
        return $pdf->stream('manualDidactico');
    }

    public function upload(Request $request)
    {
      
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo(Str::random(10), PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '.' . $extension;
            // dump($fileName, $originName, $extension, $request->file('upload'));

            $request->file('upload')->move(public_path('images/paqueterias/id_curso_'.$request->idCurso), $fileName);
            $url = asset('images/paqueterias/id_curso_'.$request->idCurso.'/' . $fileName);
            @header('Content-type: text/html; charset=utf-8');
            return response()->json(['url' => $url]);
        }
        else{
            dd('no file');
        }
    }
}
