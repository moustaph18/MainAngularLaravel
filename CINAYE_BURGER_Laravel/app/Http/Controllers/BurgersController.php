<?php

namespace App\Http\Controllers;

use App\Models\BurgersModel;
use Illuminate\Http\Request;

class BurgersController extends Controller
{
    public function Liste(){
        $listeBurgers = BurgersModel::where('Etat', 1)->get();
        return view('burgers.Liste',compact('listeBurgers'));
    }
    public function AjoutPage(){
        return view('burgers.Ajout');
    }
    public function Ajout(Request $request){
        $request->validate([
            'image' => 'required',
            'Nom' => 'required',
            'Prix' => 'required',
            'description' => 'required',
        ]);

        $burgers = new BurgersModel();
        $burgers->Nom = $request->Nom;
        $burgers->Prix = $request->Prix;
        $filename=time().$request->file('image')->getClientOriginalName();
        if ($request->hasFile('image')) {
        $path = $request->file('image')->storeAs('photos',$filename,'public');
        $burgers->Image= '/storage/'.$path;
       }
        $burgers->Description = $request->description;
        $burgers->save();
        return redirect('/Liste')->with('State','Une modification a ete effectuer avec succes !');
    }

    public function ModificationPage($id){
        $burgerById = BurgersModel::find($id);
        return view('burgers.Modifier',compact('burgerById'));

    }
     public function ModificationBurger(Request $request){
        $request->validate([
            'image' => 'required',
            'Nom' => 'required',
            'Prix' => 'required',
            'description' => 'required',
        ]);
        $burger = BurgersModel::find($request->id);

        $burger->Nom = $request->Nom;
        $burger->Prix = $request->Prix;
        $filename=time().$request->file('image')->getClientOriginalName();
        if ($request->hasFile('image')) {
        $path = $request->file('image')->storeAs('photos',$filename,'public');
        $burger->Image= '/storage/'.$path;
       }
        $burger->Description = $request->description;
        $burger->update();
        return redirect('/Liste')->with('State','Une modification a ete effectuer avec succes !');
     }
     public function Archiver($id){
        $Archi_Burgers=BurgersModel::find($id);
        $Archi_Burgers->Etat = 0;
        $Archi_Burgers->Update();

        return redirect('/Liste')->with('State','Archivement effectuer avec succes !');
    
     }
}
