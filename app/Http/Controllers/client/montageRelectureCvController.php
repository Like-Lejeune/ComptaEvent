<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Tools;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class montageRelectureCvController extends Controller
{
    //
    private $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    } 

     ///////////////////////////   SAISIE ET MISE EN FORME  /////////////////////////////////////////////

     public function submit_mrcv(Request $request)
     {
 
         $validator = Validator::make($request->all(), [
 
             // 'sujet_redaction' => 'required',
             //'link_doc' => 'required',
         ]);
         if ($validator->fails()) {
 
             return redirect()->back()->with('error', 'Remplissez les champs requis');
         } else {
            $nb_w = DB::table('works')
            ->where('service', '=', $request->input('service_id'))
            ->where('user_id', '=', auth()->User()->id)
            ->count();
            $nb_w++;

            if($request->input('sujet_redaction')=="Montage Cv"){
                $type_document = DB::table('type_document')
                ->where('name_type', '=',"Montage CV")
                ->first();
                $type_document=$type_document->id_type_document;
            }
            if($request->input('sujet_redaction')=="Relecture & Correction Cv"){
                $type_document = DB::table('type_document')
                ->where('name_type', '=',"Relecture & Correction")
                ->first();
                $type_document=$type_document->id_type_document;
            }
             $work_id = DB::table('works')->insertGetId(
                 [
                     'titre_travail' => "MR".$nb_w."MTW",
                     'sujet_travail' => $this->tools->controle_space($request->input('sujet_redaction')),
                     'type_document' => $type_document,
                     'info_supplementaire' => empty($request->input('info_supp')) ? '' : $this->tools->controle_space($request->input('info_supp')),
                     'user_id' => auth()->User()->id,
                     'service' => $this->tools->controle_space($request->input('service_id')),
                 ]
             );
          
             if ($request->file('link_doc')!=null) {
                 foreach ($request->file('link_doc') as $key => $file) {
                     $fileName = $work_id . time() . rand(1, 99).'.'.$file->extension();
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
                 'wo_option_id' => $type_document,
                 'wo_work_id' => $work_id,
                 'duree' => 'oui',
             ]);
             if($request->input('type_document')!=""){
                DB::table('work_option')->insert([
                    'wo_option_id' => $this->tools->controle_space($request->input('type_document')),
                    'wo_work_id' => $work_id,
                    'duree' => 'oui',
                ]);
             }
             return redirect()->route('form_paiement_mrcv', ['work_id' => $work_id]);
         }
     }
 
     public function update_mrcv(Request $request)
     {
 
         $validator = Validator::make($request->all(), [
 
             // 'sujet_redaction' => 'required',
             //'link_doc' => 'required',

         ]);
         if ($validator->fails()) {
 
             return redirect()->back()->with('error', 'Remplissez les champs requis');
         } else {
            
            if($request->input('sujet_redaction')=="Montage Cv"){
                $type_document = DB::table('type_document')
                ->where('name_type', '=',"Montage CV")
                ->first();
                $type_document=$type_document->id_type_document;
            }
            if($request->input('sujet_redaction')=="Relecture & Correction Cv"){
                $type_document = DB::table('type_document')
                ->where('name_type', '=',"Relecture & Correction")
                ->first();
                $type_document=$type_document->id_type_document;
            }
             DB::table('works')
                 ->where('id_work', $request->work_id)
                 ->update(array(
                    'sujet_travail' => $this->tools->controle_space($request->input('sujet_redaction')),
                    'type_document' => $type_document,
                    'info_supplementaire' => empty($request->input('info_supp')) ? '' : $this->tools->controle_space($request->input('info_supp')),
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
                 if ($request->file('link_doc')!=null) {
                     foreach ($request->file('link_doc') as $key => $file) {
                         $val++;
                         $fileName = $request->work_id . time() . rand(1, 99) . '.' . $file->extension();
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
                     $file_path = 'images/work_doc/'.$codes_doc->code_doc;
                     if (file_exists($file_path)) {
                         unlink($file_path);
                     }
                 }
 
                 if ($request->file('link_doc')!=null) {
                     foreach ($request->file('link_doc') as $key => $file) {
                         $fileName = $request->work_id . time() . rand(1, 99).'.'.$file->extension();
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
            
             if($request->input('type_document')!=""){

                $countDoc = DB::table('work_option')
                ->where('wo_work_id', '=', $request->work_id)
                ->where('wo_option_id', '=', $request->input('type_document'))
                ->count();
                if($countDoc==0){
                    DB::table('work_option')->insert([
                        'wo_option_id' => $this->tools->controle_space($request->input('type_document')),
                        'wo_work_id' => $request->work_id,
                        'duree' => 'oui',
                    ]);
                }
               
             }else{
                DB::table('work_option')
                 ->join('options', 'id_option', '=', 'wo_option_id')
                 ->where('wo_work_id', '=', $request->work_id)
                 ->delete();  
             }

             if($type_document){  
                $countDoc = DB::table('work_option')
                ->where('wo_work_id', '=', $request->work_id)
                ->where('wo_option_id', '=', $type_document)
                ->count();
                if($countDoc==0){
                    DB::table('work_option')
                    ->join('type_document', 'id_type_document', '=', 'wo_option_id')
                    ->where('wo_work_id', '=', $request->work_id)
                    ->delete();
                    DB::table('work_option')->insert([
                        'wo_option_id' => $this->tools->controle_space($type_document),
                        'wo_work_id' => $request->work_id,
                        'duree' => 'oui',
                    ]);
                }
             }
 
             return redirect()->route('form_paiement_mrcv', ['work_id' => $request->work_id]);
         }
     }

     public function encrypting_updateView_mrcv ($id) {

        $encryptedID = $this->tools->krypt($id);
        return redirect()->route('encrypted_mrcv', [
            'encryptedID' =>  $encryptedID,
        ]);
    }

     public function updateView_mrcv($work_id)
     {
        
         $work_id = $this->tools->dekrypt($work_id);
         return view('client.montageRelectureCv.update_view_mrcv')
             ->with('work_id', $work_id);
     }
 
     public function encrypting_form_paiement_mrcv ($id) {

        $encryptedID = $this->tools->krypt($id);
        return redirect()->route('encrypted_form_paiement_mrcv', [
            'encryptedID' =>  $encryptedID,
        ]);
    }

     public function form_paiement_mrcv($work_id)
     {
         $work_id = $this->tools->dekrypt($work_id);
         return view('client.montageRelectureCv.form_paiement')
             ->with('work_id', $work_id);
     }
}
