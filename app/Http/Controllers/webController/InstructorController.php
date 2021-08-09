<?php

namespace App\Http\Controllers\webController;

use App\Models\instructor;
use App\Models\cursoValidado;
use App\Models\curso;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use App\Models\InstructorPerfil;
use App\Models\tbl_unidades;
use App\Models\especialidad;
use App\Models\estado_civil;
use App\Models\status;
use App\Models\especialidad_instructor;
use App\Models\criterio_pago;
use App\Models\Inscripcion;
use App\Models\Calificacion;
use App\Models\tbl_curso;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FormatoTReport;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     #----- instructor/inicio -----#


    public function index(Request $request)
    {
        $busquedaInstructor = $request->get('busquedaPorInstructor');
        $tipoInstructor = $request->get('tipo_busqueda_instructor');

        $unidadUser = Auth::user()->unidad;

        $userId = Auth::user()->id;

        $roles = DB::table('role_user')
            ->LEFTJOIN('roles', 'roles.id', '=', 'role_user.role_id')
            ->SELECT('roles.slug AS role_name')
            ->WHERE('role_user.user_id', '=', $userId)
            ->GET();
        if($roles[0]->role_name == 'admin' || $roles[0]->role_name == 'depto_academico' || $roles[0]->role_name == 'depto_academico_instructor')
        {
            $data = instructor::searchinstructor($tipoInstructor, $busquedaInstructor)->WHERE('id', '!=', '0')
            ->PAGINATE(25, ['nombre', 'telefono', 'status', 'apellidoPaterno', 'apellidoMaterno', 'numero_control', 'id']);
        }
        else
        {
            $data = instructor::searchinstructor($tipoInstructor, $busquedaInstructor)->WHERE('id', '!=', '0')
            ->WHERE('estado' ,'=', true)
            ->PAGINATE(25, ['nombre', 'telefono', 'status', 'apellidoPaterno', 'apellidoMaterno', 'numero_control', 'id']);
        }
        return view('layouts.pages.initinstructor', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    #----- instructor/crear -----#
    public function crear_instructor()
    {
        return view('layouts.pages.frminstructor');
    }

    #----- instructor/guardar -----#
    public function guardar_instructor(Request $request)
    {
        $userId = Auth::user()->id;

        $verify = instructor::WHERE('curp','=', $request->curp)->FIRST();
        if(is_null($verify) == TRUE)
        {
            $uid = instructor::select('id')->WHERE('id', '!=', '0')->orderby('id','desc')->first();
            $saveInstructor = new instructor();
            if ($uid['id'] === null) {
                # si es nulo entra una vez y se le asigna un valor
                $id = 1;
            } else {
                # entra pero no se le asigna valor
                $id = $uid->id + 1;
            }

            # Proceso de Guardado
            #----- Personal -----
            $saveInstructor->id = $id;
            $saveInstructor->nombre = trim($request->nombre);
            $saveInstructor->apellidoPaterno = trim($request->apellido_paterno);
            $saveInstructor->apellidoMaterno = trim($request->apellido_materno);
            $saveInstructor->curp = trim($request->curp);
            $saveInstructor->banco = $request->banco;
            $saveInstructor->interbancaria = $request->clabe;
            $saveInstructor->no_cuenta = $request->numero_cuenta;
            $saveInstructor->domicilio = $request->domicilio;
            $saveInstructor->numero_control = "Pendiente";
            $saveInstructor->status = "En Proceso";
            $saveInstructor->lastUserId = $userId;

            if ($request->file('arch_ine') != null)
            {
                $ine = $request->file('arch_ine'); # obtenemos el archivo
                $urline = $this->pdf_upload($ine, $id, 'ine'); # invocamos el método
                $saveInstructor->archivo_ine = $urline; # guardamos el path
            }

            if ($request->file('arch_domicilio') != null)
            {
                $dom = $request->file('arch_domicilio'); # obtenemos el archivo
                $urldom = $this->pdf_upload($dom, $id, 'dom'); # invocamos el método
                $saveInstructor->archivo_domicilio = $urldom; # guardamos el path
            }

            if ($request->file('arch_curp') != null)
            {
                $curp = $request->file('arch_curp'); # obtenemos el archivo
                $urlcurp = $this->pdf_upload($curp, $id, 'curp'); # invocamos el método
                $saveInstructor->archivo_curp = $urlcurp; # guardamos el path
            }

            if ($request->file('arch_alta') != null)
            {
                $alta = $request->file('arch_alta'); # obtenemos el archivo
                $urlalta = $this->pdf_upload($alta, $id, 'alta'); # invocamos el método
                $saveInstructor->archivo_alta = $urlalta; # guardamos el path
            }

            if ($request->file('arch_banco') != null)
            {
                $banco = $request->file('arch_banco'); # obtenemos el archivo
                $urlbanco = $this->pdf_upload($banco, $id, 'banco'); # invocamos el método
                $saveInstructor->archivo_bancario = $urlbanco; # guardamos el path
            }

            if ($request->file('arch_rfc') != null)
            {
                $rfc = $request->file('arch_rfc'); # obtenemos el archivo
                $urlrfc = $this->pdf_upload($rfc, $id, 'rfc'); # invocamos el método
                $saveInstructor->archivo_rfc = $urlrfc; # guardamos el path
            }

            if ($request->file('arch_foto') != null)
            {
                $foto = $request->file('arch_foto'); # obtenemos el archivo
                $urlfoto = $this->jpg_upload($foto, $id, 'foto'); # invocamos el método
                $saveInstructor->archivo_fotografia = $urlfoto; # guardamos el path
            }

            if ($request->file('arch_estudio') != null)
            {
                $estudio = $request->file('arch_estudio'); # obtenemos el archivo
                $urlestudio = $this->pdf_upload($estudio, $id, 'estudios'); # invocamos el método
                $saveInstructor->archivo_estudios = $urlestudio; # guardamos el path
            }

            if ($request->file('arch_id') != null)
            {
                $otraid = $request->file('arch_id'); # obtenemos el archivo
                $urlotraid = $this->pdf_upload($otraid, $id, 'oid'); # invocamos el método
                $saveInstructor->archivo_otraid = $urlotraid; # guardamos el path
            }

            $saveInstructor->save();

            return redirect()->route('instructor-inicio')
                        ->with('success','Perfil profesional agregado');
        }
        else
        {
            $mensaje = "Lo sentimos, la curp ".$request->curp." asociada a este registro ya se encuentra en la base de datos.";
            return redirect('/instructor/crear')->withErrors($mensaje);
        }
    }

    public function validar($id)
    {
        $instructor = new instructor();
        $getinstructor = $instructor->findOrFail($id);
        $data = tbl_unidades::SELECT('unidad','cct')->WHERE('id','!=','0')->GET();
        return view('layouts.pages.validarinstructor', compact('getinstructor','data'));
    }

    public function rechazo_save(Request $request)
    {
        $userId = Auth::user()->id;

        $saveInstructor = instructor::find($request->id);
        $saveInstructor->rechazo = $request->comentario_rechazo;
        $saveInstructor->status = "Rechazado";
        $saveInstructor->lastUserId = $userId;
        $saveInstructor->save();

        return redirect()->route('instructor-inicio')
            ->with('success','Instructor Rechazado');
    }

    public function validado_save(Request $request)
    {
        $userId = Auth::user()->id;
        $unidades = ['TUXTLA', 'TAPACHULA', 'COMITAN', 'REFORMA', 'TONALA', 'VILLAFLORES', 'JIQUIPILAS', 'CATAZAJA',
        'YAJALON', 'SAN CRISTOBAL', 'CHIAPA DE CORZO', 'MOTOZINTLA', 'BERRIOZABAL', 'PIJIJIAPAN', 'JITOTOL',
        'LA CONCORDIA', 'VENUSTIANO CARRANZA', 'TILA', 'TEOPISCA', 'OCOSINGO', 'CINTALAPA', 'COPAINALA',
        'SOYALO', 'ANGEL ALBINO CORZO', 'ARRIAGA', 'PICHUCALCO', 'JUAREZ', 'SIMOJOVEL', 'MAPASTEPEC',
        'VILLA CORZO', 'CACAHOATAN', 'ONCE DE ABRIL', 'TUXTLA CHICO', 'OXCHUC', 'CHAMULA', 'OSTUACAN',
        'PALENQUE'];

        $instructor = instructor::find($request->id);

        $instructor->rfc = trim($request->rfc);
        $instructor->folio_ine = trim($request->folio_ine);
        $instructor->sexo = trim($request->sexo);
        $instructor->estado_civil = trim($request->estado_civil);
        $instructor->fecha_nacimiento = $request->fecha_nacimientoins;
        $instructor->entidad = trim($request->entidad);
        $instructor->municipio = trim($request->municipio);
        $instructor->asentamiento = trim($request->asentamiento);
        $instructor->telefono = trim($request->telefono);
        $instructor->correo = trim($request->correo);
        $instructor->tipo_honorario = trim($request->honorario);
        $instructor->clave_unidad = trim($request->unidad_registra);
        $instructor->status = "Validado";
        $instructor->estado = TRUE;
        $instructor->unidades_disponible = $unidades;
        $instructor->lastUserId = $userId;

        //Creacion de el numero de control
        $uni = substr($request->unidad_registra, -2);
        $now = Carbon::now();
        $year = substr($now->year, -2);
        $rfcpart = substr($request->rfc, 0, 10);
        $numero_control = $uni.$year.$rfcpart;
        $instructor->numero_control = trim($numero_control);
        $instructor->save();

            return redirect()->route('instructor-inicio')
            ->with('success','Instructor Validado');
    }

    public function editar($id)
    {
        $instructor = new instructor();
        $datains = instructor::WHERE('id', '=', $id)->FIRST();

        return view('layouts.pages.editarinstructor', compact('datains'));
    }

    public function guardar_mod(Request $request)
    {
        $userId = Auth::user()->id;
        $modInstructor = instructor::find($request->id);

        $modInstructor->nombre = trim($request->nombre);
        $modInstructor->apellidoPaterno = trim($request->apellido_paterno);
        $modInstructor->apellidoMaterno = trim($request->apellido_materno);
        $modInstructor->banco = $request->banco;
        $modInstructor->interbancaria = $request->clabe;
        $modInstructor->no_cuenta = $request->numero_cuenta;
        $modInstructor->domicilio = $request->domicilio;
        $modInstructor->status = "En Proceso";
        $modInstructor->lastUserId = $userId;

        if ($request->file('arch_ine') != null)
        {
            $ine = $request->file('arch_ine'); # obtenemos el archivo
            $urline = $this->pdf_upload($ine, $request->id, 'ine'); # invocamos el método
            $modInstructor->archivo_ine = $urline; # guardamos el path
        }

        if ($request->file('arch_domicilio') != null)
        {
            $dom = $request->file('arch_domicilio'); # obtenemos el archivo
            $urldom = $this->pdf_upload($dom, $request->id, 'dom'); # invocamos el método
            $modInstructor->archivo_domicilio = $urldom; # guardamos el path
        }

        if ($request->file('arch_curp') != null)
        {
            $curp = $request->file('arch_curp'); # obtenemos el archivo
            $urlcurp = $this->pdf_upload($curp, $request->id, 'curp'); # invocamos el método
            $modInstructor->archivo_curp = $urlcurp; # guardamos el path
        }

        if ($request->file('arch_alta') != null)
        {
            $alta = $request->file('arch_alta'); # obtenemos el archivo
            $urlalta = $this->pdf_upload($alta, $request->id, 'alta'); # invocamos el método
            $modInstructor->archivo_alta = $urlalta; # guardamos el path
        }

        if ($request->file('arch_banco') != null)
        {
            $banco = $request->file('arch_banco'); # obtenemos el archivo
            $urlbanco = $this->pdf_upload($banco, $request->id, 'banco'); # invocamos el método
            $modInstructor->archivo_bancario = $urlbanco; # guardamos el path
        }

        if ($request->file('arch_rfc') != null)
            {
                $rfc = $request->file('arch_rfc'); # obtenemos el archivo
                $urlrfc = $this->pdf_upload($rfc, $request->id, 'rfc'); # invocamos el método
                $modInstructor->archivo_rfc = $urlrfc; # guardamos el path
            }

        if ($request->file('arch_foto') != null)
        {
            $foto = $request->file('arch_foto'); # obtenemos el archivo
            $urlfoto = $this->jpg_upload($foto, $request->id, 'foto'); # invocamos el método
            $modInstructor->archivo_fotografia = $urlfoto; # guardamos el path
        }

        if ($request->file('arch_estudio') != null)
        {
            $estudio = $request->file('arch_estudio'); # obtenemos el archivo
            $urlestudio = $this->pdf_upload($estudio, $request->id, 'estudios'); # invocamos el método
            $modInstructor->archivo_estudios = $urlestudio; # guardamos el path
        }

        if ($request->file('arch_id') != null)
        {
            $otraid = $request->file('arch_id'); # obtenemos el archivo
            $urlotraid = $this->pdf_upload($otraid, $request->id, 'oid'); # invocamos el método
            $modInstructor->archivo_otraid = $urlotraid; # guardamos el path
        }

        $modInstructor->save();

        return redirect()->route('instructor-inicio')
                    ->with('success','Instructor Modificado');
    }

    public function ver_instructor($id)
    {
        $estado_civil = null;
        $instructor_perfil = new InstructorPerfil();
        $curso_validado = new cursoValidado();
        $det_curso = new Curso();
        $datains = instructor::WHERE('id', '=', $id)->FIRST();

        $lista_civil = estado_civil::WHERE('nombre', '!=', $datains->estado_civil)->GET();
        if ($datains->estado_civil != NULL )
        {
            $estado_civil = estado_civil::WHERE('nombre', '=', $datains->estado_civil)->FIRST();
        }

        $unidad = tbl_unidades::WHERE('cct', '=', $datains->clave_unidad)->FIRST();
        $lista_unidad = tbl_unidades::WHERE('cct', '!=', $datains->clave_unidad)->GET();

        $perfil = $instructor_perfil->WHERE('numero_control', '=', $id)->GET();
        // consulta
        $validado = $instructor_perfil->SELECT('especialidades.nombre',
        'especialidad_instructores.observacion', 'especialidad_instructores.id AS especialidadinsid',
        'especialidad_instructores.memorandum_validacion','especialidad_instructores.criterio_pago_id')
                        ->WHERE('instructor_perfil.numero_control', '=', $id)
                        ->RIGHTJOIN('especialidad_instructores','especialidad_instructores.perfilprof_id','=','instructor_perfil.id')
                        ->LEFTJOIN('especialidades','especialidades.id','=','especialidad_instructores.especialidad_id')
                        ->GET();
        return view('layouts.pages.verinstructor', compact('datains','estado_civil','lista_civil','unidad','lista_unidad','perfil','validado'));
    }

    public function save_ins(Request $request)
    {
        $userId = Auth::user()->id;
        $modInstructor = instructor::find($request->id);

        $old = $modInstructor->apellidoPaterno . ' ' . $modInstructor->apellidoMaterno . ' ' . $modInstructor->nombre;
        $new = $request->apellido_paterno . ' ' . $request->apellido_materno . ' ' . $request->nombre;

        $modInstructor->nombre = trim($request->nombre);
        $modInstructor->apellidoPaterno = trim($request->apellido_paterno);
        $modInstructor->apellidoMaterno = trim($request->apellido_materno);
        $modInstructor->curp = trim($request->curp);
        $modInstructor->rfc = trim($request->rfc);
        $modInstructor->folio_ine = trim($request->folio_ine);
        $modInstructor->sexo = trim($request->sexo);
        $modInstructor->estado_civil = trim($request->estado_civil);
        $modInstructor->fecha_nacimiento = $request->fecha_nacimientoins;
        $modInstructor->entidad = trim($request->entidad);
        $modInstructor->municipio = trim($request->municipio);
        $modInstructor->asentamiento = trim($request->asentamiento);
        $modInstructor->telefono = trim($request->telefono);
        $modInstructor->correo = trim($request->correo);
        $modInstructor->tipo_honorario = trim($request->honorario);
        $modInstructor->clave_unidad = trim($request->unidad_registra);
        if($request->estado != NULL)
        {
            $modInstructor->estado = TRUE;
        }
        else
        {
            $modInstructor->estado = FALSE;
        }

        $uni = substr($request->unidad_registra, -2);
        $nuco = substr($modInstructor->numero_control, -12);
        $numero_control = $uni.$nuco;
        $modInstructor->numero_control = trim($numero_control);

        $modInstructor->banco = $request->banco;
        $modInstructor->interbancaria = $request->clabe;
        $modInstructor->no_cuenta = $request->numero_cuenta;
        $modInstructor->domicilio = $request->domicilio;
        $modInstructor->lastUserId = $userId;


        if ($request->file('arch_ine') != null)
        {
            $ine = $request->file('arch_ine'); # obtenemos el archivo
            $urline = $this->pdf_upload($ine, $request->id, 'ine'); # invocamos el método
            $modInstructor->archivo_ine = $urline; # guardamos el path
        }

        if ($request->file('arch_domicilio') != null)
        {
        $dom = $request->file('arch_domicilio'); # obtenemos el archivo
        $urldom = $this->pdf_upload($dom, $request->id, 'dom'); # invocamos el método
        $modInstructor->archivo_domicilio = $urldom; # guardamos el path
        }

        if ($request->file('arch_curp') != null)
        {
        $curp = $request->file('arch_curp'); # obtenemos el archivo
        $urlcurp = $this->pdf_upload($curp, $request->id, 'curp'); # invocamos el método
        $modInstructor->archivo_curp = $urlcurp; # guardamos el path
        }

        if ($request->file('arch_alta') != null)
        {
        $alta = $request->file('arch_alta'); # obtenemos el archivo
        $urlalta = $this->pdf_upload($alta, $request->id, 'alta'); # invocamos el método
        $modInstructor->archivo_alta = $urlalta; # guardamos el path
        }

        if ($request->file('arch_banco') != null)
        {
        $banco = $request->file('arch_banco'); # obtenemos el archivo
        $urlbanco = $this->pdf_upload($banco, $request->id, 'banco'); # invocamos el método
        $modInstructor->archivo_bancario = $urlbanco; # guardamos el path
        }

        if ($request->file('arch_rfc') != null)
        {
            $rfc = $request->file('arch_rfc'); # obtenemos el archivo
            $urlrfc = $this->pdf_upload($rfc, $request->id, 'rfc'); # invocamos el método
            $modInstructor->archivo_rfc = $urlrfc; # guardamos el path
        }

        if ($request->file('arch_foto') != null)
        {
        $foto = $request->file('arch_foto'); # obtenemos el archivo
        $urlfoto = $this->jpg_upload($foto, $request->id, 'foto'); # invocamos el método
        $modInstructor->archivo_fotografia = $urlfoto; # guardamos el path
        }

        if ($request->file('arch_estudio') != null)
        {
        $estudio = $request->file('arch_estudio'); # obtenemos el archivo
        $urlestudio = $this->pdf_upload($estudio, $request->id, 'estudios'); # invocamos el método
        $modInstructor->archivo_estudios = $urlestudio; # guardamos el path
        }

        if ($request->file('arch_id') != null)
        {
        $otraid = $request->file('arch_id'); # obtenemos el archivo
        $urlotraid = $this->pdf_upload($otraid, $request->id, 'oid'); # invocamos el método
        $modInstructor->archivo_otraid = $urlotraid; # guardamos el path
        }

        $modInstructor->save();

        //$affecttbl_inscripcion = DB::table("tbl_inscripcion")->WHERE('instructor', $old)->update(['instructor' => $new]);
        //$affecttbl_calificaciones = DB::table("tbl_calificaciones")->WHERE('instructor', $old)->update(['instructor' => $new]);
        //$affecttbl_cursos = DB::table("tbl_cursos")->WHERE('nombre', $old)->update(['nombre' =>$new]);

        Inscripcion::where('instructor', '=', $old)->update(['instructor' => $new]);
        //Calificacion::where('instructor', '=', $old)->update(['instructor' => $new]);
        tbl_curso::where('nombre', '=', $old)->update(['nombre' => $new]);
        tbl_curso::where('id_instructor', '=', $request->id)->update(['curp' => $request->curp]);


        return redirect()->route('instructor-inicio')
                ->with('success','Instructor Modificado');
    }

    public function edit_especval($id,$idins)
    {
        $idesp = $id;
        $idins = $idins;
        $data_especialidad = especialidad::where('id', '!=', '0')->latest()->get();
        return view('layouts.pages.modcursoimpartir', compact('data_especialidad','idesp','idins'));
    }

    public function edit_especval2($id, $idins, $idesp)
    {
        $especvalid = especialidad_instructor::WHERE('id', '=', $idesp)->FIRST();

        $data_espec = InstructorPerfil::all();

        $data_pago = criterio_pago::all();

        $data_unidad = tbl_unidades::all();
        // cursos totales
        $catcursos = curso::WHERE('id_especialidad', '=', $id)->GET(['id', 'nombre_curso', 'modalidad', 'objetivo', 'costo', 'duracion', 'objetivo', 'tipo_curso', 'id_especialidad', 'rango_criterio_pago_minimo', 'rango_criterio_pago_maximo']);

        $nomesp = especialidad::SELECT('nombre')->WHERE('id', '=', $id)->FIRST();

        return view('layouts.pages.frmmodespecialidad', compact('especvalid','data_espec','data_pago','data_unidad', 'idesp','id','idins','nomesp', 'catcursos'));
    }

    public function add_perfil($id)
    {
        $idins = $id;
        return view('layouts.pages.frmperfilprof', compact('idins'));
    }

    public function mod_perfil($id, $idins)
    {
        $perfil_ins = InstructorPerfil::WHERE('id', '=', $id)->FIRST();

        $sel_status = Status::WHERE('estatus', '=', $perfil_ins->estatus)->FIRST();
        $data_status = Status::WHERE('estatus', '!=', $perfil_ins->estatus)
                              ->WHERE('perfil_profesional', '=', 'true')->GET();

        return view('layouts.pages.modperfilprof', compact('idins','perfil_ins','sel_status','data_status','id'));
    }

    public function modperfilinstructor_save(Request $request)
    {
        $userId = Auth::user()->id;

        $perfilInstructor = InstructorPerfil::find($request->id);
        #proceso de guardado
        $perfilInstructor->grado_profesional = trim($request->grado_prof); //
        $perfilInstructor->area_carrera = trim($request->area_carrera); //
        $perfilInstructor->estatus = trim($request->estatus); //
        $perfilInstructor->pais_institucion = trim($request->institucion_pais); //
        $perfilInstructor->entidad_institucion = trim($request->institucion_entidad); //
        $perfilInstructor->ciudad_institucion = trim($request->institucion_ciudad);
        $perfilInstructor->nombre_institucion = trim($request->institucion_nombre);
        $perfilInstructor->fecha_expedicion_documento = trim($request->fecha_documento); //
        $perfilInstructor->folio_documento = trim($request->folio_documento); //
        $perfilInstructor->cursos_recibidos = trim($request->cursos_recibidos);
        $perfilInstructor->estandar_conocer = trim($request->conocer);
        $perfilInstructor->registro_stps = trim($request->stps);
        $perfilInstructor->capacitador_icatech = trim($request->capacitador_icatech);
        $perfilInstructor->recibidos_icatech = trim($request->recibidos_icatech);
        $perfilInstructor->cursos_impartidos = trim($request->cursos_impartidos);
        $perfilInstructor->experiencia_laboral = trim($request->exp_lab);
        $perfilInstructor->experiencia_docente = trim($request->exp_doc);
        $perfilInstructor->numero_control = trim($request->idInstructor);
        $perfilInstructor->lastUserId = $userId;
        $perfilInstructor->save(); // guardar registro

        return redirect()->route('instructor-ver', ['id' => $request->idInstructor])
                        ->with('success','Perfil profesional modificado');

    }

    public function perfilinstructor_save(Request $request)
    {
        $userId = Auth::user()->id;

        $perfilInstructor = new InstructorPerfil();
        #proceso de guardado
        $perfilInstructor->grado_profesional = trim($request->grado_prof); //
        $perfilInstructor->area_carrera = trim($request->area_carrera); //
        $perfilInstructor->estatus = trim($request->estatus); //
        $perfilInstructor->pais_institucion = trim($request->institucion_pais); //
        $perfilInstructor->entidad_institucion = trim($request->institucion_entidad); //
        $perfilInstructor->ciudad_institucion = trim($request->institucion_ciudad);
        $perfilInstructor->nombre_institucion = trim($request->institucion_nombre);
        $perfilInstructor->fecha_expedicion_documento = trim($request->fecha_documento); //
        $perfilInstructor->folio_documento = trim($request->folio_documento); //
        $perfilInstructor->cursos_recibidos = trim($request->cursos_recibidos);
        $perfilInstructor->estandar_conocer = trim($request->conocer);
        $perfilInstructor->registro_stps = trim($request->stps);
        $perfilInstructor->capacitador_icatech = trim($request->capacitador_icatech);
        $perfilInstructor->recibidos_icatech = trim($request->recibidos_icatech);
        $perfilInstructor->cursos_impartidos = trim($request->cursos_impartidos);
        $perfilInstructor->experiencia_laboral = trim($request->exp_lab);
        $perfilInstructor->experiencia_docente = trim($request->exp_doc);
        $perfilInstructor->numero_control = trim($request->idInstructor);
        $perfilInstructor->lastUserId = $userId;
        $perfilInstructor->save(); // guardar registro

        return redirect()->route('instructor-ver', ['id' => $request->idInstructor])
                        ->with('success','Perfil profesional agregado');

    }

    public function add_cursoimpartir($id)
    {
        $idins = $id;
        $data_especialidad = especialidad::where('id', '!=', '0')->latest()->get();
        return view('layouts.pages.frmcursoimpartir', compact('data_especialidad','idins'));
    }

    public function cursoimpartir_form($id, $idins)
    {
        $perfil = InstructorPerfil::WHERE('numero_control', '=', $idins)->GET(['id','grado_profesional','area_carrera']);
        $pago = criterio_pago::SELECT('id','perfil_profesional')->WHERE('id', '!=', '0')->GET();
        $data = tbl_unidades::SELECT('unidad','cct')->WHERE('id','!=','0')->GET();
        $cursos = curso::WHERE('id_especialidad', '=', $id)->GET(['id', 'nombre_curso', 'modalidad', 'objetivo', 'costo', 'duracion', 'objetivo', 'tipo_curso', 'id_especialidad', 'rango_criterio_pago_minimo', 'rango_criterio_pago_maximo']);
        $nomesp = especialidad::SELECT('nombre')->WHERE('id', '=', $id)->FIRST();
        return view('layouts.pages.frmaddespecialidad', compact('id','idins','perfil','pago','data', 'cursos','nomesp'));
    }

    public function especval_mod_save(Request $request)
    {
        $userId = Auth::user()->id;

        $espec_mod = especialidad_instructor::findOrFail($request->idespec);
        $espec_mod->especialidad_id = $request->idesp;
        $espec_mod->perfilprof_id = $request->valido_perfil;
        $espec_mod->unidad_solicita = $request->unidad_validacion;
        $espec_mod->memorandum_validacion = $request->memorandum;
        $espec_mod->fecha_validacion = $request->fecha_validacion;
        $espec_mod->memorandum_modificacion = $request->memorandum_modificacion;
        $espec_mod->observacion = $request->observaciones;
        $espec_mod->criterio_pago_id = $request->criterio_pago_mod;
        $espec_mod->lastUserId = $userId;
        $espec_mod->save();
        // declarar un arreglo
        $pila_edit = array();
        // se trabajará en el loop
        $cursos_mod = especialidad_instructor::findOrFail($request->idespec);
        // eliminar registros previamente
        $cursos_mod->cursos()->detach();

        //dd($request->itemEdit);

        foreach ( (array) $request->itemEdit as $key => $value) {
            # iteramos en el loop para cargar los datos seleccionados
            if(isset($value['check_cursos_edit']))
            {
                $arreglos_edit = [
                    'curso_id' => $value['check_cursos_edit']
                ];
                array_push($pila_edit, $arreglos_edit);
            }

        }

        $cursos_mod->cursos()->attach($pila_edit);
        // Eliminar todos los elementos del array
        unset($pila_edit);

        return redirect()->route('instructor-ver', ['id' => $request->idins])
                        ->with('success','Especialidad Para Impartir Modificada');
    }

    public function espec_val_save(Request $request)
    {
        $userId = Auth::user()->id;

        $espec_save = new especialidad_instructor;
        $espec_save->especialidad_id = $request->idespec;
        $espec_save->perfilprof_id = $request->valido_perfil;
        $espec_save->unidad_solicita = $request->unidad_validacion;
        $espec_save->memorandum_validacion = $request->memorandum;
        $espec_save->fecha_validacion = $request->fecha_validacion;
        $espec_save->memorandum_modificacion = $request->memorandum_modificacion;
        $espec_save->observacion = $request->observaciones;
        $espec_save->criterio_pago_id = $request->criterio_pago_instructor;
        $espec_save->lastUserId = $userId;
        $espec_save->save();
        // obtener el ultimo id que se ha registrado
        $especialidadInstrcutorId = $espec_save->id;
        // declarar un arreglo
        $pila = array();

        // se trabajará en un loop
        foreach( (array) $request->itemAdd as $key => $value)
        {
            if(isset($value['check_cursos']))
            {
                $arreglos = [
                    'curso_id' => $value['check_cursos']
                ];
                array_push($pila, $arreglos);
            }
        }
        // hacemos la llamada al módelo
        $instructorEspecialidad = new especialidad_instructor();
        $especialidadesInstructoresCurso = $instructorEspecialidad->findOrFail($especialidadInstrcutorId);

        $especialidadesInstructoresCurso->cursos()->attach($pila);

        // limpiar array
        unset($pila);

        return redirect()->route('instructor-ver', ['id' => $request->idInstructor])
                        ->with('success','Especialidad Para Impartir Agregada');
    }

    public function alta_baja($id)
    {
        $av = instructor::SELECT('unidades_disponible')->WHERE('id', '=', $id)->FIRST();
        if($av == NULL)
        {
            $reform = instructor::find($id);
            $unidades = ['TUXTLA', 'TAPACHULA', 'COMITAN', 'REFORMA', 'TONALA', 'VILLAFLORES', 'JIQUIPILAS', 'CATAZAJA',
            'YAJALON', 'SAN CRISTOBAL', 'CHIAPA DE CORZO', 'MOTOZINTLA', 'BERRIOZABAL', 'PIJIJIAPAN', 'JITOTOL',
            'LA CONCORDIA', 'VENUSTIANO CARRANZA', 'TILA', 'TEOPISCA', 'OCOSINGO', 'CINTALAPA', 'COPAINALA',
            'SOYALO', 'ANGEL ALBINO CORZO', 'ARRIAGA', 'PICHUCALCO', 'JUAREZ', 'SIMOJOVEL', 'MAPASTEPEC',
            'VILLA CORZO', 'CACAHOATAN', 'ONCE DE ABRIL', 'TUXTLA CHICO', 'OXCHUC', 'CHAMULA', 'OSTUACAN',
            'PALENQUE'];

            $reform->unidades_disponible = $unidades;
            $reform->save();

            $av = instructor::SELECT('unidades_disponible')->WHERE('id', '=', $id)->FIRST();
        }
        $available = $av->unidades_disponible;
        return view('layouts.pages.vstaltabajains', compact('id','available'));
    }

    public function alta_baja_save(Request $request)
    {
        $unidades = [];
        if($this->checkComparator($request->chk_tuxtla) == TRUE)
        {
            array_push($unidades, 'TUXTLA');
        }
        if($this->checkComparator($request->chk_tapachula) == TRUE)
        {
            array_push($unidades, 'TAPACHULA');
        }
        if($this->checkComparator($request->chk_comitan) == TRUE)
        {
            array_push($unidades, 'COMITAN');
        }
        if($this->checkComparator($request->chk_reforma) == TRUE)
        {
            array_push($unidades, 'REFORMA');
        }
        if($this->checkComparator($request->chk_tonala) == TRUE)
        {
            array_push($unidades, 'TONALA');
        }
        if($this->checkComparator($request->chk_villaflores) == TRUE)
        {
            array_push($unidades, 'VILLAFLORES');
        }
        if($this->checkComparator($request->chk_jiquipilas) == TRUE)
        {
            array_push($unidades, 'JIQUIPILAS');
        }
        if($this->checkComparator($request->chk_catazaja) == TRUE)
        {
            array_push($unidades, 'CATAZAJA');
        }
        if($this->checkComparator($request->chk_yajalon) == TRUE)
        {
            array_push($unidades, 'YAJALON');
        }
        if($this->checkComparator($request->chk_san_cristobal) == TRUE)
        {
            array_push($unidades, 'SAN CRISTOBAL');
        }
        if($this->checkComparator($request->chk_chiapa_de_corzo) == TRUE)
        {
            array_push($unidades, 'CHIAPA DE CORZO');
        }
        if($this->checkComparator($request->chk_motozintla) == TRUE)
        {
            array_push($unidades, 'MOTOZINTLA');
        }
        if($this->checkComparator($request->chk_berriozabal) == TRUE)
        {
            array_push($unidades, 'BERRIOZABAL');
        }
        if($this->checkComparator($request->chk_pijijiapan) == TRUE)
        {
            array_push($unidades, 'PIJIJIAPAN');
        }
        if($this->checkComparator($request->chk_jitotol) == TRUE)
        {
            array_push($unidades, 'JITOTOL');
        }
        if($this->checkComparator($request->chk_la_concordia) == TRUE)
        {
            array_push($unidades, 'LA CONCORDIA');
        }
        if($this->checkComparator($request->chk_venustiano_carranza) == TRUE)
        {
            array_push($unidades, 'VENUSTIANO CARRANZA');
        }
        if($this->checkComparator($request->chk_tila) == TRUE)
        {
            array_push($unidades, 'TILA');
        }
        if($this->checkComparator($request->chk_teopisca) == TRUE)
        {
            array_push($unidades, 'TEOPISCA');
        }
        if($this->checkComparator($request->chk_ocosingo) == TRUE)
        {
            array_push($unidades, 'OCOSINGO');
        }
        if($this->checkComparator($request->chk_cintalapa) == TRUE)
        {
            array_push($unidades, 'CINTALAPA');
        }
        if($this->checkComparator($request->chk_copainala) == TRUE)
        {
            array_push($unidades, 'COPAINALA');
        }
        if($this->checkComparator($request->chk_soyalo) == TRUE)
        {
            array_push($unidades, 'SOYALO');
        }
        if($this->checkComparator($request->chk_angel_albino_corzo) == TRUE)
        {
            array_push($unidades, 'ANGEL ALBINO CORZO');
        }
        if($this->checkComparator($request->chk_arriaga) == TRUE)
        {
            array_push($unidades, 'ARRIAGA');
        }
        if($this->checkComparator($request->chk_pichucalco) == TRUE)
        {
            array_push($unidades, 'PICHUCALCO');
        }
        if($this->checkComparator($request->chk_juarez) == TRUE)
        {
            array_push($unidades, 'JUAREZ');
        }
        if($this->checkComparator($request->chk_simojovel) == TRUE)
        {
            array_push($unidades, 'SIMOJOVEL');
        }
        if($this->checkComparator($request->chk_mapastepec) == TRUE)
        {
            array_push($unidades, 'MAPASTEPEC');
        }
        if($this->checkComparator($request->chk_villa_corzo) == TRUE)
        {
            array_push($unidades, 'VILLA CORZO');
        }
        if($this->checkComparator($request->chk_cacahoatan) == TRUE)
        {
            array_push($unidades, 'CACAHOATAN');
        }
        if($this->checkComparator($request->chk_once_de_abril) == TRUE)
        {
            array_push($unidades, 'ONCE DE ABRIL');
        }
        if($this->checkComparator($request->chk_tuxtla_chico) == TRUE)
        {
            array_push($unidades, 'TUXTLA CHICO');
        }
        if($this->checkComparator($request->chk_oxchuc) == TRUE)
        {
            array_push($unidades, 'OXCHUC');
        }
        if($this->checkComparator($request->chk_chamula) == TRUE)
        {
            array_push($unidades, 'CHAMULA');
        }
        if($this->checkComparator($request->chk_ostuacan) == TRUE)
        {
            array_push($unidades, 'OSTUACAN');
        }
        if($this->checkComparator($request->chk_palenque) == TRUE)
        {
            array_push($unidades, 'PALENQUE');
        }

        $reform = instructor::find($request->id_available);
        $reform->unidades_disponible = $unidades;
        $reform->save();

        return redirect()->route('instructor-inicio')
                ->with('success','Instructor Modificado');
    }

    protected function checkComparator($check)
    {
        if(isset($check))
        {
            $stat = TRUE;
        }
        else
        {
            $stat = FALSE;
        }
        return $stat;
    }

    protected function pdf_upload($pdf, $id, $nom)
    {
        # nuevo nombre del archivo
        $pdfFile = trim($nom."_".date('YmdHis')."_".$id.".pdf");
        $pdf->storeAs('/uploadFiles/instructor/'.$id, $pdfFile); // guardamos el archivo en la carpeta storage
        $pdfUrl = Storage::url('/uploadFiles/instructor/'.$id."/".$pdfFile); // obtenemos la url donde se encuentra el archivo almacenado en el servidor.
        return $pdfUrl;
    }

    protected function jpg_upload($jpg, $id, $nom)
    {
        # nuevo nombre del archivo
        $jpgFile = trim($nom."_".date('YmdHis')."_".$id.".jpg");
        $jpg->storeAs('/uploadFiles/instructor/'.$id, $jpgFile); // guardamos el archivo en la carpeta storage
        $jpgUrl = Storage::url('/uploadFiles/instructor/'.$id."/".$jpgFile); // obtenemos la url donde se encuentra el archivo almacenado en el servidor.
        return $jpgUrl;
    }

    public function paginate($items, $perPage = 5, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
            'path' => Paginator::resolveCurrentPath()
        ]);
    }

    public function exportar_instructores()
    {
        $data = instructor::SELECT('instructores.id','instructores.nombre',
                'instructores.apellidoPaterno as apellido paterno','instructores.apellidoMaterno as apellido materno',
                'instructores.numero_control','especialidades.nombre as especialidad','especialidades.clave',
                'especialidad_instructores.criterio_pago_id as criterio pago','instructor_perfil.grado_profesional',
                'instructor_perfil.estatus','instructor_perfil.area_carrera','instructor_perfil.nombre_institucion',
                'instructores.rfc','instructores.curp','instructores.sexo','instructores.estado_civil',
                'instructores.asentamiento','instructores.domicilio','instructores.telefono','instructores.correo',
                'tbl_unidades.unidad','especialidad_instructores.memorandum_validacion',
                'especialidad_instructores.fecha_validacion','especialidad_instructores.observacion')
                ->LEFTJOIN('instructor_perfil','instructor_perfil.numero_control', '=', 'instructores.id')
                ->LEFTJOIN('especialidad_instructores', 'especialidad_instructores.perfilprof_id', '=', 'instructor_perfil.id')
                ->LEFTJOIN('especialidades', 'especialidades.id', '=', 'especialidad_instructores.especialidad_id')
                ->LEFTJOIN('tbl_unidades', 'tbl_unidades.cct', '=', 'instructores.clave_unidad')
                ->ORDERBY('apellidoPaterno', 'ASC')
                ->GET();

        $cabecera = ['ID','NOMBRE','APELLIDO PATERNO','APELLIDO MATERNO','NUMERO_COTROL','ESPECIALIDAD','CLAVE',
                    'CRITERIO PAGO','GRADO PROFESIONAL QUE CUBRE PARA LA ESPECIALIDAD',
                    'PERFIL PROFESIONAL CON EL QUE SE VALIDO','FORMACION PROFESIONAL CON EL QUE SE VALIDO',
                    'INSTITUCION','RFC','CURP','SEXO','ESTADO_CIVIL','ASENTAMIENTO','DOMICILIO','TELEFONO','CORREO',
                    'UNIDAD DE CAPACITACION','MEMORANDUM DE VALIDACION','FECHA DE VALIDACION','OBSERVACION'];

        $nombreLayout = "Catalogo de instructores.xlsx";
        $titulo = "Catalogo de instructores";
        if(count($data)>0){
            return Excel::download(new FormatoTReport($data,$cabecera, $titulo), $nombreLayout);
        }
    }
}

