<?php

namespace App\Http\Controllers;

use App\Models\BurgersModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BurgerControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listeBurgers = BurgersModel::where('Etat', 1)->get();
       
        return response()->json($listeBurgers,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nom' => 'required',
            'Prix' => 'required',
            'Image' => 'required',
            'Description' => 'required',
        ]);

        
        //Image 
        $filename=time().$request->file('Image')->getClientOriginalName();
        if ($request->hasFile('Image')) {
        $path = $request->file('Image')->storeAs('photos',$filename,'public');
        $BurgersImage= '/storage/'.$path;
        }else{
            return response()->json(['Message' => 'L\'insertion d\'image est obligatoire']);
        }
        $Burgers = new BurgersModel([
            'Nom' => $request->get('Nom'),
            'Prix' => $request->get('Prix'),
            'Image' => $BurgersImage,
            'Description' => $request->get('Description')
        ]);
        $Burgers->save();

        return response()->json($Burgers,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $Archi_Burgers=BurgersModel::findOrFail($id);
            return response()->json($Archi_Burgers,200);
        }catch(ModelNotFoundException $e){
            return response()->json(['erreur' => 'Element introuvable'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $burger = BurgersModel::findOrFail($id);
            $validate = $request->validate([
                'Image' => 'required',
                'Nom' => 'required',
                'Prix' => 'required',
                'Description' => 'required',
            ]);
            
                // $burger->Nom = $request->Nom;
                // $burger->Prix = $request->Prix;
                // $filename=time().$request->file('image')->getClientOriginalName();
                // if ($request->hasFile('image')) {
                // $path = $request->file('image')->storeAs('photos',$filename,'public');
                // $burger->Image= '/storage/'.$path;
            //    }
                // $burger->Description = $request->description;
            $burger->update($validate);
            return response()->json($burger,200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['erreur' => 'Modification impossible une erreur est survenue'], 404);
        }
     
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $Archi_Burgers=BurgersModel::findOrFail($id);
            $Archi_Burgers->Etat = 0;
            $Archi_Burgers->Update();
            return response()->json($Archi_Burgers,200);
        }catch(ModelNotFoundException $e){
            return response()->json(['erreur' => 'Element introuvable'], 404);
        }
       
    }
}
