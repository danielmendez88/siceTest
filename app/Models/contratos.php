<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contratos extends Model
{
    //
    protected $table = 'contratos';
    protected $primaryKey = 'id_contrato';

    protected $fillable = ['id_contrato','numero_contrato','cantidad_letras1','fecha_firma','municipio',
    'id_folios','instructor_perfilid','unidad_capacitacion','docs','observacion','cantidad_numero','arch_factura','fecha_status'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function supre()
    {
        return $this->belongsTo(supre::class, 'id_supre');
    }
    public function perfil_instructor()
    {
        return $this->belongsTo(InstructorPerfil::class, 'id_folios');
    }

    /**
     * scope de busqueda por contratos
     */
<<<<<<< HEAD
<<<<<<< HEAD
    public function scopeBusquedaPorContrato($query, $tipo, $buscar)
=======
   /* public function scopeBusquedaPorContrato($query, $tipo, $buscar, $tipo_status)
>>>>>>> f0b380b... 23022021 02 fixing
=======
    public function scopeBusquedaPorContrato($query, $tipo, $buscar, $tipo_status)
>>>>>>> 15fc9c3... 23022021 03 fixing02
    {
        if (!empty($tipo)) {
            # se valida el tipo
            if (!empty(trim($buscar))) {
                # busqueda
                switch ($tipo) {
                    case 'no_memorandum':
                        # busqueda por memorandum...
                        return $query->WHERE('tabla_supre.no_memo', '=', $buscar);
                        break;
                    case 'unidad_capacitacion':
                        # busqueda por unidad capacitacion...
                        return $query->WHERE('tabla_supre.unidad_capacitacion', '=', $buscar);
                        break;
                    case 'fecha':
                        # busqueda por fecha ...
                        return $query->WHERE('tabla_supre.fecha', '=', $buscar);
                        break;
                }
            }
        }
    }

    /**
     * busqueda scope por pagos
     */
<<<<<<< HEAD
<<<<<<< HEAD
    public function scopeBusquedaPorPagos($query, $tipo, $buscar)
=======
   /* public function scopeBusquedaPorPagos($query, $tipo, $buscar, $tipo_status)
>>>>>>> f0b380b... 23022021 02 fixing
=======
    public function scopeBusquedaPorPagos($query, $tipo, $buscar, $tipo_status)
>>>>>>> 15fc9c3... 23022021 03 fixing02
    {
        if (!empty($tipo)) {
            # se valida el tipo
            if (!empty(trim($buscar))) {
                # busqueda
                switch ($tipo) {
                    case 'no_contrato':
                        # busqueda por número de contrato
                        return $query->WHERE('contratos.numero_contrato', '=', $buscar);
                        break;
                    case 'unidad_capacitacion':
                        # busqueda por unidad de capacitación
                        return $query->WHERE('contratos.unidad_capacitacion', '=', $buscar);
                        break;
                    case 'fecha_firma':
                        # busqueda por fechas
                        return $query->WHERE('contratos.fecha_firma', '=', $buscar);
                        break;
                }
            }
        }
    }
}
