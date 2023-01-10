<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SOLICITUD APERTURA</title>
    <style>      
        @page {
            margin: 40px 30px 10px 30px;
        }
        body {
            /*margin: 3cm 2cm 2cm;*/
            margin-top: 120px;
            font-family: sans-serif; font-size: 8px;
        }
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 4cm;
            text-align: center;
            /*line-height: 5px;*/
        }
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            text-align: center;
            line-height: 35px;
        }
        img.izquierda {float: left;width: 200px;height: 60px;}
        img.derecha {float: right;width: 200px;height: 60px;}
        .tb {width: 100%; border-collapse: collapse; text-align: center; font-size: 5px;}
        .tb td{border: 1px solid black; padding: 1px;}
        .tablaf { border-collapse: collapse; width: 100%; font-size: 8px; text-align: center;}     
        .tablaf tr, .tablaf td {padding: 0px 0px;}
    </style>
</head>
<body>
    <header>
        <img class="izquierda" src='img/logohorizontalica1.png'>
        <img class="derecha" src='img/chiapas.png'>
        <div style="clear: both;">
            <p style="align-content: center;">{{$distintivo}}</p>
        </div>
        <table style="text-align: right; border-collapse: collapse;" align="right">
            <tr>
                @if($reg_unidad->unidad=="COMITAN" || $reg_unidad->unidad=="OCOSINGO" || $reg_unidad->unidad=="SAN CRISTOBAL" || $reg_unidad->unidad=="TUXTLA" || $reg_unidad->unidad=="CATAZAJA" || $reg_unidad->unidad=="YAJALON" || $reg_unidad->unidad=="JIQUIPILAS" || $reg_unidad->unidad=="REFORMA" || $reg_unidad->unidad=="TAPACHULA" || $reg_unidad->unidad=="TONALA" || $reg_unidad->unidad=="VILLAFLORES")
                    <td><strong>Unidad de Capacitación {{$reg_unidad->unidad}}</strong></td> 
                @else
                    <td><strong>Acción Móvil {{$reg_unidad->unidad}}</strong></td> 
                @endif
            </tr>
            <tr>
                <td><strong>Memorándum No. {{$curso->mpreapertura}}</strong></td>
            </tr>
            <tr>
                <td><strong>{{$reg_unidad->municipio_acm}}, Chis., {{$curso->fecha_memo}}</strong></td>
            </tr>
        </table>
    </header>
    <main>
        <div class="container">
            <table>
                <tr>
                    <td>PARA:</td>
                    <td>{{$reg_unidad->academico}}, {{ $reg_unidad->pacademico }}.</td>
                </tr>
                <tr>
                    <td>DE:</td>
                    <td>{{$reg_unidad->vinculacion}}, {{ $reg_unidad->pvinculacion }}.</td>
                </tr>
                <tr>
                    <td>CCP:</td>
                    <td>{{ $reg_unidad->dunidad }}, {{ $reg_unidad->pdunidad }}. <br> {{ $reg_unidad->delegado_administrativo }},{{ $reg_unidad->pdelegado_administrativo }}.</td>
                </tr>
            </table>
            <div>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Archivo/Minutario</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por medio del presente le solicito a Usted la siguiente apertura:</p>
            </div>
            <table class="tb">
                <tr style="background: #EAECEE;">
                    <td>NÚMERO DE SOLICITUD</td>
                    <td>SERVICIO</td>
                    <td>ESPECIALIDAD</td>
                    <td>NOMBRE</td>
                    <td>MODALIDAD</td>
                    <td>TIPO</td>
                    <td>DURACIÓN</td>
                    <td>FECHA DE INICIO</td>
                    <td>FECHA DE TERMINO</td>
                    <td>HORARIO</td>
                    <td>DIAS</td>
                    <td>HRS. POR DIA</td>
                    <td>COSTO POR PARTICIPANTE</td>
                    <td>TOTAL INGRESO</td>
                    <td>NO. PARTICIPANTES</td>
                    <td>HOMBRES</td>
                    <td>MUJERES</td>
                    <td>MEMORÁNDUM DE AUTORIZACIÓN DE EXONERACIÓN/REDUCCIÓN</td>
                    <td>CONVENIO GENERAL</td>
                    <td>CONVENIO ESPECIFICO/ACTA DE ACUERDO</td>
                    <td>DEPENDENCIA</td>
                    <td>REPRESENTANTE</td>
                    <td>NO. TELEFONO DEL REPRESENTANTE</td>
                    <td>NOMBRE DEL INSTRUCTOR</td>
                    <td>CURSO VINCULADO POR</td>
                    @if ($curso->tcapacitacion == 'PRESENCIAL')
                        <td>ESPACIO FISICO</td>
                    @endif
                    <td>OBSERVACIONES</td>
                </tr>
                <tr>
                    <td>{{$curso->folio_grupo}}</td>
                    <td>{{$curso->tipo_curso}}</td>
                    <td>{{$curso->espe}}</td>
                    <td>{{$curso->curso}}</td>
                    <td>{{$curso->mod}}</td>
                    <td>{{$curso->tcapacitacion}}</td>
                    <td>{{$curso->dura}}</td>
                    <td>{{$curso->inicio}}</td>
                    <td>{{$curso->termino}}</td>
                    <td>{{$curso->horario}} HRS.</td>
                    <td>{{$curso->dia}}</td>
                    <td>{{$curso->horas}}</td>
                    <td>{{$costo}}</td>
                    <td>{{$curso->costo}}</td>
                    <td>{{$curso->tpar}}</td>
                    <td>{{$curso->hombre}}</td>
                    <td>{{$curso->mujer}}</td>
                    <td>@if ($curso->mexoneracion)  {{$curso->mexoneracion}} @else {{"N/A"}}  @endif</td>
                    <td>@if ($curso->cgeneral!='0') {{$curso->cgeneral}} @else {{"N/A"}} @endif</td>
                    <td>@if ($curso->cespecifico) {{$curso->cespecifico}} @else {{"N/A"}} @endif </td>
                    <td>{{$curso->depen}}</td>
                    <td>{{$curso->depen_repre}}</td>
                    <td>{{$curso->tel_repre}}</td>
                    <td>{{$curso->nombre}}</td>
                    <td>{{$curso->vincu}}</td>
                    @if ($curso->tcapacitacion == 'PRESENCIAL')
                        <td>{{$curso->efisico}}</td>
                    @endif
                    <td>{{$curso->nota_vincu}}</td>
                </tr>
            </table>
            <div>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sin más por el momento, le envío un cordial saludo.</p>
            </div>
            <table class="tablaf">
                <tr>
                    <td>
                        <p>ELABORÓ</p><br><br><br><br><br><br>
                        <p>{{ $reg_unidad->vinculacion }}</p><br>_____________________________________________________
                        <br>
                        <p>{{ $reg_unidad->pvinculacion }}</p>
                    </td>
                    <td>
                        <p>RECIBE</p><br><br><br><br><br><br>
                        <p>{{ $reg_unidad->academico }}</p><br>_____________________________________________________
                        <br>
                        <p>{{ $reg_unidad->pacademico }}</p>
                    </td>
                    <td>
                        <p>Vo. Bo.</p><br><br><br><br><br><br>
                        <p>{{ $reg_unidad->dunidad }}</p><br>_____________________________________________________
                        <br>
                        <p>{{ $reg_unidad->pdunidad }}</p>
                    </td>
                </tr>
            </table>
            <br>
            <div>
                <img style="width:150px; height:50px; float: right;" src='img/icatech-imagen.png'>
            </div>
        </div>
    </main>
    <footer></footer>
    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(50, 570, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 8);
            ');
        }
    </script>
</body>
</html>