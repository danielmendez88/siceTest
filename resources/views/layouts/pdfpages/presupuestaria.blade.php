<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="{{ public_path('vendor/bootstrap/3.4.1/bootstrap.min.css') }}">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-wfSDFE50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <style>
            body{
                font-family: sans-serif;
      font-size: 1.3em;
      margin: 10px;
            }
            @page {
                margin: 110px 40px 80px;
            }
            header {
            position: fixed;
            left: 0px;
            top: -80px;
            right: 0px;
            color: black;
            text-align: center;
            line-height: 60px;
            height: 60px;
            }
            header h1{
            margin: 10px 0;
            }
            header h2{
            margin: 0 0 10px 0;
            }
            footer {
            position: fixed;
            left: 0px;
            bottom: -10px;
            right: 0px;
            height: 60px;
            text-align: center;
            line-height: 60px;
            }
            img.izquierda {
                float: left;
                width: 300px;
                height: 60px;
            }

            img.izquierdabot {
                float: inline-end;
                width: 350px;
                height: 60px;
            }

            img.derecha {
                float: right;
                width: 200px;
                height: 60px;
            }
            div.content
            {
                margin-bottom: 750%;
                margin-right: -25%;
                margin-left: 0%;
            }
        </style>
    </head>
    <body>
        <header>
            <img class="izquierda" src="{{ public_path('img/instituto_oficial.png') }}">
            <img class="derecha" src="{{ public_path('img/chiapas.png') }}">
            <br><h6>"2021, Año de la Independencia"</h6>
        </header>
        <footer>
            <img class="izquierdabot" src="{{ public_path('img/franja.png') }}">
            <img class="derecha" src="{{ public_path('img/icatech-imagen.png') }}">
        </footer>
        <div class= "container g-pt-30">
            <div align=right> <b>Unidad de Capacitación {{$unidad->ubicacion}}</b> </div>
            <div align=right> <b>Memorandum No. {{$data_supre->no_memo}}</b></div>
            <div align=right> <b>{{$data_supre->unidad_capacitacion}}, Chiapas {{$D}} de {{$M}} del {{$Y}}.</b></div>

            <br><br><b>{{$getdestino->nombre}} {{$getdestino->apellidoPaterno}} {{$getdestino->apellidoMaterno}}.</b>
            <br>{{$getdestino->puesto}}
            <br><br>Presente.

            <br><p class="text-justify">Por medio del presente me permito solicitar suficiencia presupuestal, en la partida 12101 Honorarios, para la contratación de instructores para la impartición de cursos de la
                @if ($unidad->cct == '07EI')
                    Unidad de Capacitación <b>{{$unidad->ubicacion}}</b>,
                @else
                    Acción Movil <b>{{$data_supre->unidad_capacitacion}}</b>,
                @endif
                 de acuerdo a los números de folio que se indican en el cuadro analítico siguiente y acorde a lo que se describe en el formato anexo.</p>
            <br><div align=justify><b>Números de Folio</b></div>

            <table class="table table-bordered">
                <thead>
                </thead>
                <tbody>
                    @foreach ($data_folio as $key=>$value )
                        @if ($key == 0 || $key == 3 || $key == 6 || $key == 9 || $key == 12 || $key == 15 || $key == 18 || $key == 21)
                        <tr><td>{{$value->folio_validacion}}</td>
                        @else
                        <td>{{$value->folio_validacion}}</td>
                        @endif
                        @if ($key == 2 || $key == 5 || $key == 8 || $key == 11 || $key == 14 || $key == 17 || $key == 20)
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <br><p class="text-left"><p>Sin más por el momento, aprovecho la ocasión para enviarle un cordial saludo.</p></p>
            <br><p class="text-left"><p>Atentamente.</p></p>
            <br><br><b>{{$getremitente->nombre}} {{$getremitente->apellidoPaterno}} {{$getremitente->apellidoMaterno}}</b>
            <br><b>{{$getremitente->puesto}} {{$getremitente->area}}</b>
            <br><b>Unidad de Capacitación {{$unidad->ubicacion}}.</b>
            @if ($unidad->cct != '07EI')
                <br><b>Acción Movil {{$data_supre->unidad_capacitacion}}.</b>
            @else
            @endif
            <br><br><br><h6><small><b>C.c.p. C.P. {{$getccp1->nombre}} {{$getccp1->apellidoPaterno}} {{$getccp1->apellidoMaterno}}.-{{$getccp1->puesto}}.-Mismo Fin</b></small></h6>
            <h6><small><b>C.P. {{$getccp2->nombre}} {{$getccp2->apellidoPaterno}} {{$getccp2->apellidoMaterno}}.-{{$getccp2->puesto}}.-Mismo Fin</b></small></h6>
            <h6><small><b>Archivo/Minutario<b></small></h6>
            <br><br><small><b>Valido: {{$getvalida->nombre}} {{$getvalida->apellidoPaterno}} {{$getvalida->apellidoMaterno}}.-{{$getvalida->puesto}}</b></small></h6>
            <br><small><b>Elaboró:  {{$getelabora->nombre}} {{$getelabora->apellidoPaterno}} {{$getelabora->apellidoMaterno}}.-{{$getelabora->puesto}}</b></small></h6>
        </div>
    </body>
</html>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
