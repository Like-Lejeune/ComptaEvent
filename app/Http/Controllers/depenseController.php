<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Tools;

class depenseController extends Controller
{
    //
    private $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    public function nouvelle_depense()
    { 
        $services = DB::table('services')
        ->get();   
        return view('operations.depense')->with('service', $services);
    }

    public function historique_depense($service_id)
    {
        $service = DB::table('depense')
            ->where('service_id', $service_id)
            ->first();
        $info_service = DB::table('services')
            ->where('id_service', $service_id)
            ->first();
        return view('operations.historique_depense')
            ->with('service',$service)
            ->with('info',$info_service);
    }

    //
    public function submit_depense(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'depense' => 'required',
            'service_id' => 'required',
        ]);
        if ($validator->fails()) {

            return redirect()->back()->with('error', 'informations insuffisantes');
        } else {

            $recette = DB::table('depense')->insertGetId(
                [
                    's_depense' => $this->tools->controle_space($request->input('depense')),
                    'user_id' => auth()->User()->id,
                    'service_id' => $this->tools->controle_space($request->input('service_id')),
                ]
            );
            $Wallet = DB::table('services')->where('id_service', $request->input('service_id'))->value('s_solde');
            $wallet = $Wallet - $request->input('depense');
            DB::table('services')
                ->where('id_service', $request->input('service_id'))
                ->update(array(
                    's_solde' => $wallet,
                ));
            return redirect()->route('historique_depense', ['service_id' => $request->input('service_id')]);
        }
    }

    
    public function update_depense(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'depense' => 'required',
            'service_id' => 'required',
           
        ]);
        if ($validator->fails()) {

            return redirect()->back()->with('error', 'Remplissez les champs requis');
        } else {

                DB::table('depense')
                ->where('id_depense', $request->id_depense)
                ->update(array(
                    's_depense' => $this->tools->controle_space($request->input('depense')),
                ));
     
                return redirect()->route('form_depense', ['service_id' => $request->input('service_id')]);
        }
    }
}
