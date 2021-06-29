<?php
/* Creador: Orlando Chavez */
namespace App\Http\Controllers\webController;

use App\Models\pago;
use App\Models\instructor;
use App\Models\contratos;
use App\Models\folio;
use App\Models\directorio;
use App\Models\contrato_directorio;
use Illuminate\Http\Request;
use Redirect,Response;
use App\Http\Controllers\Controller;
use PDF;
use Illuminate\Support\Facades\Auth;
use App\Models\tbl_unidades;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    public function fill(Request $request)
    {
        $instructor = new instructor();
        $input = $request->numero_contrato;
        $newsAll = $instructor::where('id', $input)->first();
        return response()->json($newsAll, 200);
    }

    public function index(Request $request)
    {
        /**
         * busqueda de pago
         */
        $tipoPago = $request->get('tipo_pago');
        $busqueda_pago = $request->get('busquedaPorPago');
        $tipoStatus = $request->get('tipo_status');
        $unidad = $request->get('unidad');
        $mes = $request->get('mes');

        $contrato = new contratos();
        // obtener el usuario y su unidad
        $unidadUser = Auth::user()->unidad;

        // obtener el id
        $userId = Auth::user()->id;

        $roles = DB::table('role_user')
            ->LEFTJOIN('roles', 'roles.id', '=', 'role_user.role_id')
            ->SELECT('roles.slug AS role_name')
            ->WHERE('role_user.user_id', '=', $userId)
            ->GET();

        $unidades = tbl_unidades::SELECT('unidad')->WHERE('id', '!=', '0')->GET();

        //dd($roles[0]->role_name);

        $contratos_folios = $contrato::busquedaporpagos($tipoPago, $busqueda_pago, $tipoStatus, $unidad, $mes)
        ->WHEREIN('folios.status', ['Verificando_Pago','Pago_Verificado','Pago_Rechazado','Finalizado'])
        ->LEFTJOIN('folios','folios.id_folios', '=', 'contratos.id_folios')
        ->LEFTJOIN('tbl_cursos', 'folios.id_cursos', '=', 'tbl_cursos.id')
        ->LEFTJOIN('tbl_unidades', 'tbl_unidades.unidad', '=', 'tbl_cursos.unidad')
        ->LEFTJOIN('tabla_supre', 'tabla_supre.id', '=', 'folios.id_supre')
        ->LEFTJOIN('pagos', 'pagos.id_contrato', '=', 'contratos.id_contrato')
        ->orderBy('pagos.created_at', 'desc')
        ->PAGINATE(25, [
            'contratos.id_contrato', 'contratos.numero_contrato', 'contratos.cantidad_letras1',
            'contratos.unidad_capacitacion', 'contratos.municipio', 'contratos.fecha_firma','folios.permiso_editar',
            'contratos.docs', 'contratos.observacion', 'folios.status', 'folios.id_folios','folios.id_supre',
            'pagos.created_at'
        ]);
        switch ($roles[0]->role_name) {
            case 'unidad.ejecutiva':
                # code...
                $contratos_folios = $contratos_folios;
                break;
            case 'admin':
                # code...
                $contratos_folios = $contratos_folios;

            break;
            case 'direccion.general':
                # code...
                $contratos_folios = $contratos_folios;
                break;
            case 'planeacion':
                # code...
                $contratos_folios = $contratos_folios;
                break;
            case 'financiero_verificador':
                # code...
                $contratos_folios = $contratos_folios;
                break;
            case 'financiero_pago':
                # code...
                $contratos_folios = $contratos_folios;
                break;
            default:
                # code...
                // obtener unidades
                $unidadPorUsuario = DB::table('tbl_unidades')->WHERE('id', $unidadUser)->FIRST();

                $contratos_folios = $contrato::busquedaporpagos($tipoPago, $busqueda_pago, $tipoStatus, $unidad, $mes)
                ->WHERE('tbl_unidades.ubicacion', '=', $unidadPorUsuario->ubicacion)
                ->WHEREIN('folios.status', ['Verificando_Pago','Pago_Verificado','Pago_Rechazado','Finalizado'])
                ->LEFTJOIN('folios','folios.id_folios', '=', 'contratos.id_folios')
                ->LEFTJOIN('tbl_cursos', 'folios.id_cursos', '=', 'tbl_cursos.id')
                ->LEFTJOIN('tbl_unidades', 'tbl_unidades.unidad', '=', 'tbl_cursos.unidad')
                ->LEFTJOIN('tabla_supre', 'tabla_supre.id', '=', 'folios.id_supre')
                ->orderBy('contratos.fecha_firma', 'desc')
                ->PAGINATE(25, [
                    'contratos.id_contrato', 'contratos.numero_contrato', 'contratos.cantidad_letras1',
                    'contratos.unidad_capacitacion', 'contratos.municipio', 'contratos.fecha_firma','folios.permiso_editar',
                    'contratos.docs', 'contratos.observacion', 'folios.status', 'folios.id_folios','folios.id_supre'
                ]);
                break;
        }

        return view('layouts.pages.vstapago', compact('contratos_folios','unidades'));
    }

    public function crear_pago($id)
    {
        $data = contratos::SELECT('instructores.numero_control','instructores.nombre','instructores.apellidoPaterno','instructores.apellidoMaterno',
                                  'tbl_cursos.curso','tbl_cursos.clave','contratos.unidad_capacitacion','folios.id_folios','folios.importe_total','folios.iva','pagos.id AS id_pago')
                                    ->WHERE('contratos.id_contrato', '=', $id)
                                    ->LEFTJOIN('folios', 'folios.id_folios', '=', 'contratos.id_folios')
                                    ->LEFTJOIN('tbl_cursos', 'tbl_cursos.id', 'folios.id_cursos')
                                    ->LEFTJOIN('instructores', 'instructores.id', 'tbl_cursos.id_instructor')
                                    ->LEFTJOIN('pagos', 'pagos.id_contrato', '=', 'contratos.id_contrato')
                                    ->FIRST();

        $nomins = $data->nombre . ' ' . $data->apellidoPaterno . ' ' . $data->apellidoMaterno;
        $importe = round($data->importe_total-$data->iva, 2);
        return view('layouts.pages.frmpago', compact('data', 'nomins','importe'));
    }

    public function modificar_pago()
    {
        return view('layouts.pages.modpago');
    }

    public function verificar_pago($idfolios)
    {
        $contrato = contratos::WHERE('id_folios', '=', $idfolios)->FIRST();

        pago::where('id_contrato', '=', $contrato->id)
        ->update(['fecha_status' => carbon::now()]);

        $folio = folio::findOrfail($idfolios);
        $folio->status = 'Pago_Verificado';
        $folio->save();
        return redirect()->route('pago-inicio');
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
        $contrato = new contratos();

        $contratos = $contrato::SELECT('contratos.id_contrato', 'contratos.numero_contrato', 'contratos.cantidad_numero',
        'contratos.unidad_capacitacion', 'contratos.municipio', 'contratos.fecha_firma','contratos.arch_factura',
        'folios.status', 'folios.id_folios','tbl_cursos.id_instructor','instructores.id AS idins','instructores.archivo_bancario')
        ->WHERE('contratos.id_contrato', '=', $id)
        ->LEFTJOIN('folios','folios.id_folios', '=', 'contratos.id_folios')
        ->LEFTJOIN('tbl_cursos','tbl_cursos.id', '=', 'folios.id_cursos')
        ->LEFTJOIN('instructores','instructores.id', '=', 'tbl_cursos.id_instructor')
        ->FIRST();

        $datapago = pago::WHERE('id_contrato', '=', $id)->FIRST();

        $data_directorio = contrato_directorio::WHERE('id_contrato', '=', $contratos->id_contrato)->FIRST();
        $director = directorio::SELECT('nombre','apellidoPaterno','apellidoMaterno','id')->WHERE('id', '=', $data_directorio->contrato_iddirector)->FIRST();

        return view('layouts.pages.vstvalidarpago', compact('contratos','director','datapago'));
    }

    public function guardar_pago(Request $request)
    {
        pago::where('id', '=', $request->id_pago)
        ->update(['no_pago' => $request->numero_pago,
                  'fecha' => $request->fecha_pago,
                  'descripcion' => $request->concepto,
                  'fecha_status' => carbon::now()]);

        folio::WHERE('id_folios', '=', $request->id_folio)
        ->update(['status' => 'Finalizado']);

        return redirect()->route('pago-inicio');
    }

    public function rechazar_pago(Request $request)
    {
        folio::WHERE('id_folios', '=', $request->idfolios)
        ->update(['status' => 'Pago_Rechazado']);

        pago::where('id', '=', $request->idPago)
        ->update(['observacion' => $request->observaciones,
                  'fecha_status' => carbon::now()]);

        return redirect()->route('pago-inicio');
    }

    public function pago_validar($idfolio)
    {
        $folio = folio::findOrfail($idfolio);
        $folio->status = 'Pago_Verificado';
        $folio->save();
        return redirect()->route('pago-inicio')->with('info', 'El pago ha sido verificado exitosamente.');
    }

    public function pagoRestart($id)
    {
        $affecttbl_inscripcion = DB::table("folios")->WHERE('id_folios', $id)->update(['status' => 'Pago_Rechazado']);

        return redirect()->route('pago-inicio')
                        ->with('success','Solicitud de Pago Reiniciado');
    }

    public function historial_validacion($id)
    {
        //
        $contrato = new contratos();

        $contratos = $contrato::SELECT('contratos.id_contrato', 'contratos.numero_contrato', 'contratos.cantidad_numero',
        'contratos.unidad_capacitacion', 'contratos.municipio', 'contratos.fecha_firma','contratos.arch_factura',
        'folios.status', 'folios.id_folios','tbl_cursos.id_instructor','instructores.id AS idins','instructores.archivo_bancario')
        ->WHERE('contratos.id_contrato', '=', $id)
        ->LEFTJOIN('folios','folios.id_folios', '=', 'contratos.id_folios')
        ->LEFTJOIN('tbl_cursos','tbl_cursos.id', '=', 'folios.id_cursos')
        ->LEFTJOIN('instructores','instructores.id', '=', 'tbl_cursos.id_instructor')
        ->FIRST();

        $datapago = pago::WHERE('id_contrato', '=', $id)->FIRST();

        $data_directorio = contrato_directorio::WHERE('id_contrato', '=', $contratos->id_contrato)->FIRST();
        $director = directorio::SELECT('nombre','apellidoPaterno','apellidoMaterno','id')->WHERE('id', '=', $data_directorio->contrato_iddirector)->FIRST();

        return view('layouts.pages.vsthistorialvalidarpago', compact('contratos','director','datapago'));
    }

    public function  reporte_validados_recepcionados(Request $request)
    {
        $i = $request->fini;
        $now = Carbon::now();
        $mi = Carbon::parse($now->year . '-' . $request->fini . '-01');
        $fi = Carbon::parse($now->year . '-' . $request->ffin . '-01');
        $dym = $fi->daysInMonth;
        $fin = $now->year . '-' . $request->ffin . '-' . $dym;


        //dd($request);
        do {
            $nomval = "mes" . $i;
            $inicial = Carbon::parse($now->year . '-' . $i . '-01');
            $dym = $inicial->daysInMonth;
            $final = Carbon::parse($now->year . '-' . $i . '-' . $dym . ' 23:59:00');
            printf($inicial . ' - ' . $final . ' // ');
            $cab1 = "sivyc" . $i;
            $cab2 = "fisico" . $i;
            $cab3 = "PorEntregar" . $i;
            $query1 = "sum(case when folios.status in ('Contratado','Verificando_Pago','Pago_Verificado','Finalizado','Contrato_Rechazado','Pago_Rechazado') then 1 else 0 end) AS " . $cab1;
            $query2 = "sum(case when folios.status in ('Pago_Verificado','Finalizado')  then 1 else 0 end) AS " . $cab2;
            $query3 = "sum(case when folios.status in ('Contratado','Verificando_Pago')  then 1 else 0 end) AS " . $cab3;
            //dd($inicial);
            $$nomval = $data = folio::select('tbl_unidades.ubicacion',
                DB::raw($query1),
                DB::raw($query2),
                DB::raw($query3),
                )
                ->WHERE('folios.created_at', '>=', $inicial)
                ->WHERE('folios.created_at', '<=', $final)
                //->WHERE('tbl_unidades.ubicacion', '=', 'TUXTLA')
                ->JOIN('tabla_supre', 'tabla_supre.id', '=', 'folios.id_supre')
                ->JOIN('tbl_unidades', 'tbl_unidades.unidad', '=', 'tabla_supre.unidad_capacitacion')
                ->groupBy('tbl_unidades.ubicacion')
                ->orderBy('tbl_unidades.ubicacion')
                ->GET();

            $i++;
        } while ($i <= $request->ffin);
        $data = folio::select('tbl_unidades.ubicacion',
            DB::raw("sum(case when folios.status in ('Contratado','Verificando_Pago','Pago_Verificado','Finalizado','Contrato_Rechazado','Pago_Rechazado')  then 1 else 0 end) AS Sivyc"),
            DB::raw("sum(case when folios.status in ('Pago_Verificado','Finalizado')  then 1 else 0 end) AS Fisico"),
            DB::raw("sum(case when folios.status in ('Contratado','Verificando_Pago')  then 1 else 0 end) AS PorEntregar"),
            DB::raw("sum(case when folios.status in ('Finalizado')  then 1 else 0 end) AS Pagado"),
            DB::raw("sum(case when folios.status in ('Pago_Verificado')  then 1 else 0 end) AS PorPagar"),
            DB::raw("sum(case when folios.status in ('Contrato_Rechazado','Pago_Rechazado')  then 1 else 0 end) AS Observados")
            )
            ->WHERE('folios.created_at', '>=', $mi)
            ->WHERE('folios.created_at', '<=', $fin)
            //->WHERE('tbl_unidades.ubicacion', '=', 'TUXTLA')
            ->JOIN('tabla_supre', 'tabla_supre.id', '=', 'folios.id_supre')
            ->JOIN('tbl_unidades', 'tbl_unidades.unidad', '=', 'tabla_supre.unidad_capacitacion')
            ->groupBy('tbl_unidades.ubicacion')
            ->orderBy('tbl_unidades.ubicacion')
            ->GET();
            dd($mes01,$mes2,$mes3,$mes4,$mes5,$mes6,$data);
    }

    public function mostrar_pago($id)
    {
        $data = contratos::SELECT('instructores.numero_control','instructores.nombre','instructores.apellidoPaterno','instructores.apellidoMaterno',
                                  'tbl_cursos.curso','tbl_cursos.clave','contratos.unidad_capacitacion','folios.id_folios','folios.importe_total','folios.iva',
                                  'pagos.id AS id_pago','pagos.no_memo','pagos.fecha','pagos.no_pago','pagos.descripcion','pagos.liquido')
                           ->WHERE('contratos.id_contrato', '=', $id)
                           ->LEFTJOIN('folios', 'folios.id_folios', '=', 'contratos.id_folios')
                           ->LEFTJOIN('tbl_cursos', 'tbl_cursos.id', 'folios.id_cursos')
                           ->LEFTJOIN('instructores', 'instructores.id', 'tbl_cursos.id_instructor')
                           ->LEFTJOIN('pagos', 'pagos.id_contrato', '=', 'contratos.id_contrato')
                           ->FIRST();

        $nomins = $data->nombre . ' ' . $data->apellidoPaterno . ' ' . $data->apellidoMaterno;

        //return view('layouts.pages.vstapagofinalizado', compact('data', 'nomins'));
        $pdf = PDF::loadView('layouts.pages.vstapagofinalizado', compact('data', 'nomins'));

        return $pdf->download('medium.pdf');
    }

    public function financieros_reporte()
    {
        $unidades = tbl_unidades::SELECT('unidad')->WHERE('id', '!=', '0')->GET();

        return view('layouts.pages.vstareportefinancieros', compact('unidades'));
    }

    public function financieros_reportepdf(Request $request)
    {
        $i = 0;
        set_time_limit(0);
        $count = 0;

        $data = folio::SELECT('folios.folio_validacion as suf','folios.status','tabla_supre.fecha','tabla_supre.no_memo',
                                  'tabla_supre.unidad_capacitacion','tbl_cursos.curso','tbl_cursos.clave',
                                  'instructores.nombre','instructores.apellidoPaterno','instructores.apellidoMaterno',
                                  'instructores.numero_control')
                                  ->WHERE('folios.status', '!=', 'En_Proceso')
                                  ->WHERE('folios.status', '!=', 'Rechazado')
                                  ->WHERE('folios.status', '!=', 'Validado')
                                  ->whereDate('tabla_supre.fecha', '>=', $request->fecha1)
                                  ->whereDate('tabla_supre.fecha', '<=', $request->fecha2)
                                  ->LEFTJOIN('tabla_supre', 'tabla_supre.id', '=', 'folios.id_supre')
                                  ->LEFTJOIN('tbl_cursos', 'tbl_cursos.id', '=', 'folios.id_cursos')
                                  ->LEFTJOIN('instructores', 'instructores.id', '=', 'tbl_cursos.id_instructor')
                                  //->OrderByRaw('FIELD(folios.status, ' . implode(', ', $x) . ') ASC')
                                  ->GET();

        if ($request->filtro == 'curso')
        {
            $data = $data->WHERE('tbl_cursos.id', '=', $request->id_curso);
        }
        else if ($request->filtro == 'unidad')
        {
            $data = $data->WHERE('tabla_supre.unidad_capacitacion', '=', $request->unidad);
        }

        $data = $data->sortBy(function($item){
            return array_search($item->status, ['Validando_Contrato', 'Contrato_Rechazado', 'Contratado', 'Verificando_Pago', 'Pago_Rechazado', 'Pago_Verificado', 'Finalizado']);
        });

        $pdf = PDF::loadView('layouts.pdfpages.reportefinancieros', compact('data','count'));
        $pdf->setPaper('legal', 'Landscape');
        return $pdf->Download('formato de control '. $request->fecha1 . ' - '. $request->fecha2 .'.pdf');

    }
}
