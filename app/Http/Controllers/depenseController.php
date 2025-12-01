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
        $user = auth()->user();

       if ($user->type == "admin" || $user->type == "super") {
            // Super admin : accès à tous les services
            $services = DB::table('services')
            ->join('evenements', 'evenements.id', '=', 'services.evenement_id')
            ->where('evenements.utilisateur_id', $user->id)
            ->orderBy('s_name', 'asc')
            ->get();  
        } else {
        // Utilisateur normal : accès via pivot
        $services = DB::table('services')
            ->join('user_service', 'id_service', '=', 'user_service.service_id')
            ->where('user_service.user_id', $user->id)
            ->select('services.*')
            ->get(); 
    }  
        return view('operations.depense')->with('service', $services);
    }

    public function historique_depense($service_id)
    {
        $service = DB::table('depense')
            ->where('service_id', $service_id)
            ->first();
        $count = DB::table('depense')
            ->where('service_id', $service_id)
            ->count();
        $info_service = DB::table('services')
            ->where('id_service', $service_id)
            ->first();
        if ($count>0) {
            return view('operations.historique_depense')
            ->with('service',$service)
            ->with('info',$info_service);
        } else {
            return redirect()->back();
        }
        
    }

    //
    public function submit_depense(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'designation' => 'required',
            'depense' => 'required',
            'service_id' => 'required',
            'date_operation' => 'required',
            'link_piece' => 'required',
        ]);
        if ($validator->fails()) {

            return redirect()->back()->with('error', 'informations insuffisantes');
        } else {

            $depense = DB::table('depense')->insertGetId(
                [
                    'd_name' => $this->tools->controle_space($request->input('designation')),
                    's_depense' => $this->tools->controle_space($request->input('depense')),
                    'date_operation' => $request->input('date_operation'),
                    'd_description' => $this->tools->controle_space($request->input('sup_info')),
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

                if ($request->file('link_piece')) {
                foreach ($request->file('link_piece') as $file) {
                    $fileName = $depense . '_' . $file->getClientOriginalName(); 
                    $file->move('images/work_doc/', $fileName);

                    DB::table('piece_jointe')->insert([
                        'piece_name' => $fileName,
                        'depense_id' => $depense
                        ]);
                    }
                }
            return redirect()->route('historique_depense', ['service_id' => $request->input('service_id')]);
        }
    }

    public function edit_depense($id)
    {
        // Récupérer la dépense
        $depense = DB::table('depense')
            ->where('id_depense', $id)
            ->first();

        if (!$depense) {
            return redirect()->back()->with('error', 'Dépense introuvable');
        }

        // Récupérer les pièces jointes
        $pieces = DB::table('piece_jointe')
            ->where('depense_id', $id)
            ->get();

        // Récupérer la liste des services accessibles par l’utilisateur
        $user = auth()->user();
        if ($user->type == "admin" || $user->type == "super") {
            $services = DB::table('services')->get();
        } else {
            $services = DB::table('services')
                ->join('user_service', 'services.id_service', '=', 'user_service.service_id')
                ->where('user_service.user_id', $user->id)
                ->select('services.*')
                ->get();
        }

        return view('operations.edit_depense', compact('depense', 'pieces', 'services'));
    }

    
    public function update_depense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'designation'    => 'required',
            'depense'        => 'required',
            'service_id'     => 'required',
            'date_operation' => 'required',
            'link_piece'     => 'nullable',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'informations insuffisantes');
        }

        // Récupérer la dépense existante
        $depense = DB::table('depense')->where('id_depense', $request->id_depense)->first();
        if (!$depense) {
            return redirect()->back()->with('error', 'Dépense introuvable');
        }

        // 🔄 Réajuster le solde du service
        // On remet l’ancien montant avant de déduire le nouveau
        $Wallet = DB::table('services')->where('id_service', $depense->service_id)->value('s_solde');
        $Wallet = $Wallet + $depense->s_depense - $request->input('depense');

        DB::table('services')
            ->where('id_service', $request->input('service_id'))
            ->update(['s_solde' => $Wallet]);

        // 🔄 Mise à jour de la dépense
        DB::table('depense')
            ->where('id_depense', $request->id_depense)
            ->update([
                'd_name'        => $this->tools->controle_space($request->input('designation')),
                's_depense'     => $this->tools->controle_space($request->input('depense')),
                'date_operation'=> $request->input('date_operation'),
                'd_description' => $this->tools->controle_space($request->input('sup_info')),
                'user_id'       => auth()->user()->id,
                'service_id'    => $this->tools->controle_space($request->input('service_id')),
            ]);

        // 🔄 Mise à jour des pièces jointes si upload
        if ($request->file('link_piece')) {
            foreach ($request->file('link_piece') as $file) {
                    $fileName = $depense . '_' . $file->getClientOriginalName(); 
                    $file->move('images/work_doc/', $fileName);

                    DB::table('piece_jointe')->insert([
                        'piece_name' => $fileName,
                        'depense_id' => $depense
                        ]);
                    }
                }

        return redirect()->route('historique_depense', ['service_id' => $request->input('service_id')])
            ->with('success', 'Dépense mise à jour avec succès');
    }


    public function DocsTelecharger($val)
    {
        $existingdoc = DB::table('piece_jointe')->where('depense_id', $val)->get();
        return view('operations.piece_jointe')
            ->with('documents', $existingdoc);
    }
}
