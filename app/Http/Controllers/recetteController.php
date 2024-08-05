<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Tools;

class recetteController extends Controller
{
    private $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    public function nouvelle_recette()
    {
        $services = DB::table('services')
        ->get();        
        return view('operations.recette')->with('service', $services);
    }
    //
    public function historique_recette($service_id)
    {
        $service = DB::table('recette')
            ->where('service_id', $service_id)
            ->first();
        $info_service = DB::table('services')
            ->where('id_service', $service_id)
            ->first();
        return view('operations.historique_recette')
            ->with('service',$service)
            ->with('info',$info_service);
    }
    
    public function submit_recette(Request $request)
    {

        $validator = Validator::make($request->all(), [
           // 'r_name' => 'required',
            'recette' => 'required',
            'service_id' => 'required',
        ]);
        if ($validator->fails()) {

            return redirect()->back()->with('error', 'informations insuffisantes');
        } else {

            $recette = DB::table('recette')->insertGetId(
                [
                   // 'r_name' => $this->tools->controle_space($request->input('r_name')),
                    's_recette' => $request->input('recette'),
                    'user_id' => auth()->User()->id,
                    'service_id' => $this->tools->controle_space($request->input('service_id')),
                ]
            );
            $Wallet = DB::table('services')->where('id_service', $request->input('service_id'))->value('s_solde');
            $wallet = $Wallet + $request->input('recette');
            DB::table('services')
                ->where('id_service', $request->input('service_id'))
                ->update(array(
                    's_solde' => $wallet,
                ));
    
            return redirect()->route('historique_recette', ['service_id' => $request->input('service_id')]);
        }
    }

    
    public function update_recette(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'r_name' => 'required',
            'recette' => 'required',
            'service_id' => 'required',
           
        ]);
        if ($validator->fails()) {

            return redirect()->back()->with('error', 'Remplissez les champs requis');
        } else {

                DB::table('recette')
                ->where('id_recette', $request->id_recette)
                ->update(array(
                    'r_name' => $this->tools->controle_space($request->input('r_name')),
                    'r_recette' => $this->tools->controle_space($request->input('r_recette'))
                ));
     
                return redirect()->route('form_recette', ['service_id' => $request->input('service_id')]);
        }
    }
}
