<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ public_path('vendor/bootstrap/3.4.1/bootstrap.min.css') }}">
    <style>
        @page {
            margin: 0cm 0cm;
        }

        body {
            margin: 3cm 2cm 2cm;
            font-family: sans-serif;
            font-size: 1.3em;
        }

        header {
            position: fixed;
            margin-top: 2px;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            color: black;
            text-align: center;
            line-height: 30px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #2a0927;
            color: white;
            text-align: center;
            line-height: 35px;
        }
        img.izquierda {
            float: left;
            width: 200px;
            height: 60px;
            margin-left: 1em;
            margin-top: 0.5em;
        }
        img.izquierdabot {
            float: inline-end;
            width: 350px;
            height: 60px;
            margin-left: 1em;
            margin-top: 1em;
        }
        img.derecha {
            float: right;
            width: 200px;
            height: 60px;
            margin-right: 1em;
            margin-top: 1em;
        }
    </style>
</head>
<body>
    <header>
        <img class="izquierda" src="{{ public_path('img/instituto_oficial.png') }}">
        <img class="derecha" src="{{ public_path('img/chiapas.png') }}">
        <br><h5>SID PARA CERSO (CERSS)</h5>
    </header>

    <main>
        <table class="table tds">
            <colgroup>
                <col style="width: 33%"/>
                <col style="width: 33%"/>
                <col style="width: 33%"/>
            </colgroup>
            <tbody>
                <tr>
                    <td style="border: hidden">
                        <small>
                            <div class="centrados">
                                SASDDSADSA
                                <div class="linea"></div>
                                <br>FECHA
                            </div>
                        </small>
                    </td>
                    <td style="border: hidden">
                        <small>
                            <div class="centrados">
                                123454645
                                <div class="linea"></div>
                                N°. DE CONTROL
                            </div>
                        </small>
                    </td>
                    <td style="border: hidden">
                        <small>
                            <div class="centrados">
                                ALUMNOS
                                <div class="linea"></div>
                                NÚMERO DE SOLICITUD
                            </div>
                        </small>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>

    <footer>
        <h1>www.styde.net</h1>
    </footer>
</body>
</html>
