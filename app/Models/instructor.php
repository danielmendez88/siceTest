<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class instructor extends Model
{
    protected $table = 'instructores';

    protected $fillable = ['id','numero_control','nombre','apellidoPaterno','apellidoMaterno','tipo_honorario','folio_documento','experiencia_laboral',
    'experiencia_docente','cursos_recibidos','capacitados_icatech','curso_recibido_icatech','cursos_impartidos',
    'registro_agente_capacitador','rfc','curp','sexo','estado_civil','fecha_nacimiento','entidad','municipio',
    'asentamiento','domicilio','telefono','correo','unidad_capacitacion_solicita_validacion_instructor',
    'memoramdum_validacion','fecha_validacion','observaciones','cursos_conocer','modificacion_memo','banco',
    'no_cuenta','interbancaria','folio_ine','archivo_cv'];

    protected $hidden = ['created_at', 'updated_at'];

            /**
     * método slug
     */
    protected function getSlugAttribute($value): string {
        return Str::slug($value, '-');
    }

    /**
     * obtener los perfiles del instructor
     */
    public function perfil()
    {
        return $this->hasMany(InstructorPerfil::class);
    }

    function curso_Validado()
    {
        return $this->hasMany(cursoValidado::class);
    }


}

