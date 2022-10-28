<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class CursoTemp extends Model
{
    //
    protected $table = 'cursos_temp';
    protected $fillable = [
        'id',
        'nombre_curso',
        'modalidad',
        'horas',
        'clasificacion',
        'costo',
        'duracion',
        'objetivo',
        'perfil',
        'solicitud_autorizacion',
        'fecha_validacion',
        'memo_validacion',
        'memo_actualizacion',
        'fecha_actualizacion',
        'unidad_amovil',
        'descripcion',
        'no_convenio',
        'id_especialidad',
        'area',
        'cambios_especialidad',
        'nivel_estudio',
        'categoria',
        'documento_solicitud_autorizacion',
        'documento_memo_actualizacion',
        'documento_memo_validacion',
        'tipo_curso',
        'rango_criterio_pago_minimo',
        'rango_criterio_pago_maximo',
        'unidades_disponible',
        'estado',
        'dependencia',
        'grupo_vulnerable',
        'observacion',
        'carta_descriptiva',
        'eval_alumno',
        'estatus_paqueteria',
        'active',
        'tipoSoli',
        'motivoSoli',
        'fecha_alta',
        'fecha_u_mod',
        'fecha_baja',
        'id_user_created',
        'id_user_edited',
        'id_user_deleted'

    ];

    protected $casts = [
        'unidades_disponible' => 'array',
        'dependencia' => 'array',
        'grupo_vulnerable' => 'array'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * obtener el instructor que pertenece al perfil
     */
    public function curso_validado()
    {
        return $this->hasMany(cursoValidado::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'id');
    }

    /**
     * mutator en laravel
     */

    public function setFechaAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    // in your model
    public function getMyDateFormat($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    /***
     * busqueda por parametros
     * scopes
     */
    public function scopeSearchPorCurso($query, $tipo, $buscar)
    {
        if (!empty($tipo)) {
            # entramos y validamos
            if (!empty(trim($buscar))) {
                # empezamos
                switch ($tipo) {
                    case 'especialidad':
                        # code...
                        return $query->where('especialidades.nombre', 'LIKE', "%$buscar%");
                        break;
                    case 'curso':
                        # code...
                        return $query->where('cursos_temp.nombre_curso', 'LIKE', "%$buscar%");
                        break;
                    case 'duracion':
                        return $query->where('cursos_temp.horas', '=', "$buscar");
                        break;
                    case 'modalidad':
                        return $query->where('cursos_temp.modalidad', 'LIKE', "%$buscar%");
                        break;
                    case 'clasificacion':
                        return $query->where('cursos_temp.clasificacion', 'LIKE', "%$buscar%");
                        break;
                    case 'anio':
                        return $query->where(\DB::raw("date_part('year' , fecha_validacion )"), '=', "$buscar");
                        break;
                    default:
                        # code...
                        break;
                }
            }
        }
    }

    public function especialidadinstructor()
    {
        return $this->belongsToMany(especialidad_instructor::class, 'especialidad_instructor_curso', 'curso_id', 'id_especialidad_instructor');
    }
}
