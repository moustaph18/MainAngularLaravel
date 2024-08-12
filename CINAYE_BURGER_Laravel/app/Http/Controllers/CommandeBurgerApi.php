<?php

namespace App\Http\Controllers;

use App\Models\CommandeModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CommandeBurgerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listeCommande = CommandeModel::where('commande.Etat', 0)
        ->join('burgers', 'commande.Burger', '=', 'burgers.id')
        ->join('users', 'commande.Utilisateur', '=' , 'users.id')
        ->select('burgers.Nom as BurgerNom',
        'users.Nom as UserNom','commande.id as CommandeId','commande.*', 'burgers.*','users.*')
        ->get();
        return response()->json($listeCommande,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'User' => 'required',
            'Burger' => 'required',
        ]);
        $commande = CommandeModel::create([
            'Utilisateur' => $request->User,
            'Burger' => $request->Burger
        ]);
        if ($commande) {
           return response()->json($commande,200);
        }else{
            return response()->json(['Message' => 'verifier si les donneses exite']);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $commandes = CommandeModel::join('users', 'commande.Utilisateur', '=', 'users.id')
        ->join('burgers', 'commande.Burger', '=', 'burgers.id') // Jointure avec la table burgers
        ->where('users.id', $id)
        ->where('commande.Etat', 0)
        ->select('burgers.Nom as BurgerNom',
        'users.Nom as UserNom','commande.id as CommandeId','commande.*', 'burgers.*','users.*')  // Sélectionner toutes les colonnes de commandes et burgers
        ->get();

        return response()->json($commandes, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $commande = CommandeModel::findOrFail($id);
        try {
        
         $request->validate([
            // 'Utilisateur' => 'required',
            // 'Date' => 'required',
            // 'Prix' => 'required',
            'Etat' => 'required'
        ]);
        $commande->Etat = $request->Etat;
        // $commande->date = $request->Date;
        // $commande->Prix = $request->Prix;
        $commande->update();
        $listeCommande = CommandeModel::where('commande.Etat', 1)
        ->where('commande.id',$id)
        ->join('burgers', 'commande.Burger', '=', 'burgers.id')
        ->join('users', 'commande.Utilisateur', '=' , 'users.id')
        ->select('burgers.Nom as BurgerNom',
        'users.Nom as UserNom','commande.id as CommandeId','commande.*', 'burgers.*','users.*')
        ->get();
        

        $data =array('Prenom'=> $listeCommande[0]->Prenom , 'Nom'=> $listeCommande[0]->UserNom,'Produit'=> $listeCommande[0]->BurgerNom, 'Prix' => $listeCommande[0]->Prix);

        Mail::send('sendMail',$data,function($message) use ($listeCommande){
            $message->to($listeCommande[0]->Email, 'Message de validation')
          ->subject
                ('OG-FOOD : Votre commande est prete');
            $message->from('moustaf478@gmail.com','renvoi email');
        });

        return response()->json(['Message' => 'Commande validee'], 200);
        }catch(ModelNotFoundException $e){
            return response()->json(['erreur' => 'Validation impossible! Une erreur est survenue'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
