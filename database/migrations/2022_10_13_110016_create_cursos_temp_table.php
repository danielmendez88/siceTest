<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursosTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos_temp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre_curso', 800)->nullable();
            $table->char('modalidad', 10)->nullable();
            $table->integer('horas')->nullable();
            $table->string('clasificacion', 50)->nullable();
            $table->decimal('costo', 10, 2)->nullable();
            $table->integer('duracion')->nullable();
            $table->string('objetivo', 1000)->nullable();
            $table->string('perfil', 1000)->nullable();
            $table->boolean('solicitud_autorizacion')->nullable();
            $table->date('fecha_validacion')->nullable();
            $table->string('memo_validacion', 400)->nullable();
            $table->string('memo_actualizacion', 400)->nullable();
            $table->date('fecha_actualizacion')->nullable();
            $table->string('unidad_amovil', 200);
            $table->text('descripcion')->nullable();
            $table->string('no_convenio', 30)->nullable();
            $table->timestamps();
            $table->bigInteger('id_especialidad')->nullable();
            $table->bigInteger('area')->nullable();
            $table->string('cambios_especialidad',1055)->nullable();
            $table->string('nivel_estudio',350)->nullable();
            $table->string('categoria',255)->nullable();
            
            $table->foreign('area')->references('id')->on('area')
                ->onUpdate('cascade')->onDelete('set null');

            $table->string('documento_solicitud_autorizacion',255)->nullable();
            $table->string('documento_memo_actualizacion',255)->nullable();
            $table->string('documento_memo_validacion',255)->nullable();
            $table->string('tipo_curso',30)->nullable();
            $table->bigInteger('rango_criterio_pago_minimo')->nullable();
            $table->bigInteger('rango_criterio_pago_maximo')->nullable();
            $table->json('unidades_disponible',700)->nullable();
            $table->boolean('estado')->nullable();
            $table->jsonb('dependencia')->nullable();
            $table->jsonb('grupo_vulnerable')->nullable();
            $table->string('observacion',255)->nullable();
            $table->jsonb('carta_descriptiva')->nullable();
            $table->jsonb('eval_alumno')->nullable();
            $table->string('estatus_paqueteria')->nullable();
            $table->boolean('active')->nullable();
            $table->string('tipoSoli')->nullable();
            $table->string('motivoSoli',2000)->nullable();
            $table->string('observaciones',2000)->nullable();
            
            $table->timestamp('fecha_alta')->nullable();
            $table->timestamp('fecha_u_mod')->nullable();
            $table->timestamp('fecha_baja')->nullable();
            $table->bigInteger('id_user_created')->nullable();
            $table->bigInteger('id_user_updated')->nullable();
            $table->bigInteger('id_user_deleted')->nullable();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos_temp');
    }
}
