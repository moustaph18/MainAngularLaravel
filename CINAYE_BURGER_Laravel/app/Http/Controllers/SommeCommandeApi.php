<?php

namespace App\Http\Controllers;

use App\Models\CommandeModel;
use Illuminate\Http\Request;

class SommeCommandeApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupère la date actuelle
       

        // Filtre les commandes validées en fonction de la date de validation
        $total = CommandeModel::where('Etat', 1)
            ->sum('Prix');

        return response()->json(['total' => $total]);
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
        //
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
