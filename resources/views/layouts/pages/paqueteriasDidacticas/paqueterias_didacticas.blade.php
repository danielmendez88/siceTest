@extends('theme.sivyc.layout') {{--AGC--}}
@section('title', 'Paqueterias Didacticas | SIVyC Icatech')
@section('css_content')
<link rel="stylesheet" href="{{ asset('css/paqueterias/paqueterias.css') }}" />
<link rel="stylesheet" href="{{asset('css/global.css') }}" />
<link rel="stylesheet" href="{{asset('edit-select/jquery-editable-select.min.css') }}" />

@endsection
@section('content')
<link rel="stylesheet" href="{{asset('css/global.css') }}" />
<link rel="stylesheet" href="{{asset('edit-select/jquery-editable-select.min.css') }}" />

<div class="card-header">
    Formulario de Paqueterias Didacticas
</div>

<form method="POST" action="{{route('paqueteriasGuardar',$idCurso)}}" id="creacion" enctype="multipart/form-data">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @csrf
    <div class="card card-body" style=" min-height:150px;">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        @if ($message = Session::get('warning'))
        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>
        @endif

        <div class="row bg-light" style="padding:20px">
            <div class="form-group col-md-4">
                Solicitud: <b>{{ $curso->tipoSoli }}</b>
            </div>
            <div class="form-group col-md-12">
                Estatus: <b>{{ $curso->estatus_paqueteria }}</b>
            </div>
            @if($curso->observaciones)
            <div class="form-group col-md-12">
                Observaciones: <b>{{ $curso->observaciones }}</b>
            </div>
            @endif
        </div>

        <div class="form-row">
            @can('paqueteriasdidacticas.crear')
            @if($curso->estatus_paqueteria == 'PREVALIDACION ACEPTADA')
            <div class="form-group col-md-4">
                <div class="form-group col-md-12 col-sm-12">
                    <label for="objetivos col-md-12" class="control-label">Memoramdum:</label>
                    <input type="text" placeholder="No. Memo" class="form-control" id="memo" name="memo">
                </div>
            </div>
            <div class="form-group col-md-4">
                <div class="form-group col-md-12 col-sm-12">
                    <label for="objetivos col-md-12" class="control-label">Fecha :</label>
                    <input type="date" placeholder="DD/MM/AAAA" class="form-control" id="fecha" name="fecha" value="{{ $fechaActual->format('Y-m-d') }}">
                </div>
            </div>
            <div class="form-group col-md-4">
                <div class="form-group col-md-12 col-sm-12">
                </div>
                <div class="form-group col-md-12 col-sm-12">
                    <label for="objetivos col-md-12" class="control-label"></label>
                    <a type="button" class="btn btn-primary" id="generarMemoBtn">Generar Memoramdum Solicitud</a>
                </div>
                <div class="form-group col-md-12 col-sm-12">
                    <label for="objetivos col-md-12" class="control-label"></label>
                    <a type="button" class="btn btn-primary" id="subirMemoBtn" data-toggle="modal" data-target="#myModal">Subir Memoramdum Solicitud</a>
                </div>
            </div>
            @elseif($curso->estatus_paqueteria == 'PENDIENTE POR TURNAR')
            <div class="col-md-4">
              
                <div class="col-md-12 col-sm-12">
                    <label for="objetivos col-md-12" class="control-label"></label>
                    <a type="button" class="btn btn-primary" id="turnarDta">Turnar a la DTA</a>
                </div>
               
            </div>
            
            @elseif($curso->estatus_paqueteria != 'ENVIADO A PREVALIDACION')
            
            <div class="form-group col-md-3">
                <label for="tipo" class="contro-label">Solicitud</label>
                <select class="form-control" id="tipo" name="tipoSoli">
                    <option value="" selected disabled>--SELECCIONAR--</option>
                    <option value="ACTUALIZACION">ACTUALIZACION</option>
                    <option value="INACTIVIDAD">INACTIVIDAD</option>
                    <option value="BAJA"> BAJA</option>
                </select>
            </div>

            <div class="form-group col-md-6">
                <div class="form-group col-md-12 col-sm-12">
                    <label for="objetivos col-md-12" class="control-label">Motivo:</label>
                    <textarea placeholder="Objetivos especificos por tema" class="form-control" id="motivoSoli" name="motivoSoli"></textarea>
                </div>
            </div>

            <div class="form-group col-md-3">
                <div class="form-group col-md-12 col-sm-12">
                    <button class="btn btn-primary" id="guardar">Guardar</button>
                </div>
                <div class="form-group col-md-12 col-sm-12">
                    <button class="btn btn-primary" id="send_pre_validacion">Enviar a Pre Validacion</button>
                </div>
            </div>
            @endif
            @endcan
        </div>


    </div>

    <div class="card card-body" style=" min-height:450px;">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
        @endif


        <div style="text-align: right;width:65%">
            <label for="tituloformulariocubuzon_paqueteriasrso">

            </label>
        </div>

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            @can('paqueteriasdidacticas.crear')
            <li class="nav-item">
                <a class="nav-link active" id="pills-tecnico-tab" data-toggle="pill" href="#pills-tecnico" role="tab" aria-controls="pills-tecnico" aria-selected="true">Informacion Curso</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-evalalum-tab" data-toggle="pill" href="#pills-evalalum" role="tab" aria-controls="pills-evalalum" aria-selected="false">Evaluacion Alumno</a>
            </li>
            @endcan

            <li class="nav-item active">
                <a class="nav-link " id="pills-paqdid-tab" data-toggle="pill" href="#pills-paqdid" role="tab" aria-controls="pills-paqdid" aria-selected="false">Paqueterias Didacticas</a>
            </li>

        </ul>
      
        <div class="tab-content" id="pills-tabContent">
            @can('paqueteriasdidacticas.crear')
            <div class="tab-pane fade show active" id="pills-tecnico" role="tabpanel" aria-labelledby="pills-tecnico-tab">
                @include('layouts.pages.paqueteriasDidacticas.blades.curso')
            </div>
            <div class="tab-pane fade " id="pills-evalalum" role="tabpanel" aria-labelledby="pills-evalalum-tab">
                @if($evaluacionAlumno === '[]' || $evaluacionAlumno === '""')
                @include('layouts.pages.paqueteriasDidacticas.blades.evaluacionAlumno')
                @else
                @include('layouts.pages.paqueteriasDidacticas.blades.editarEvaluacionAlumno')
                @endif
            </div>
            @endcan
            <div class="tab-pane fade" id="pills-paqdid" role="tabpanel" aria-labelledby="pills-paqdid-tab">
                @include('layouts.pages.paqueteriasDidacticas.blades.descargarPaqueteria')
            </div>
        </div>
        <br>
    </div>

</form>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
    <form action="{{ route('guardar.memo.soli.validacion',$idCurso) }}" enctype="multipart/form-data" id="pdfForm" method="post">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Memoramdum de Solicitud de Paqueterias Didacticas</h4>
            </div>
            <div class="modal-body" style="text-align:center">
                    @csrf
                    <input name="doc_memo" class="input_memo" type="file"/>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default" >Subir</button>
                </div>
            </div>
        </div>
    </form>
</div>

@section('script_content_js')
<script src="{{asset('vendor/ckeditor5-decoupled-document/ckeditor.js') }}"></script>
<script>
    //inicializacion de text areas ckeditor 5
    var editorContenidoT;
    var editorEstrategiaD;
    var editorProcesoE;
    var editorDuracionT;
    var editorContenidoE;

    var editorElementoA;
    var editorAuxE;
    var editorReferencias;
    var idCurso = <?php echo json_encode($idCurso); ?>;
    var numPreguntasaux = <?php echo count((array)$evaluacionAlumno); ?> ;
    //Define an adapter to upload the files
    class MyUploadAdapter {
        constructor(loader) {
            // The file loader instance to use during the upload. It sounds scary but do not
            // worry — the loader will be passed into the adapter later on in this guide.
            this.loader = loader;

            // URL where to send files.
            this.url = '{{ route('ckeditorUpload') }}';
            

            //
        }
        // Starts the upload process.
        upload() {
            return this.loader.file.then(
                (file) =>
                new Promise((resolve, reject) => {
                    this._initRequest();
                    this._initListeners(resolve, reject, file);
                    this._sendRequest(file);
                })
            );
        }
        // Aborts the upload process.
        abort() {
            if (this.xhr) {
                this.xhr.abort();
            }
        }
        // Initializes the XMLHttpRequest object using the URL passed to the constructor.
        _initRequest() {
            const xhr = (this.xhr = new XMLHttpRequest());
            // Note that your request may look different. It is up to you and your editor
            // integration to choose the right communication channel. This example uses
            // a POST request with JSON as a data structure but your configuration
            // could be different.
            // xhr.open('POST', this.url, true);
            xhr.open("POST", this.url, true);
            xhr.setRequestHeader("x-csrf-token", "{{ csrf_token() }}");
            xhr.responseType = "json";
        }
        // Initializes XMLHttpRequest listeners.
        _initListeners(resolve, reject, file) {
            const xhr = this.xhr;
            const loader = this.loader;
            const genericErrorText = `Couldn't upload file: ${file.name}.`;
            xhr.addEventListener("error", () => reject(genericErrorText));
            xhr.addEventListener("abort", () => reject());
            xhr.addEventListener("load", () => {
                const response = xhr.response;
                // This example assumes the XHR server's "response" object will come with
                // an "error" which has its own "message" that can be passed to reject()
                // in the upload promise.
                //
                // Your integration may handle upload errors in a different way so make sure
                // it is done properly. The reject() function must be called when the upload fails.
                if (!response || response.error) {
                    return reject(response && response.error ? response.error.message : genericErrorText);
                }
                // If the upload is successful, resolve the upload promise with an object containing
                // at least the "default" URL, pointing to the image on the server.
                // This URL will be used to display the image in the content. Learn more in the
                // UploadAdapter#upload documentation.
                resolve({
                    default: response.url,
                });
            });
            // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
            // properties which are used e.g. to display the upload progress bar in the editor
            // user interface.
            if (xhr.upload) {
                xhr.upload.addEventListener("progress", (evt) => {
                    if (evt.lengthComputable) {
                        loader.uploadTotal = evt.total;
                        loader.uploaded = evt.loaded;
                    }
                });
            }
        }
        // Prepares the data and sends the request.
        _sendRequest(file) {
            // Prepare the form data.
            
            const data = new FormData();
            data.append("upload", file);
            data.append("idCurso", idCurso);
            // Important note: This is the right place to implement security mechanisms
            // like authentication and CSRF protection. For instance, you can use
            // XMLHttpRequest.setRequestHeader() to set the request headers containing
            // the CSRF token generated earlier by your application.
            // Send the request.
            this.xhr.send(data);
        }
        // ...
    }

    function SimpleUploadAdapterPlugin(editor) {
        editor.plugins.get("FileRepository").createUploadAdapter = (loader) => {
            // Configure the URL to the upload script in your back-end here!
            return new MyUploadAdapter(loader);
        };
    }

    ClassicEditor
        .create(document.querySelector('#objetivoespecifico'), {language: 'es',})
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#aprendizajeesperado'), {language: 'es',})
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#observaciones'), {language: 'es',})
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#contenidoT-inp'), {
            extraPlugins: [SimpleUploadAdapterPlugin],
            language: 'es',
        })
        .then(editor => {
            editorContenidoT = editor;
        })
        .catch(error => {
            console.error(error);
        });


    ClassicEditor
        .create(document.querySelector('#elementoapoyo'), {
            language: 'es',
        })
        .then(editor => {
            editorElementoA = editor;
        })
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#auxenseñanza'), {
            language: 'es',
        })
        .then(editor => {
            editorAuxE = editor;
        })
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#referencias'), {
            language: 'es',
        })
        .then(editor => {
            editorReferencias = editor;
        })
        .catch(error => {
            console.error(error);
        });

    $(document).ready(function() {
        $("#guardar").click(function() {
            $('#creacion').attr('action', "{{route('paqueteriasGuardar',$idCurso)}}");
            $('#creacion').submit();
        });
        $("#send_pre_validacion").click(function() {
            $('#creacion').attr('action', "{{route('buzon.enviar.pre_validacion',$idCurso)}}");
            $('#creacion').submit();
        });
        $("#generarMemoBtn").click(function() {
            $('#creacion').attr('action', "{{route('generar.memo.soli.validacion',$idCurso)}}");
            $('#creacion').attr('target', "_blank");
            $('#creacion').submit();
        });
        $("#turnarDta").click(function() {
            $('#creacion').attr('action', "{{route('turnar.soli.dta',$idCurso)}}");
            $('#creacion').submit();
        });
        
        $("#botonCARTADESCPDF").click(function() {
            $('#creacion').attr('action', "{{route('DescargarPaqueteria',$idCurso)}}");
            $('#creacion').attr('target', "_blank");
            
            $('#creacion').submit();
        });
        $("#botonEVALALUMNPDF").click(function() {
            $('#creacion').attr('action', "{{route('DescargarPaqueteria',$idCurso)}}");
            $('#creacion').submit();
        });
        $("#botonEVALINSTRUCTORPDF").click(function() {
            $('#creacion').attr('action', "{{route('DescargarPaqueteria',$idCurso)}}");
            $('#creacion').submit();
        });
        $("#botonMANUALDIDPDF").click(function() {
            $('#creacion').attr('action', "{{route('DescargarPaqueteria',$idCurso)}}");
            $('#creacion').submit();
            // $('#alert-files').css('display', 'block');
            // $('#files-msg').text("La generacion de este archivo estara disponible pronto!");
        });

       

    });


    function guardarSoli() {

        $('#guardarSoli').remove();
        document.getElementById('creacion').submit();

    }

    function pre_validar_respuesta(idCurso) {
        console.log(idCurso);
        if ($("#observaciones").val() != '' && $("#tipoAccion").val() !== null) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post",
                url: "/buzon/pre-validacion/" + idCurso,
                dataType: "json",
                data: {
                    'tipoAccion': $("#tipoAccion").val(),
                    'observaciones': $("#observaciones").val(),
                    'idCurso': idCurso,
                },
                success: function(data) { // console.log(data); 
                    console.log(data);
                }
            });
        }
    }

    function save(blade) {
        
        var $form = $("#creacion");
        $('#creacion').attr('action', "{{route('paqueteriasGuardar',$idCurso)}}");
        $('#creacion').removeAttr('target');
       
        $form.append("<input type='hidden' name='blade' value='"+blade+"'/>");
        $('#creacion').submit();
    }
</script>
<script src="{{asset('js/catalogos/paqueteriasdidactica/paqueterias.js')}}"></script>

<script defer>
    // $('#preguntas-area-parent .card-paq').remove()
    var evaluacion = Object.values(JSON.parse({!!json_encode($evaluacionAlumno, JSON_HEX_TAG) !!}));
    //   console.log(values.length
</script>
@endsection
@endsection