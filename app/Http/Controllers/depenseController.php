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
            'designation' => 'required|string|max:60',
            'depense' => 'required|numeric|min:0',
            'service_id' => 'required|exists:services,id_service',
            'date_operation' => 'required|date',
            'link_piece' => 'nullable|array',
            'link_piece.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:5120',
            'sup_info' => 'nullable|string',
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
                    // Extensions autorisées pour les pièces jointes
                    $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx', 'xls', 'xlsx'];
                    $maxFileSize = 5 * 1024 * 1024; // 5MB

                    foreach ($request->file('link_piece') as $key => $file) {
                        // Validation de l'extension
                        $extension = strtolower($file->getClientOriginalExtension());
                        if (!in_array($extension, $allowedExtensions)) {
                            continue; // Ignorer les fichiers non autorisés
                        }

                        // Validation de la taille
                        if ($file->getSize() > $maxFileSize) {
                            continue; // Ignorer les fichiers trop volumineux
                        }

                        // Générer un nom de fichier sécurisé
                        $fileName = 'depense_' . $depense . '_' . time() . '_' . uniqid() . '.' . $extension;

                        // Créer le dossier s'il n'existe pas
                        $uploadPath = public_path('images/work_doc');
                        if (!file_exists($uploadPath)) {
                            mkdir($uploadPath, 0755, true);
                        }

                        // Déplacer le fichier
                        $file->move($uploadPath, $fileName);

                        // Enregistrer dans la base de données
                        DB::table('piece_jointe')->insert([
                            'piece_name' => $fileName,
                            'depense_id' => $depense
                        ]);
                    }
                }
            return redirect()->route('historique_depense', ['service_id' => $request->input('service_id')]);
        }
    }

    
    public function update_depense(Request $request)
    {

        $validator = Validator::make($request->all(), [
           
            'd_name' => 'required',
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

    public function DocsTelecharger($val)
    {
        $existingdoc = DB::table('piece_jointe')->where('depense_id', $val)->get();
        return view('operations.piece_jointe')
            ->with('documents', $existingdoc);
    }
}
