<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MEMORANDUM VALIDACION PAQUETERIAS</title>
    <style>
        body {
            font-family: sans-serif
        }

        @page {
            margin: 40px 70px 10px 70px;
        }

        header {
            position: fixed;
            left: 0px;
            top: 10px;
            right: 0px;
            text-align: center;
        }

        header h1 {
            height: 0;
            line-height: 14px;
            padding: 9px;
            margin: 0;
        }

        header h2 {
            margin-top: 20px;
            font-size: 14px;
            border: 1px solid gray;
            padding: 12px;
            line-height: 18px;
            text-align: justify;
        }

        footer {
            position: fixed;
            left: 0px;
            bottom: -170px;
            height: 150px;
            width: 100%;
        }

        footer .page:after {
            content: counter(page, sans-serif);
        }

        img.izquierda {
            float: left;
            width: 200px;
            height: 60px;
        }

        img.izquierdabot {
            position: absolute;
            left: 50px;
            width: 350px;
            height: 60px;
        }

        img.derechabot {
            position: absolute;
            right: 50px;
            width: 350px;
            height: 60px;
        }

        img.derecha {
            float: right;
            width: 200px;
            height: 60px;
        }

        /* .tablas{border-collapse: collapse;width: 990px;}
        .tablas tr{font-size: 7px; border: gray 1px solid; text-align: center; padding: 0px;}
        .tablas th{font-size: 7px; border: gray 1px solid; text-align: center; padding: 0px;}
        .tablaf { border-collapse: collapse; width: 100%;border: gray 1px solid; }     
        .tablaf tr td { font-size: 7px; text-align: center; padding: 0px;}
        .tablad { border-collapse: collapse;font-size: 7px;border: gray 1px solid; text-align: left; padding:0px;}  */
        .tablag {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        .tablag tr td {
            font-size: 14px;
            padding: 1px;
        }

        .tablag .strong {
            font-size: 16px;
            padding: 1px;
        }

        .variable {
            border-bottom: gray 1px solid;
            border-left: gray 1px solid;
            border-right: gray 1px solid
        }

        .tablab {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        .tablab tr {
            font-size: 14px;
            padding: 1px;
            border: gray 1px solid;
        }

        .tablab th {
            font-size: 14px;
            padding: 1px;
            border: gray 1px solid;
        }

        .tablab td {
            font-size: 14px;
            padding: 1px;
            border: gray 1px solid;
        }
    </style>
</head>

<body>
    <header>
        <img class="izquierda" src="{{ public_path('img/instituto_oficial.png') }}">
        <img class="derecha" src="{{ public_path('img/chiapas.png') }}">
        <br>
        <h6></h6>
    </header>
    <footer>
        <img class="izquierdabot" src="{{ public_path('img/franja.png') }}">
        <img class="derechabot" src="{{ public_path('img/icatech-imagen.png') }}">
    </footer>
    <div id="wrapper">
        <div align=center><b>
                <h6>
                    <br>
                    <br>
                    <br><br>
                    <br>
                    <h2 style="font-style: italic;">"2022, Año de Ricardo Flores Magón, Precursor de la Revolución Mexicana"</h2>
        </div>
    </div>
    <table class="tablag">

        <body>
            <tr>
                <td class="strong" align="right"><b>Dirección Técnica Académica</b></td>
            </tr>
            <tr>
                <td align="right">Memorandum NO. {{ $memo }}</td>
            </tr>
            <tr>
                <td align="right">TUXTLA GUTIÉRREZ, CHIAPAS; {{ $fecha_actual }}.</td>
            </tr>
        </body>
    </table><br>
    <table class="tablag">

        <body>
            <tr>
                <td class="" align="left">{{ $unidad->dunidad }}</td>
            </tr>
            <tr>
                <td align="left">{{ $unidad->pdunidad }}</td>
            </tr>
        </body>
    </table><br>

    <br>
    <p style="text-align:justify;">Por este medio solicitud la <u>{{$curso->tipoSoli}}</u>, y en caso de cumplir con los criterios de la Evaluacion con un porcentaje igual o mayor al 90%; la Validacion de la paqueteria didactica que se detella a continuacion. </p>
    <table class="tablab">

        <body>
            <tr>
                <td align="left" colspan="3"><b>Nombre del curso:</b> {{ $curso->nombre_curso }}</td>
            </tr>
            <tr>
                <td align="left" colspan="3"><b>Especialidad:</b> {{ $curso->categoria }} </td>
            </tr>
            <tr>
                <td align="left" colspan="3"><b>Clasificacion:</b> {{ $curso->clasificacion }} </td>
            </tr>
            <tr>
                <td align="left"><b>Modalidad:</b> {{ $curso->modalidad }} </td>
                <td align="left"><b>Duracion:</b> {{ $curso->horas }}</td>
                <td align="left"><b>Autorizacion de Riesgo:</b></td>
            </tr>
            <tr>
                <td align="left" colspan="3"><b>Perfil de Ingreso del Alumno : </b>{{ $carta_descriptiva->perfilidoneo }}</td>
            </tr>
            <tr>
                <td align="left" colspan="3"><b>Perfil del Instructor : </b>{{ $carta_descriptiva->perfilidoneo }}</td>
            </tr>
            <tr>
                <td align="left" colspan="3">
                    <ul>
                        <li><b>Objetivo General: </b>{{ $carta_descriptiva->perfilidoneo }}</li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td align="left" colspan="3">
                    <ul>
                        <li><b>Observaciones:  </b>{{ $curso->motivoSoli }}</li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td align="left" colspan="3">Clasificacion: {{ $curso->clasificacion }}</td>
            </tr>
            <tr>
                <td align="left" colspan="2">Tipo de capacitacion: {{ $curso->tipo_curso }}</td>
                <td align="left"></td>
            </tr>
            <tr>
                <td align="justify" colspan="3">Observaciones: {{ $curso->motivoSoli }}</td>
            </tr>
        </body>
    </table><br>
    <br>
    <p class="text-left">
    <p>Sin más por el momento, aprovecho la ocasión para enviarle un cordial saludo.</p>
    </p>
    <p class="text-left">
    <p>Atentamente.</p>
    </p><br><br><br><br>
    <label style="font-size:14px;"><b>Lic. {{ $unidad->dunidad }}</b></label>
    <br><label style="font-size:14px;"><b>{{ $unidad->pdunidad }}</b></label>

    <br><br><br>

    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(50, 800, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 8);
                if ($PAGE_NUM != 1) {
                    $pdf->text(600, 20, "MEMORANDUM NO. ", $font, 7);
                }
            ');
        }
    </script>
</body>

</html>