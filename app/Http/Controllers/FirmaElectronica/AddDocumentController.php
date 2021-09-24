<?php

namespace App\Http\Controllers\FirmaElectronica;

use Carbon\Carbon;
use App\Models\Personal;
use App\Models\contratos;
use Spatie\PdfToText\Pdf;
use App\Models\instructor;
use Illuminate\Http\Request;
use Spatie\ArrayToXml\ArrayToXml;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\FirmaElectronica\DocumentosFirmar;

class AddDocumentController extends Controller {

    public function index() {
        return view('layouts.FirmaElectronica.addDocumentFirma');
    }

    public function search(Request $request) {
        $tipo = $request->tipo;
        $email = $request->email;

        if ($tipo == 1) { //tabla instructor
            $firmante = instructor::where('correo', '=', $email)
                ->where('status', '=', 'Validado')
                ->where('estado', '=', true)
                ->first();
        } else { // tabla directorio
            $firmante = Personal::where('email', '=', $email)
                ->where('activo', '=', true)
                ->first();
        }

        return response()->json($firmante);
    }

    public function save(Request $request) {
        $dataEmisor = Personal::where('email', Auth::user()->email)->first();
        if ($request->hasFile('doc')) {
            $data = contratos::where('numero_contrato', $request->no_oficio)->first();
            if ($data) {
                if ($request->firmas != null) {
                    $nameFileOriginal = $request->file('doc')->getClientOriginalName();
                    $nameFile = trim(date('YmdHis').'_'.$nameFileOriginal);
                    $numFirmantes = count($request->firmas);

                    $arrayFirmantes = []; $arrayFirmantes2 = [];
                    if ($request->firmare != null) {
                        $numFirmantes++;
                        $temp = ['_attributes' => 
                                    [
                                        'curp_firmante' => $dataEmisor->curp, 
                                        'nombre_firmante' => $dataEmisor->nombre.' '.$dataEmisor->apellidoPaterno.' '.$dataEmisor->apellidoMaterno, 
                                        'email_firmante' => $dataEmisor->correo, 
                                        'tipo_firmante' => 'FM'
                                    ]
                                ];
                        $temp2 =['_attributes' => 
                                    [
                                        'curp_firmante' => $dataEmisor->curp, 
                                        'nombre_firmante' => $dataEmisor->nombre.' '.$dataEmisor->apellidoPaterno.' '.$dataEmisor->apellidoMaterno, 
                                        'email_firmante' => $dataEmisor->correo, 
                                        'tipo_firmante' => 'FM',
                                        'tipo_usuario' => 2,
                                        'puesto_firmante' => $dataEmisor->puesto,
                                        'fecha_firmado_firmante' => '',
                                        'no_serie_firmante' => '',
                                        'firma_firmante' => '',
                                    ]
                                ];
                        array_push($arrayFirmantes, $temp);
                        array_push($arrayFirmantes2, $temp2);
                    }

                    foreach ($request->firmas as $firmante) {
                        $array = explode('-', $firmante);
                        if ($array[0] == 'Instructor') {
                            $dataFirmante = instructor::where('id', '=', $array[1])->first();
                            $temp = ['_attributes' => 
                                [
                                    'curp_firmante' => $dataFirmante->curp, 
                                    'nombre_firmante' => $dataFirmante->nombre.' '.$dataFirmante->apellidoPaterno.' '.$dataFirmante->apellidoMaterno, 
                                    'email_firmante' => $dataFirmante->correo, 
                                    'tipo_firmante' => 'FM'
                                ]
                            ];
                            $temp2 = ['_attributes' => 
                                [
                                    'curp_firmante' => $dataFirmante->curp, 
                                    'nombre_firmante' => $dataFirmante->nombre.' '.$dataFirmante->apellidoPaterno.' '.$dataFirmante->apellidoMaterno, 
                                    'email_firmante' => $dataFirmante->correo, 
                                    'tipo_firmante' => 'FM',
                                    'tipo_usuario' => 1,
                                    'puesto_firmante' => 'INSTRUCTOR',
                                    'fecha_firmado_firmante' => '',
                                    'no_serie_firmante' => '',
                                    'firma_firmante' => ''
                                ]
                            ];
                        } else {
                            $dataFirmante = Personal::where('id', '=', $array[1])->first();
                            $temp = ['_attributes' => 
                                [
                                    'curp_firmante' => $dataFirmante->curp, 
                                    'nombre_firmante' => $dataFirmante->nombre.' '.$dataFirmante->apellidoPaterno.' '.$dataFirmante->apellidoMaterno, 
                                    'email_firmante' => $dataFirmante->email, 
                                    'tipo_firmante' => 'FM'
                                ]
                            ];
                            $temp2 = ['_attributes' => 
                                [
                                    'curp_firmante' => $dataFirmante->curp, 
                                    'nombre_firmante' => $dataFirmante->nombre.' '.$dataFirmante->apellidoPaterno.' '.$dataFirmante->apellidoMaterno, 
                                    'email_firmante' => $dataFirmante->email, 
                                    'tipo_firmante' => 'FM',
                                    'tipo_usuario' => 2,
                                    'puesto_firmante' => $dataFirmante->puesto,
                                    'fecha_firmado_firmante' => '',
                                    'no_serie_firmante' => '',
                                    'firma_firmante' => ''
                                ]
                            ];
                        }
                        array_push($arrayFirmantes, $temp);
                        array_push($arrayFirmantes2, $temp2);
                    }
                    
                    $text = Pdf::getText($request->file('doc'), 'c:/Program Files/Git/mingw64/bin/pdftotext');
                    $text = str_replace("\f",' ',$text);

                    $ArrayXml = [
                        'emisor' => [
                            '_attributes' => [
                                'nombre_emisor' => $dataEmisor->nombre.' '.$dataEmisor->apellidoPaterno.' '.$dataEmisor->apellidoMaterno,
                                'cargo_emisor' => $dataEmisor->puesto,
                                'dependencia_emisor' => 'INSTITUTO DE CAPACITACION Y VINCULACION TECNOLOGICA'
                            ],
                        ],
                        'archivo' => [
                            '_attributes' => [
                                'nombre_archivo' => $nameFileOriginal,
                                'checksum_archivo' => utf8_encode($text)
                            ],
                            'cuerpo' => ['Por medio de la presente me permito solicitar el archivo '.$nameFile]
                        ],
                        'firmantes' => [
                            '_attributes' => [
                                'num_firmantes' => $numFirmantes
                            ],
                            'firmante' => [
                                $arrayFirmantes
                            ]
                        ], 
                    ];

                    $ArrayXml2 = [
                        'emisor' => [
                            '_attributes' => [
                                'nombre_emisor' => $dataEmisor->nombre.' '.$dataEmisor->apellidoPaterno.' '.$dataEmisor->apellidoMaterno,
                                'cargo_emisor' => $dataEmisor->puesto,
                                'dependencia_emisor' => 'INSTITUTO DE CAPACITACION Y VINCULACION TECNOLOGICA',
                                'email' => Auth::user()->email
                            ],
                        ],
                        'archivo' => [
                            '_attributes' => [
                                'nombre_archivo' => $nameFileOriginal,
                                'checksum_archivo' => utf8_encode($text)
                            ],
                            'cuerpo' => ['Por medio de la presente me permito solicitar el archivo '.$nameFile]
                        ],
                        'firmantes' => [
                            '_attributes' => [
                                'num_firmantes' => $numFirmantes
                            ],
                            'firmante' => [
                                $arrayFirmantes2
                            ]
                        ], 
                    ];

                    $date = Carbon::now();
                    $month = $date->month < 10 ? '0'.$date->month : $date->month;
                    $day = $date->day < 10 ? '0'.$date->day : $date->day;
                    $hour = $date->hour < 10 ? '0'.$date->hour : $date->hour;
                    $minute = $date->minute < 10 ? '0'.$date->minute : $date->minute;
                    $second = $date->second < 10 ? '0'.$date->second : $date->second;
                    $dateFormat = $date->year.'-'.$month.'-'.$day.'T'.$hour.':'.$minute.':'.$second;

                    $result = ArrayToXml::convert($ArrayXml, [
                        'rootElementName' => 'DocumentoChis',
                        '_attributes' => [
                            'version' => '1.0',
                            'fecha_creacion' => $dateFormat,
                            'no_oficio' => $nameFile,
                            'dependencia_origen' => 'INSTITUTO DE CAPACITACION Y VINCULACION TECNOLOGICA DEL ESTADO DE CHIAPAS',
                            'asunto_docto' => $request->tipo_documento,
                            'tipo_docto' => 'CNT',
                            'xmlns' => 'http://firmaelectronica.chiapas.gob.mx/GCD/DoctoGCD',
                        ],
                    ]);

                    $result2 = ArrayToXml::convert($ArrayXml2, [
                        'rootElementName' => 'DocumentoChis',
                        '_attributes' => [
                            'version' => '1.0',
                            'fecha_creacion' => $dateFormat,
                            'no_oficio' => $nameFile,
                            'dependencia_origen' => 'INSTITUTO DE CAPACITACION Y VINCULACION TECNOLOGICA DEL ESTADO DE CHIAPAS',
                            'asunto_docto' => $request->tipo_documento,
                            'tipo_docto' => 'CNT',
                            'xmlns' => 'http://firmaelectronica.chiapas.gob.mx/GCD/DoctoGCD',
                        ],
                    ]);

                    $xmlBase64 = base64_encode($result);
                    $response = Http::post('https://interopera.chiapas.gob.mx/FirmadoElectronicoDocumentos/api/v1/DocumentoXml/CadenaOriginalBase64', [
                        'xml_OriginalBase64' => $xmlBase64,
                        'apiKey' => 'dwLChYOVylB9htqD9qIaSVHddKzWKiqXqmh7fFRHwFJk2x'
                    ]);

                    if ($response->json()['cadenaOriginal'] != null) {
                        $urlFile = $this->uploadFileServer($request->file('doc'), $nameFileOriginal);
                        $datas = explode('*',$urlFile);

                        $dataInsert = new DocumentosFirmar();
                        $dataInsert->obj_documento = json_encode($ArrayXml);
                        $dataInsert->obj_documento_interno = json_encode($ArrayXml2);
                        $dataInsert->status = 'EnFirma';
                        $dataInsert->link_pdf = $datas[0];
                        $dataInsert->cadena_original = $response->json()['cadenaOriginal'];
                        $dataInsert->tipo_archivo = $request->tipo_documento;
                        $dataInsert->numero_o_clave = $request->no_oficio;
                        $dataInsert->nombre_archivo = $datas[1];
                        $dataInsert->documento = $result;
                        $dataInsert->documento_interno = $result2;
                        $dataInsert->save();

                        return redirect()->route('addDocument.inicio')->with('warning', 'Se agrego el documento correctamente, puede ver el status en el que se encuentra en el apartado Firma Electronica');
                    } else {
                        return back()->with('warning', 'Ocurrio un error al obtener la cadena original, por favor intente de nuevo');
                    }
                } else {
                    return back()->with('warning', 'No se agregaron firmantes');
                }
            } else {
                return back()->with('warning', 'No se encontro el contrato con el número ingresado');
            }
        } else {
            return redirect()->route('addDocument.inicio')->with('warning', 'Debe seleccionar un archivo PDF');
        }
    }

    protected function uploadFileServer($file, $name) {
        // $extensionFile = $file->getClientOriginalExtension();
        // $path = '/'.$subPath;
        $name = trim(date('YmdHis').'_'.$name);
        $file->storeAs('/uploadFiles/DocumentosFirmas/'.Auth::user()->id, $name);
        $url = Storage::url('/uploadFiles/DocumentosFirmas/'.Auth::user()->id.'/'.$name);
        return $url.'*'.$name;
    }
}
