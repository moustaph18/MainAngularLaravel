<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthentificationControllerApi extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'Email' => 'required',
            'password' => 'required',
        ]);
        $login = $request->only('Email','password');
        
        if (!Auth::attempt($login)) {
            return response()->json(['Message'=>'Erreur survenue lors de l\'authification,Email ou mot de passe incorrect'],401);
        }
        /**
         * @var User $user
         */
        $user = Auth::user();
        $token = $user->createToken( 'token', ['*'], now()->addWeek()
        )->plainTextToken;
        
        return response([
           'id' => $user->id,
           'Prenom' => $user->Prenom,
           'Nom' => $user->Nom,
           'Email' => $user->Email,
           'Mot_de_passe' => $user->Mot_de_passe,
           'Profil' => $user->Profil,
           'created_at' => $user->created_at,
           'updated_at' => $user->updated_at,
           'token' => $token,
            'token_type' => 'Bearer'
        ],200);
        
}
    public function Register(Request $request){
        $request->validate([
            'Prenom' => 'required',
            'Nom' => 'required',
            'Email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::create([
            'Prenom' => $request->Prenom,
            'Nom' => $request->Nom,
            'Email' => $request->Email,
            'Mot_de_passe' => Hash::make($request->password),
        ]);
        // $data =array('Prenom'=> $request->prenom, 'Email'=>$request->Email);
        // Mail::send('Authentification.Inscription',$data,function($message){
        //     $message->to('ogbvllerdiagne@gmail.com', 'Test Email')
        //   ->subject
        //         ('Test de l\'envoie d\'email');
        //     $message->from('mustaf181102@gmail.com','renvoi email');

        // });
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['acces_token' => $token, 'token_type' => 'Bearer']);
    }
    public function deconnection(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['Message' => 'Deconnection reussi']);
    }
}
