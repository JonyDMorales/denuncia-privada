<?php
namespace App\Http\Controllers;

use App\User;
use App\Configuraciones;
use Illuminate\Http\Request;

class UserController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');
    }

    public function configuracion(){
        $id = '5b9c35f4c489b90496853a3e';
        $configuraciones = Configuraciones::project(['post' => 1, "fields" => 1])->findOrFail($id);
        return view('admin.configuraciones') ->with("configuraciones", $configuraciones);
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
                    ->with('destino', 'registrar');
            }else{
                return view('shared.complete.404')
                    ->with('mensaje','No se creo el usuario');
            }
        }else{
            return view('shared.complete.404')
                ->with('mensaje','Metodo no aceptado');
        }
    }

    public function agregarCampo(Request $request){
        $id = '5b9c35f4c489b90496853a3e';
        $campo = $request->campo;
        $configuraciones = Configuraciones::project(["fields" => 1])->findOrFail($id);
        $configuraciones->fields = array_add($configuraciones->fields, "campo ".str_random(4), $campo);
        if ($configuraciones->save()){
            return view('shared.complete.200')
                ->with('mensaje', 'Campo agregado')
                ->with('destino', 'configuraciones');
        } else {
            return view('shared.complete.404')
                ->with('mensaje','Campo no agregado');
        }
    }

    public function cambiarPost(Request $request){
        $id = '5b9c35f4c489b90496853a3e';
        $opcion = $request->opcion;
        $configuraciones = Configuraciones::project(['post' => 1])->findOrFail($id);
        if($opcion[0] == '1') {
            $configuraciones->post = true;
        } else {
            $configuraciones->post = false;
        }
        if ($configuraciones->save()){
            return view('shared.complete.200')
                ->with('mensaje', 'Post Cambiado')
                ->with('destino', 'configuraciones');
        } else {
            return view('shared.complete.404')
                ->with('mensaje','Post no cambiado');
        }
    }

}