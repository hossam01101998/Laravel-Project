<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //

    public function show(){
        return view('auth.login');
    }
    public function login(LoginRequest $request){
        //con esto cogemos email y password o username y password, lo que nos hace falta para login!
        $credentials = $request->getCredentials();

        if(!Auth::validate($credentials)){
            //si el usuario no esta en la base de datos, lo vamos a redirigir al login
            return redirect()->to('/login')->withErrors('auth.failed');
        }
        //en caso de que si tengamos a esa persona en el database
        //retrieve es recuperar
        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        Auth::login($user);
        return $this->authenticated($request, $user);
    }
    public function authenticated(Request $request, $user){
        return redirect('/home');
    }
}
