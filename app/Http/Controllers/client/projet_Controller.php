<?php

namespace App\Http\Controllers\client;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Option_service;
use App\Http\Controllers\Tools;


class projet_Controller extends Controller
{

    private $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    } 

    public function service(Request $request)
    {
        $service = DB::table('services')
            ->where('id_service', '=', $request->id)
            ->first();

        switch ($service->s_name):

            case ("BUSINESS PLAN"):


                return view('coming_soon');

                break;

            case ("COMMISSIONS"):

                return view('coming_soon');
                //  return view('client.commission.commission_form')->with('service_id', $request->id);

                break;

            case ("MONTAGE & RELECTURE CV"):

                return view('client.montageRelectureCv.montageRelecture')
                    ->with('service_id', $request->id);
                break;

            case ("REDACTION GENERALE"):

                return view('client.redaction.redaction_generale')
                    ->with('service_id', $request->id);

                break;

            case ("SAISIE & MISE EN FORME"):

                return view('client.saisie_mise_en_forme.saisie_mise_en_forme')
                    ->with('service_id', $request->id);

                break;

            case ("TRANSCRIPTION NUMERIQUE"):

                return view('client.transcription.transcription')
                    ->with('service_id', $request->id);

                break;

            case ("ASSISTANCE TECHNOLOGIQUE"):

                return view('client.assistance.genius');

                break;

            default:
                return view('coming_soon');

        endswitch;
    }


    ///////////////////////    REDACTION GENERALE   ////////////////////////////

    public function redaction_soumission(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'sujet_redaction' => 'required',
            'name_work' => 'required',
            'type_document' => 'required',
            'police' => 'required|min:4',
            'nb_mots' => 'required'

        ]);
        if ($validator->fails()) {

            return redirect()->back()->with('error', 'Remplissez les champs requis');
        } else {

            $work_id = DB::table('works')->insertGetId(
                [
                    'titre_travail' => $this->tools->controle_space($request->input('name_work')),
                    'sujet_travail' => $this->tools->controle_space($request->input('sujet_redaction')),
                    'type_document' => $this->tools->controle_space($request->input('type_document')),
                    'info_supplementaire' => empty($request->input('info_redaction')) ? '' : $this->tools->controle_space($request->input('info_redaction')),
                    'user_id' => auth()->User()->id,
                    'service' => $this->tools->controle_space($request->input('service_id')),
                ]
            );
            $element_forme = $request->input('element_forme');
            DB::table('mise_en_forme')->insert([
                'work_id' => $work_id,
                'police' => $this->tools->controle_space($request->input('police')),
                'element_inclure' => $element_forme,
                'info_supp' => empty($request->input('supplement_forme')) ? '' : $this->tools->controle_space($request->input('supplement_forme')),
            ]);

            if ($request->file('link_doc')) {
                foreach ($request->file('link_doc') as $key => $file) {
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $work_id.time().rand(1, 99999).'.'.$extension;
                    $file->move('images/work_doc/'.$fileName);
                    DB::table('work_doc')->insert(
                        [
                            'code_doc' => $fileName,
                            'wd_work_id' => $work_id
                        ]
                    );
                }
            }
            DB::table('work_option')->insert([
                'wo_option_id' => $this->tools->controle_space($request->input('nb_mots')),
                'wo_work_id' => $work_id,
            ]);
            DB::table('work_option')->insert([
                'wo_option_id' => $this->tools->controle_space($request->input('element_work')),
                'wo_work_id' => $work_id,
            ]);

            return redirect()->route('form_paiement', ['work_id' => $work_id]);
        }
    }

    public function update_redaction(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'sujet_redaction' => 'required',
            'name_work' => 'required',
            'type_document' => 'required',

            'police' => 'required|min:4',
            'nb_mots' => 'required'

        ]);
        if ($validator->fails()) {

            return redirect()->back()->with('error', 'Remplissez les champs requis');
        } else {

            DB::table('works')
                ->where('id_work', $request->work_id)
                ->update(array(
                    'titre_travail' => $this->tools->controle_space($request->input('name_work')),
                    'sujet_travail' => $this->tools->controle_space($request->input('sujet_redaction')),
                    'type_document' => $this->tools->controle_space($request->input('type_document')),
                    'info_supplementaire' => empty($request->input('info_redaction')) ? '' : $this->tools->controle_space($request->input('info_redaction')),
                ));
           
            $element_forme = $request->input('element_forme');
            DB::table('mise_en_forme')
                ->where('work_id', $request->work_id)
                ->update(array(
                    'police' => $this->tools->controle_space($request->input('police')),
                    'element_inclure' =>  $element_forme,
                    'info_supp' => empty($request->input('supplement_forme')) ? '' : $this->tools->controle_space($request->input('supplement_forme')),
                ));

            $work_doc = DB::table('work_doc')
                ->where('wd_work_id', '=', $request->work_id)
                ->count();

            $code_doc = DB::table('work_doc')
                ->where('wd_work_id', '=', $request->work_id)
                ->get();
            $val = 0;
            if ($request->file('link_doc')) {
                foreach ($request->file('link_doc') as $key => $file) {
                    $val++;
                }
            }

            if (($work_doc == $val) && $work_doc != 0) {

                foreach ($code_doc as $codes_doc) {
                    if (file_exists('images/work_doc/'.$codes_doc->code_doc)) {
                        unlink('images/work_doc/'.$codes_doc->code_doc);
                    }
                }
                if ($request->file('link_doc')) {
                    foreach ($request->file('link_doc') as $key => $file) {
                        $val++;
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $request->work_id.time().rand(1, 99999).'.'.$extension;
                        $file->move('images/work_doc/'.$fileName);
                        DB::table('work_doc')
                            ->where('wd_work_id', $request->work_id)
                            ->update(array(
                                'code_doc' => $fileName,
                            ));
                    }
                }
            } else {

                foreach ($code_doc as $codes_doc) {
                    $file_path = 'images/work_doc/' . $codes_doc->code_doc;
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }

                if ($request->file('link_doc')) {
                    foreach ($request->file('link_doc') as $key => $file) {
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $request->work_id . time() . rand(1, 99999).'.'.$extension;
                        $file->move('images/work_doc/'.$fileName);
                        DB::table('work_doc')->insert(
                            [
                                'code_doc' => $fileName,
                                'wd_work_id' => $request->work_id
                            ]
                        );
                    }
                }
            }

            $nb_mot_id = DB::table('work_option')
                ->join('options', 'id_option', '=', 'wo_option_id')
                ->where('wo_work_id', '=', $request->work_id)
                ->where('option_categorie', '=', 'nombre de mots')
                ->first();
            $redac_mot_id = DB::table('work_option')
                ->join('options', 'id_option', '=', 'wo_option_id')
                ->where('wo_work_id', '=', $request->work_id)
                ->where('option_categorie', '=', 'redaction nombre document')
                ->first();

            DB::table('work_option')
                ->where('id_wo', $nb_mot_id->id_wo)
                ->update(array(
                    'wo_option_id' => $this->tools->controle_space($request->input('nb_mots')),
                ));
            DB::table('work_option')
                ->where('id_wo', $redac_mot_id->id_wo)
                ->update(array(
                    'wo_option_id' => $this->tools->controle_space($request->input('element_work')),

                ));

            return redirect()->route('form_paiement', ['work_id' => $request->work_id]);
        }
    }

    public function encrypting_view_redaction ($id) {

        $encryptedID = $this->tools->krypt($id);
        return redirect()->route('encrypted_update_view_redation', [
            'encryptedID' =>  $encryptedID,
        ]);
    }
    public function update_view_redation($work_id)
    {
        $work_id = $this->tools->dekrypt($work_id);
        return view('client.redaction.update_view_redaction')
            ->with('work_id', $work_id);
    }

    public function encrypting_form_paiement ($id) {

        $encryptedID = $this->tools->krypt($id);
        return redirect()->route('encrypted_form_paiement', [
            'encryptedID' =>  $encryptedID,
        ]);
    }
    public function form_paiement($work_id)
    {
        $work_id = $this->tools->dekrypt($work_id);
        return view('client.redaction.form_paiement')
            ->with('work_id', $work_id);
    }

    public function paid_om_momo(Request $request)
    {
        $type_doc = DB::table('works')
                        ->join('type_document','type_document','=','id_type_document')
                        ->where('id_work','=',$request->input('paiement_work_id'))
                        ->first();
        $date = Carbon::now();
        $date->addHours($type_doc->duree);
        $validator = Validator::make($request->all(), [

            'paiement_work_id' => 'required',
        ]);
        if ($validator->fails()) {

            return redirect()->back()->with('error', 'Impossible de payer');
        } else {

            DB::table('works')
            ->where('id_work', $request->input('paiement_work_id'))
            ->update(array(
                'w_paid' => 'paiement',
                'w_treatment' => 'traitement',
                'paid_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'end_estimation' => $date->format('Y-m-d H:i:s'),
            ));
            $exists = DB::table('users')
            ->select('users.id')
            //->join('work_editor', 'users.id', '=', 'work_editor.editor_id')
            ->where('users.type', 'editeur')
           // ->groupBy('users.id')
           // ->where(DB::raw('COUNT(work_editor)=2'))
            ->inRandomOrder()
            ->limit(1)
            ->first();
            //dd($exists->id);
            if ($exists->id) {   
                DB::table('work_editor')->insert(
                    [
                        'work_id' =>  $request->input('paiement_work_id'),
                        'editor_id' => $exists->id,
                    ]
                );
                return redirect()->back()->with('success', "Paiement effectué Veillez patienter pour vos résultats.");
            }
            return redirect()->back()->with('error', "Paiement effectué mais en atttente d'un éditeur.");
        }
    }

    public function deleteWork(Request $request)
    {
        // works //
        $countDoc_works = DB::table('works')
        ->where('id_work', '=', $request->work_id)
        ->count();
        if($countDoc_works!=0){
            DB::table('works')
            ->where('id_work', '=', $request->work_id)
            ->delete();
        }
        // mise_en_forme //
        $countDoc_mise_en_forme = DB::table('mise_en_forme')
        ->where('work_id', '=', $request->work_id)
        ->count();
        if($countDoc_mise_en_forme!=0){
            DB::table('mise_en_forme')
            ->where('work_id', '=', $request->work_id)
            ->delete();
        }
        // work_editor //
        $countDoc_work_editor = DB::table('work_editor')
        ->where('work_id', '=', $request->work_id)
        ->count();
        if($countDoc_work_editor!=0){
            DB::table('work_editor')
            ->where('work_id', '=', $request->work_id)
            ->delete();
        }
        // work_doc //
        $countDoc_work_doc = DB::table('work_doc')
        ->where('wd_work_id', '=', $request->work_id)
        ->count();
        if($countDoc_work_doc!=0){

            $code_doc = DB::table('work_doc')
            ->where('wd_work_id', '=', $request->work_id)
            ->get();

            foreach ($code_doc as $codes_doc) {
                $file_path = 'images/work_doc/' . $codes_doc->code_doc;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }

            DB::table('work_doc')
            ->where('wd_work_id', '=', $request->work_id)
            ->delete();
        }
        // work_option //
        $countDoc_work_option = DB::table('work_option')
        ->where('wo_work_id', '=', $request->work_id)
        ->count();
        if($countDoc_work_option!=0){
            DB::table('work_option')
            ->where('wo_work_id', '=', $request->work_id)
            ->delete();
        }
        return redirect()->back()->with('success', "suppression effectuée avec success.");
    }

    public function mes_travaux()
     {
         return view('client.mes_travaux');
     }
   
}