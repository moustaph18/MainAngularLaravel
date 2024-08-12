<?php

namespace App\Http\Controllers;

use App\Models\CommandeModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class dashboardApi extends Controller
{
    /**
     * Cette methode permet de recuperer les commandes valider au cours de la journee
     */
    public function getCommandeValideJournee(){
        $dateActuelle = now()->toDateString();

        $listeCommande = CommandeModel::where('commande.Etat', 1)
        ->whereDate('commande.date', '=',$dateActuelle)
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
     * cette methode de recuperer les commandes  en attente de validation dans la journee
     */
    public function getCommandeEnAttenteJournee(){
        $dateActuelle = now()->toDateString();

        $listeCommande = CommandeModel::where('commande.Etat', 0)
        ->whereDate('commande.created_at', '=',$dateActuelle)
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
     * cette methode de recuperer les commandes annulee de validation dans la journee
     */
    public function getCommandeAnnuleeJournee(){
        $dateActuelle = now()->toDateString();

        $listeCommande = CommandeModel::where('commande.Etat', -1)
        ->whereDate('commande.date', '=',$dateActuelle)
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
     * cette methode de calculer les rcettes de la journee
     */
    public function getSommeJournee(){
        $dateActuelle = now()->toDateString();

        // Filtre les commandes validées en fonction de la date de validation
        $total = CommandeModel::whereDate('date', $dateActuelle)
            ->where('Etat', 1)
            ->sum('Prix');

        return response()->json(['total' => $total]);
    }

    public function sendMAil(){
        $data =array('Prenom'=> 'Moustapha', 'Email'=>'ogbvllerdiagne@gmail.com');

        Mail::send('sendMail',$data,function($message){
            $message->to('ogbvllerdiagne@gmail.com', 'Test Email')
          ->subject
                ('Test de l\'envoie d\'email');
            $message->from('moustaf478@gmail.com','renvoi email');
        });
        echo "Mail envoyee, Verifier votre mail";
    }

    public function getChart(){

        $chart = CommandeModel::select(
            DB::raw("to_char(date, 'YYYY') as annee"),
            DB::raw("to_char(date, 'Month') as mois"),
            DB::raw("SUM(\"Prix\") as total_prix")
        )
        ->from('commande')
        ->groupBy(DB::raw("to_char(date, 'YYYY')"), DB::raw("to_char(date, 'Month')"))
        ->orderBy(DB::raw("to_char(date, 'YYYY')"))
        ->orderBy(DB::raw("to_char(date, 'Month')"))
        ->get();
    
        return response()->json($chart, 200);
    }

    public function getCommandeValideJourneeNonPayer(){
        $dateActuelle = now()->toDateString();

        $listeCommande = CommandeModel::where('commande.Etat', 1)
        ->whereDate('commande.created_at', '=',$dateActuelle)
        ->where('commande.Payer',0)
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

    public function ValidateCommande(Request $request ,$id){
        $commande = CommandeModel::findOrFail($id);
        try {
        
         $request->validate([
            // 'Utilisateur' => 'required',
            'Date' => 'required',
            'Prix' => 'required',
            'Payer' => 'required'
        ]);
        $commande->Payer = $request->Payer;
        $commande->date = $request->Date;
        $commande->Prix = $request->Prix;
        $commande->update();
        
        


        return response()->json($commande, 200);
        }catch(ModelNotFoundException $e){
            return response()->json(['erreur' => 'Validation impossible! Une erreur est survenue'], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        $commande = CommandeModel::findOrFail($id);
        try {
        
         $request->validate([
            // 'Utilisateur' => 'required',
            'Date' => 'required',
            // 'Prix' => 'required',
            'Etat' => 'required'
        ]);
        $commande->Etat = $request->Etat;
        $commande->date = $request->Date;
        // $commande->Prix = $request->Prix;
        $commande->update();
        $listeCommande = CommandeModel::where('commande.Etat', -1)
        ->where('commande.id',$id)
        ->join('burgers', 'commande.Burger', '=', 'burgers.id')
        ->join('users', 'commande.Utilisateur', '=' , 'users.id')
        ->select('burgers.Nom as BurgerNom',
        'users.Nom as UserNom','commande.id as CommandeId','commande.*', 'burgers.*','users.*')
        ->get();
        

        $data =array('Prenom'=> $listeCommande[0]->Prenom , 'Nom'=> $listeCommande[0]->UserNom,'Produit'=> $listeCommande[0]->BurgerNom, 'Prix' => $listeCommande[0]->Prix);

        Mail::send('sendMailAnnulation',$data,function($message) use ($listeCommande){
            $message->to($listeCommande[0]->Email, 'Message d\'annulation')
          ->subject
                ('OG-FOOD : Votre commande est annulee');
            $message->from('moustaf478@gmail.com','renvoi email');
        });

        return response()->json($commande, 200);
        }catch(ModelNotFoundException $e){
            return response()->json(['erreur' => 'Validation impossible! Une erreur est survenue'], 404);
        }
    }
}
