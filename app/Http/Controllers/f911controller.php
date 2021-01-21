<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;

class f911controller extends Controller
{
    public function index(Request $request)
    {
        
        $fecha_inicio = $request->get("fecha_inicio");
        $fecha_termino=$request->get("fecha_termino");
        $var_cursos = Calificacion::SELECT('e.clave','e.nombre',DB::raw('count(distinct(c.id)) AS tgrupos'),
                DB::Raw("sum(case when EXTRACT(year from (age(tbl_calificaciones.termino , ap.fecha_nacimiento))) < 15 and ap.sexo='MASCULINO' then 1 else 0 end) as th"),DB::Raw("sum(case when EXTRACT(year from (age(tbl_calificaciones.termino , ap.fecha_nacimiento))) < 15 and ap.sexo='FEMENINO' then 1 else 0 end) as tm"),
                DB::raw("sum(case when EXTRACT(year from (age(tbl_calificaciones.termino , ap.fecha_nacimiento))) < 15 and ap.sexo='MASCULINO' and tbl_calificaciones.acreditado='X' then 1 else 0 end) as tacreh"),DB::raw("sum(case when EXTRACT(year from (age(tbl_calificaciones.termino , ap.fecha_nacimiento))) < 15 and ap.sexo='FEMENINO' and tbl_calificaciones.acreditado='X' then 1 else 0 end) as tacrem"),
                DB::raw("sum(case when EXTRACT(year from (age(tbl_calificaciones.termino , ap.fecha_nacimiento))) between 15 and 19 and ap.sexo='MASCULINO' then 1 else 0 end) as th2"),DB::raw("sum(case when EXTRACT(year from (age(tbl_calificaciones.termino , ap.fecha_nacimiento))) between 15 and 19 and ap.sexo='FEMENINO' then 1 else 0 end) as tm2"),
                DB::raw("sum(case when EXTRACT(year from (age(tbl_calificaciones.termino , ap.fecha_nacimiento))) between 15 and 19 and ap.sexo='MASCULINO' and tbl_calificaciones.acreditado='X' then 1 else 0 end) as tacreh2"),DB::raw("sum(case when EXTRACT(year from (age(tbl_calificaciones.termino , ap.fecha_nacimiento))) between 15 and 19 and ap.sexo='FEMENINO' and tbl_calificaciones.acreditado='X' then 1 else 0 end) as tacrem2"))
                ->JOIN('especialidades as e', 'tbl_calificaciones.espe', '=', 'e.nombre')                
                ->JOIN('alumnos_registro as ar', 'tbl_calificaciones.matricula', '=', 'ar.no_control')
                ->JOIN('alumnos_pre as ap', 'ap.id', '=', 'ar.id_pre')
                ->JOIN('tbl_cursos as c','c.id', '=', 'tbl_calificaciones.idcurso')                
                ->WHERE('tbl_calificaciones.unidad', '=', 'CATAZAJA')
                ->WHEREbetween('tbl_calificaciones.termino', array($fecha_inicio,$fecha_termino))
                ->WHERE(DB::raw("extract(hour from TO_timestamp(c.hini, 'HH24:MI p.m.')::time)"), '>=', '14')                
                ->groupby('e.clave','e.nombre')
                ->orderby('e.nombre')                                                                                                         
                ->distinct()->get();
        return view('reportes.vista_911',compact('var_cursos'));
        
    }
    
}
