<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');
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

    public function login(Request $request){
        if($request->isMethod('post')) {

            if(true) {
                return view('shared.complete.200');
            }else{
                return view('shared.complete.404')
                    ->with('mensaje','No se creo el usuario');
            }
        }else{
            return view('shared.complete.404')
                ->with('mensaje','Metodo no aceptado');
        }
    }
}