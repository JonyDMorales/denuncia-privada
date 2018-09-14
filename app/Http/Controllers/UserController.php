<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');
    }

    public function configuracion(){
        return view('admin.configuraciones');
    }

    public function insertar(Request $request){
        if($request->isMethod('post')) {
            $user = new User();
            $user->name = ucwords($request->name);
            $user->email = $request->email;
            $user->active = true;
            $user->perfil = $request->perfil;
            $user->password = bcrypt($request->password);
            if($user->save()) {
                return view('shared.complete.200')
                    ->with('mensaje', 'Usuario creado')
                    ->with('destino', 'usuarios');
            }else{
                return view('shared.complete.404')
                    ->with('mensaje','No se creo el usuario');
            }
        }else{
            return view('shared.complete.404')
                ->with('mensaje','Metodo no aceptado');
        }
    }

    public function postFacebook(Request $request){
        $client = new \GuzzleHttp\Client();
        $id = '171014026947611';
        $token = 'EAADPN6Uo7GUBALbJIFd7kOEXcZCJAGNartBSNZBDAIKRcGDdyD7ZCTWZBBn9IeRka8RXCZBpc8OYvHA6WlbqS3rzoZBwNwCMtPnlmk9BGiwJPZBYbQF4iSsbXI7R1ZAfKAc9VJtH86t8JG076CFNVSKzIMdjpqZC1tlcdpVNDZBGFF9x25BVQfBOcfFAF4TghjD8eeBNpF9zjtYwZDZD';
        $res = $client->request('POST','https://graph.facebook.com/'.$id.'/feed?access_token='.$token.'&message='+ $request->denuncia);
        if( $res->getStatusCode() == '200'){
            return view('shared.complete.200')
                ->with('mensaje', 'Usuario creado')
                ->with('destino', 'usuarios');
        }
        return view('shared.complete.404')
            ->with('mensaje','Metodo no aceptado');
    }


}