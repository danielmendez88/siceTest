<?php

namespace App\Http\Controllers\supervisionController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\calidad_encuestas;
use App\Models\calidad_respuestas;
use App\Models\supervision\tokenEncuesta;
use App\Models\cursoValidado;
use App\Models\supervision\tokenTraitEncuesta;
use Carbon\Carbon;

class EscolarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct() {

    }
    public function index(Request $request)
    {
        $user = Auth::user();
        $tipo = $request->get('tipo_busqueda');
        $valor = $request->get('valor_busqueda');
        $unidades = $user->unidades;
        $id_user = $user->id;

        if($request->get('fecha')) $fecha = $request->get('fecha');
        else $fecha = date("d/m/Y");

        $query = DB::table('tbl_cursos')->select('tbl_cursos.id','tbl_cursos.id_curso','tbl_cursos.id_instructor',
        'tbl_cursos.nombre','tbl_cursos.clave','tbl_cursos.curso','tbl_cursos.inicio','tbl_cursos.termino','tbl_cursos.hini',
        'tbl_cursos.hfin','tbl_cursos.unidad',DB::raw('COUNT(DISTINCT(i.id)) as total'),DB::raw('COUNT(DISTINCT(a.id)) as total_alumnos'),
        'token_i.id as token_instructor','token_i.ttl as ttl_instructor','token_a.id_curso as token_alumno');

        if($fecha)$query = $query->where('tbl_cursos.inicio','<=',$fecha)->where('tbl_cursos.termino','>=',$fecha);
        if($unidades) {
            $unidades = explode(',',$unidades);
            $query = $query->whereIn('tbl_cursos.unidad',$unidades);
        }
        if (!empty($tipo) AND !empty(trim($valor))) {
            switch ($tipo) {
                case 'nombre_instructor':
                    $query = $query->where('tbl_cursos.nombre', 'like', '%'.$valor.'%');
                    break;
                case 'clave_curso':
                    $query = $query->where('tbl_cursos.clave',$valor);
                    break;
                case 'nombre_curso':
                    $query = $query->where('tbl_cursos.curso', 'LIKE', '%'.$valor.'%');
                    break;
            }
        }
        $query = $query->where('tbl_cursos.clave', '>', '0');

        $query = $query->leftJoin('supervision_instructores as i', function($join)use($id_user){
                $join->on('i.id_tbl_cursos', '=', 'tbl_cursos.id');
                $join->where('i.id_user',$id_user);
                $join->groupBy('i.id_tbl_cursos');

            });
        $query = $query->leftJoin('supervision_alumnos as a', function($join)use($id_user){
                $join->on('a.id_tbl_cursos', '=', 'tbl_cursos.id');
                $join->where('a.id_user',$id_user);
                $join->groupBy('a.id_tbl_cursos');

            });

        $query = $query->leftJoin('supervision_tokens as token_i' ,function($join)use($id_user){
                $join->on('tbl_cursos.id', '=', 'token_i.id_curso');
                $join->on('token_i.id_instructor','=','tbl_cursos.id_instructor');
                $join->where('token_i.id_supervisor',$id_user);
                $join->where('token_i.id_instructor','>','0');
        });

        $query = $query->leftJoin('supervision_tokens as token_a' ,function($join)use($id_user){
                $join->on('tbl_cursos.id', '=', 'token_a.id_curso');
                $join->where('token_a.id_supervisor',$id_user);
                $join->where('token_a.id_alumno','>','0');
        });

        $query = $query->groupby('tbl_cursos.id','tbl_cursos.id_curso','tbl_cursos.id_instructor',
        'tbl_cursos.nombre','tbl_cursos.clave','tbl_cursos.curso','tbl_cursos.inicio','tbl_cursos.termino','tbl_cursos.hini',
        'tbl_cursos.hfin','tbl_cursos.unidad','i.id_tbl_cursos','a.id_tbl_cursos','token_i.id','token_i.ttl','token_a.id_curso');

        $data =  $query->orderBy('tbl_cursos.inicio', 'DESC')->paginate(15);
        //var_dump($data);exit;


        return view('supervision.escolar.index', compact('data','fecha'));
    }

    public function encuesta($urltoken)
    {
        $tokentrait = new tokenTraitEncuesta;
        $tokenCheck = $tokentrait->generateTmpToken($urltoken);

        $encuesta = calidad_encuestas::where('activo', '=', 'true')->WHERE('idparent', '!=', '0')->GET();
        $titulo = calidad_encuestas::SELECT('nombre')->WHERE('activo', '=', 'true')->WHERE('idparent', '=', '0')->FIRST();
        return view('layouts.pages.frmencuesta', compact('encuesta','titulo','urltoken'));
    }

    public function encuesta_save(Request $request)
    {
        $x = $request->get('optradio');
        $keys = array_keys($x);
        $token = tokenEncuesta::WHERE('url_token' , '=', $request->token)->FIRST();


        $RegisterExists = calidad_respuestas::WHERE('id_encuesta', '=', $request->id_encuesta)->FIRST();

        if($RegisterExists != NULL)
        {
            $array = $RegisterExists->respuestas;
            $pointerid = array_keys($array);
            foreach ($array as $data)
            {
                $keys = array_keys($data);
                foreach($keys as $item)
                {
                    if($item == current($x))
                    {
                        $array[current($pointerid)][current($x)] = $array[current($pointerid)][current($x)] + 1;
                    }
                }
                next($x);
                next($pointerid);
            }

            $RegisterExists->respuestas->respuestas = $array;
            $RegisterExists->save();
        }
        else
        {
            $cursoValidado = cursoValidado::WHERE('id', '=', $token->id_curso);
            $encuesta = calidad_encuestas::SELECT('id','respuestas')->WHERE('activo', '=', 'true')->WHERE('idparent', '!=', '0')->WHERE('respuestas', '!=', NULL)->GET();

            $save_respuestas = new calidad_respuestas;
            $save_respuestas->id_encuesta = $request->id_encuesta;
            $save_respuestas->id_tbl_cursos = $token->id_curso;
            $save_respuestas->id_curso = $cursoValidado->id_curso;
            $save_respuestas->id_instructor = $cursoValidado->id_instructor;
            $save_respuestas->unidad = $cursoValidado->unidad;
            $save_respuestas->fecha_aplicacion = Carbon::now();

            foreach($encuesta as $item)
            {
                $key = $item->respuestas;
                foreach ($key as $data)
                {
                    if($data == current($x))
                    {
                        $array_respuestas[$item->id][$data] = '1';
                    }
                    else
                    {
                        $array_respuestas[$item->id][$data] = '0';
                    }
                }
                next($x);
            }
            dd($array_respuestas);
            $save_respuestas->respuestas = $array_respuestas;
            $save_respuestas->save();
        }
    }

    public function prueba() {
        /*$save_respuestas = new calidad_respuestas;
        $save_respuestas->id_encuesta = '1';
        $save_respuestas->id_tbl_cursos = '2';
        $save_respuestas->id_curso = '3';
        $save_respuestas->id_instructor = '4';
        $save_respuestas->unidad = '5';
        $save_respuestas->fecha_aplicacion = '12-12-2020';*/





        //$prueba = calidad_encuestas::SELECT('id, 'respuestas')->WHERE('activo', '=', 'true')->WHERE('idparent', '!=', '0')->WHERE('respuestas', '!=', NULL)->GET();
        /*$keys = array_keys($prueba);
        foreach($prueba as $item)
        {
            $key = $item->respuestas;
            foreach ($key as $data)
            {
                $array_respuestas[$item->id][$data] = '0';
            }
        }
        $save_respuestas->respuestas = $array_respuestas;
        $save_respuestas->save();*/
        $pruebas = calidad_respuestas::SELECT('respuestas')->WHERE('id', '=', '5')->first();
        $array = $pruebas->respuestas;
        $pointerid = array_keys($array);
        dd(current($pointerid));
        foreach ($array as $data)
        {
            $keys = array_keys($data);
            foreach($keys as $item)
            {
                if($item == 'Malo')
                {
                    $array['3'][$item] = $array['3'][$item] + 1;
                    dd($array['3'][$item]);
                }
                print($item . ' ');
            }

        }
        dd($array);
    }


}
