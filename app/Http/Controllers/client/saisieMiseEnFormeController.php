<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Tools;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class saisieMiseEnFormeController extends Controller
{
    //
    private $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

     ///////////////////////////   SAISIE ET MISE EN FORME  /////////////////////////////////////////////

     public function submit_smf(Request $request)
     {
  
         $validator = Validator::make($request->all(), [
 
             // 'sujet_redaction' => 'required',
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
                     //   'sujet_travail' => $this->tools->controle_space($request->input('sujet_redaction')),
                     'type_document' => $this->tools->controle_space($request->input('type_document')),
                     'info_supplementaire' => empty($request->input('info_redaction')) ? '' : $this->tools->controle_space($request->input('info_redaction')),
                     'user_id' => auth()->User()->id,
                     'service' => $this->tools->controle_space($request->input('service_id')),
                 ]
             );
    
             DB::table('mise_en_forme')->insert([
                 'work_id' => $work_id,
                 'police' => $this->tools->controle_space($request->input('police')),
                 'element_inclure' => $request->input('element_forme'),
                 'info_supp' => empty($request->input('supplement_forme')) ? '' : $this->tools->controle_space($request->input('supplement_forme')),
             ]);
 
             if ($request->file('link_doc')) {
                 foreach ($request->file('link_doc') as $key => $file) {
                     $fileName = $work_id . time() . rand(1, 99) . '.' . $file->extension();
                     $file->move('images/work_doc/', $fileName);
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
            /* DB::table('work_option')->insert([
                 'wo_option_id' => $this->tools->controle_space($request->input('element_work')),
                 'wo_work_id' => $work_id,
             ]);
            */
             return redirect()->route('form_paiement_smf', ['work_id' => $work_id]);
         }
     }
 
     public function update_smf(Request $request)
     {
 
         $validator = Validator::make($request->all(), [
 
             // 'sujet_redaction' => 'required',
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
                     // 'sujet_travail' => $this->tools->controle_space($request->input('sujet_redaction')),
                     'type_document' => $this->tools->controle_space($request->input('type_document')),
                     'info_supplementaire' => empty($request->input('info_redaction')) ? '' : $this->tools->controle_space($request->input('info_redaction')),
                 ));
          
             DB::table('mise_en_forme')
                 ->where('work_id', $request->work_id)
                 ->update(array(
                     'police' => $this->tools->controle_space($request->input('police')),
                     'element_inclure' => $request->input('element_forme'),
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
                     if (file_exists('images/work_doc/', $codes_doc->code_doc)) {
                         unlink('images/work_doc/', $codes_doc->code_doc);
                     }
                 }
                 if ($request->file('link_doc')) {
                     foreach ($request->file('link_doc') as $key => $file) {
                         $val++;
                         $fileName = $request->work_id . time() . rand(1, 99) . '.' . $file->extension();
                         $file->move('images/work_doc/', $fileName);
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
                         $fileName = $request->work_id . time() . rand(1, 99) . '.' . $file->extension();
                         $file->move('images/work_doc/', $fileName);
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
             /*DB::table('work_option')
                 ->where('id_wo', $redac_mot_id->id_wo)
                 ->update(array(
                     'wo_option_id' => $this->tools->controle_space($request->input('element_work')),
 
                 ));*/
 
             return redirect()->route('form_paiement_smf', ['work_id' => $request->work_id]);
         }
     }

     public function encrypting_updateView_smf ($id) {

        $encryptedID = $this->tools->krypt($id);
        return redirect()->route('encrypted_smf', [
            'encryptedID' =>  $encryptedID,
        ]);
    }

     public function updateView_smf($work_id)
     {
        
         $work_id = $this->tools->dekrypt($work_id);
         return view('client.saisie_mise_en_forme.update_view_saisie_mise_en_forme')
             ->with('work_id', $work_id);
     }
 
     public function encrypting_form_paiement_smf ($id) {

        $encryptedID = $this->tools->krypt($id);
        return redirect()->route('encrypted_form_paiement_smf', [
            'encryptedID' =>  $encryptedID,
        ]);
    }

     public function form_paiement_smf($work_id)
     {
         $work_id = $this->tools->dekrypt($work_id);
         return view('client.saisie_mise_en_forme.form_paiement_saisie_mise_en_forme')
             ->with('work_id', $work_id);
     }
}