<?php

namespace App\Http\Controllers;

use Mail;
use App\Denuncia;
use App\Token;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class DenunciaController extends Controller
{

    /*
     * Frontend
     */
    public function formulario()
    {
        return view('denuncia.formulario');
    }

    public function filtro()
    {
        $denuncias = Denuncia::where('status', 'exists', true)
            ->where('status', '=',0)
            ->orderBy('created_at', 'desc')
            ->get();
        $totalDenuncias = $denuncias->count();
        return view("denuncia.filtro")
            ->with('denuncias', $denuncias)
            ->with('total', $totalDenuncias);
    }

    public function denuncias()
    {
        $denuncias = Denuncia::where('status', 'exists', true)
            ->where('status', '=', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        $totalDenuncias = $denuncias->count();
        return view('denuncia.denuncias')
            ->with('denuncias', $denuncias)
            ->with('total', $totalDenuncias);
    }

    public function mapa()
    {
        $denuncias = Denuncia::where('status', 'exists', true)
            ->where('status', '=', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        $totalDenuncias = $denuncias->count();
        return view('denuncia.mapa')
            ->with('denuncias', $denuncias)
            ->with('total', $totalDenuncias);
    }

    /*
     * Backend
     */
    public function generarTokens(Request $request){
        if ($request->isMethod('get')) {
            $tiempo = time();
            $clave = '2018CyDORG-' . $tiempo;
            $token = password_hash($clave, PASSWORD_BCRYPT);
            $aleatorio = password_hash(time(), PASSWORD_BCRYPT);
            $aleatorio2 = password_hash("Morena" . time(), PASSWORD_BCRYPT);
            $obj = new Token();
            $obj->tiempo = $tiempo;
            $obj->token = $token;
            $obj->save();
            return response()->json(['app' => $aleatorio2, 'version' => "1.2.19.u.2", 'from' => $token, 'auth' => $aleatorio], 200);
        } else {
            return response()->json(['error' => 'error inesperado'], 401);
        }

    }

    public function insertarDenuncia(Request $request){
        if ($request->isMethod('post')) {

            $this ->validate($request, [
                'usuario' => 'bail|required',
                'latitud' => 'bail|required',
                'longitud' => 'bail|required',
                'estado' =>'bail|required',
                'municipio' => 'bail|required',
                'colonia' => 'bail|required',
                'direccion' => 'bail|required',
                'cp' => 'bail|required',
                'descripcion' => 'bail|required',
                'tipo'=> 'bail|required',
                'nosotros' => 'bail|required',
                'fecha' => 'bail|required',
                'token' => 'bail|required'
            ]);

            $usuarioToken = $request->input('token', 0);
            $token = Token::where('token',$usuarioToken)->first();
            if($token){
                $now = time();
                $diff =  $now - $token->tiempo;
                $diff = floor($diff / 60);
                if($diff >= 5){
                    return response()->json(['Error' => 'Tiempo de sesion finalizado'], 401);
                }
            }else {
                return response()->json(['Error' => 'Por el momento no se puede procesar'], 400);
            }

            $denuncia = new Denuncia();
            $denuncia->usuario = $request->usuario;
            $denuncia->latitud = (double)$request->latitud;
            $denuncia->longitud = (double)$request->longitud;
            $denuncia->estado = $request->estado;
            $denuncia->municipio = $request->municipio;
            $denuncia->colonia = $request->colonia;
            $denuncia->direccion = $request->direccion;
            $denuncia->cp = $request->cp;
            $denuncia->descripcion = $request->descripcion;
            $denuncia->tipo = $request->tipo;
            $denuncia->nosotros = (boolean)$request->nosotros;
            $denuncia->fecha = date('Y-m-d H:i:s', strtotime($request->fecha));

            if ($request->has('nombre')){
                $denuncia->nombre = $request->nombre;
            }
            if ($request->has('tel')){
                $denuncia->telefono = $request->tel;
            }
            if ($request->has('email')){
                $denuncia->email = $request->email;
            }
            $denuncia->status = 0;

            if ($denuncia->save()) {
                if($request->has('archivos')){
                    $archivos = $request->allFiles();
                    $documento = Denuncia::project(['id' => 1])->findOrFail($denuncia->id);
                    $pathFiles = Array();
                    foreach ($archivos as $archivo){
                        $mime = explode('/',$archivo->getMimeType());
                        if($mime[0] == 'video'){
                            $nuevoArchivo = $archivo->move('.', str_random(6).'.mp4');
                            array_push($pathFiles, Storage::disk('s3')->putFile('denuncias/'.$denuncia->id, new File($nuevoArchivo)));
                        } elseif($mime[0] == 'image'){
                            $nuevoArchivo = $archivo->move('.', str_random(6).'.jpeg');
                            array_push($pathFiles, Storage::disk('s3')->putFile('denuncias/'.$denuncia->id, new File($nuevoArchivo)));
                        }
                    }
                    $documento->archivos = $pathFiles;
                    if($documento->save()){
                        return response()->json(['mensaje' => 'exito'], 200);
                    } else {
                        return response()->json(['error' => 'no se subieron los archivos'], 400);
                    }
                }
                return response()->json(['mensaje' => 'exito'], 200);
            } else {
                return response()->json(['error' => 'no se creo el documento'], 404);
            }
        } else {
            return response()->json(['error' => 'datos incompletos'], 400);
        }

    }

    public function obetenerStatus($id){
        try{
            $status = Denuncia::project([ 'status' => 1])->findOrFail($id);

            if($status->status != 0){
                return false;
            }
            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function aprobarDenuncia(Request $request){
        if ($request->isMethod('post') && $request->has('id')) {
            if($this->obetenerStatus($request->id)){
                try{
                    $status = Denuncia::project([ 'status' => 1])->findOrFail($request->id);
                    $status->status = 1;
                    if($status->save()){
                        return response()->json(['denuncia' => 'aprobada'], 200);
                    }
                    return response()->json(['error' => 'no se aprobo la denuncia'], 400);
                } catch (ModelNotFoundException $e) {
                    return response()->json(['error' => 'no se encontro documento'], 400);
                }
            } else {
                return response()->json(['error' => 'no se aprobo'], 400);
            }
        } else {
            return response()->json(['error' => 'datos incompletos'], 400);
        }
    }

    public function rechazarDenuncia(Request $request){
        if ($request->isMethod('post') && $request->has('id')) {
            if($this->obetenerStatus($request->id)){
                try{
                    $status = Denuncia::project([ 'status' => 1])->findOrFail($request->id);
                    $status->status = 2;
                    if($status->save()){
                        return response()->json(['denuncia' => 'rechazada'], 200);
                    }
                    return response()->json(['error' => 'no se rechazo la denuncia'], 400);
                } catch (ModelNotFoundException $e) {
                    return response()->json(['error' => 'no se encontro documento'], 400);
                }
            } else {
                return response()->json(['error' => 'no se aprobo'], 400);
            }
        } else {
            return response()->json(['error' => 'datos incompletos'], 400);
        }
    }

    public function enviarEmail(Request $request)
    {
        if ($request->isMethod('post') && $request->header('api_token') == 'RU13U3BtN0xNcXdBOTB6bzZGVjFUNGc5YmNvazY3TmFMUjNaZjkyOA==') {
            try{
                $denuncia = Denuncia::findOrFail($request->id);

                Mail::send('respuestas.200', ['denuncia' => $denuncia], function ($m) {
                    $m->from(env('MAIL_FROM_ADDRESS'), 'Denuncia');
                    $m->to('jonatan_moralest@hotmail.com')->subject('Corrobora y Denuncia: Denuncia Ciudadana');
                });
                return response()->json(['error' => 'no se rechazo la denuncia'], 400);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'no se encontro documento'], 400);
            }

        } else {
            return response()->json(['error' => 'datos incompletos'], 400);
        }
    }

}