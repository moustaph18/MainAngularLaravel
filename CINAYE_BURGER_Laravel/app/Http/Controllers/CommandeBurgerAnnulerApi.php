<?php

namespace App\Http\Controllers;

use App\Models\CommandeModel;
use Illuminate\Http\Request;

class CommandeBurgerAnnulerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listeCommande = CommandeModel::where('commande.Etat', -1)
        ->join('burgers', 'commande.Burger', '=', 'burgers.id')
        ->join('users', 'commande.Utilisateur', '=' , 'users.id')
        ->select('burgers.Nom as BurgerNom',
        'users.Nom as UserNom','commande.id as CommandeId','commande.*', 'burgers.*','users.*')
        ->get();
        if ($listeCommande) {
           return response()->json($listeCommande,200);
        }else{
            return response()->json(['Message' =>'Aucun element trouver'],200);

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $commandes = CommandeModel::join('users', 'commande.Utilisateur', '=', 'users.id')
        ->join('burgers', 'commande.Burger', '=', 'burgers.id') // Jointure avec la table burgers
        ->where('users.id', $id)
        ->where('commande.Etat', -1)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
