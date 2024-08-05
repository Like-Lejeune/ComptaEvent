<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use \Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DateTime;

class editor_accountController extends Controller
{
   //
   public function controle_space($chaine)
   {
       $chaine = trim($chaine);
       $chaine = str_replace("###antiSlashe###t", " ", $chaine);
       $chaine = preg_replace("!\s+!", " ", $chaine);
       $chaine = htmlspecialchars($chaine);
       return $chaine;
   }

   public function revue($val)
   {
       $VALUE = DB::table('work_editor')
           ->join('works', 'work_editor.work_id', '=', 'id_work')
           ->join('users', 'editor_id', '=', 'users.id')
           ->select('*')
           ->where('work_id', $val)
           ->first();
       $editor_id = $VALUE->editor_id;
       
       $s_name = DB::table('services')
       ->select('s_name')
       ->where('id_service', $VALUE->service)
       ->first();

      switch ($s_name->s_name) {
        case 'SAISIE & MISE EN FORME':
            return view('editeur.projet_dossier.revue_smf')
            ->with('work', $VALUE)
            ->with('editor_id', $editor_id)
            ->with('id_work', $val);
            break;
        case 'REDACTION GENERALE':
            return view('editeur.projet_dossier.revue')
            ->with('work', $VALUE)
            ->with('editor_id', $editor_id)
            ->with('id_work', $val);
            break;
        case 'TRANSCRIPTION NUMERIQUE':
            return view('editeur.projet_dossier.revue_transcription')
            ->with('work', $VALUE)
            ->with('editor_id', $editor_id)
            ->with('id_work', $val);
            break;
        case 'MONTAGE & RELECTURE CV':
            return view('editeur.projet_dossier.revue_mrcv')
            ->with('work', $VALUE)
            ->with('editor_id', $editor_id)
            ->with('id_work', $val);
        break;
        
        default:
            echo('N/A');
        break;
      }
   }

   // SAISIE MISE EN FORME ** REDACTION GENERALE 

   public function EditeurInsertUpdateDelete(Request $request)  
   {
    $dt = new DateTime();

    $existe = DB::table('work_editor')
        ->where('work_id', $this->controle_space($request->input('work_id')))
        ->where('editor_id', auth()->user()->id)
        ->first('id_work_editor');
       if ($request->input('action_') == 1) {
           $validator = Validator::make($request->all(), [
               'upload_documents' => 'required|max:51200',
           ]);
           $users = DB::table('users')
                   ->where('id', auth()->user()->id)
                   ->first();

           if ($validator->fails()) {
               return redirect()->back()
                   ->with('error', 'champ requis ou limite du fichier atteinte.');
           } else {

           
            $count = 0;
            foreach ($request->file('upload_documents') as $key => $file) {
                $count++;
            }
               if ($count == 2) {
                foreach ($request->file('upload_documents') as $key => $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'edit.'. $extension;
                    $file->move('images/work_end/', $filename);
                    $code = $filename;
                    DB::table('work_end')->insert(
                        [
                            'work_editor_id' => $existe->id_work_editor,
                            'code_document' => $filename,
                        ]
                    );
                }
                return redirect()->back()
                    ->with('success', 'Documents déposés avec success.');
            }else{
                return redirect()->back()
                    ->with('error', 'Fournissez uniquement 2 documents.');
            }
           }
       } else if ($request->input('action_') == 2) { //update function
           $validator = Validator::make($request->all(), [
            'upload_documents' => 'required|max:51200',
           ]);

           if ($validator->fails()) {
               return redirect()->back()
                    ->with('error', 'champ requis ou limite du fichier atteinte.');
           } else {
               // Vérifier si une image existe déjà dans le dossier et dans la table
               $existingImage = DB::table('work_end')->where('work_editor_id', $existe->id_work_editor)->get();
                foreach ($existingImage as $existingImg) {
                    if (file_exists(public_path('images/work_end/' .$existingImg->code_document))) {
                        unlink(public_path('images/work_end/' .$existingImg->code_document));
                    }
                }
                $count = 0;
                foreach ($request->file('upload_documents') as $key => $file) {
                    $count++;
                }
                if ($count == 2) {

                    DB::table('work_end')
                        ->where('work_editor_id', $existe->id_work_editor)
                        ->delete();
                    foreach ($request->file('upload_documents') as $key => $file) {
                        $extension = $file->getClientOriginalExtension();
                        $filename = time().'edit.'. $extension;
                        $file->move('images/work_end/', $filename);
                        $code = $filename;
                        DB::table('work_end')->insert(
                            [
                                'work_editor_id' => $existe->id_work_editor,
                                'code_document' => $code,
                            ]
                        );
                    }
                    return redirect()->back()
                    ->with('success', 'Documents mis à jour avec success.');
            }else{
                return redirect()->back()
                    ->with('error', 'Fournissez uniquement 2 documents.');
            }
        }
       } else if ($request->input('action_') == 3) {

        $existingImage = DB::table('work_end')->where('work_editor_id', $existe->id_work_editor)->get();
        foreach ($existingImage as $existingImg) {
            if (file_exists(public_path('images/work_end/' .$existingImg->code_document))) {
                unlink(public_path('images/work_end/' .$existingImg->code_document));
            }
        }
            DB::table('work_end')
                    ->where('work_editor_id', $existe->id_work_editor)
                    ->delete();
           return redirect()->back()
               ->with('error', 'Documents supprimés avec success.');
       } 
   }




   public function EditeurInsertUpdateDeleteMRCV(Request $request)  
   {
    $dt = new DateTime();

    $existe = DB::table('work_editor')
        ->where('work_id', $this->controle_space($request->input('work_id')))
        ->where('editor_id', auth()->user()->id)
        ->first('id_work_editor');
       if ($request->input('action_') == 1) {
           $validator = Validator::make($request->all(), [
               'upload_documents' => 'required|max:51200',
           ]);
           $users = DB::table('users')
                   ->where('id', auth()->user()->id)
                   ->first();

           if ($validator->fails()) {
               return redirect()->back()
                   ->with('error', 'champ requis ou limite du fichier atteinte.');
           } else {

           
            $count = 0;
            foreach ($request->file('upload_documents') as $key => $file) {
                $count++;
            }
               if ($count >= 2 && $count <= 4 ) {
                foreach ($request->file('upload_documents') as $key => $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'edit.'. $extension;
                    $file->move('images/work_end/', $filename);
                    $code = $filename;
                    DB::table('work_end')->insert(
                        [
                            'work_editor_id' => $existe->id_work_editor,
                            'code_document' => $filename,
                        ]
                    );
                }
                return redirect()->back()
                    ->with('success', 'Documents déposés avec success.');
            }else{
                return redirect()->back()
                    ->with('error', 'Fournir entre 2 et 4 documents.');
            }
           }
       } else if ($request->input('action_') == 2) { //update function
           $validator = Validator::make($request->all(), [
            'upload_documents' => 'required|max:51200',
           ]);

           if ($validator->fails()) {
               return redirect()->back()
                    ->with('error', 'champ requis ou limite du fichier atteinte.');
           } else {
               // Vérifier si une image existe déjà dans le dossier et dans la table
               $existingImage = DB::table('work_end')->where('work_editor_id', $existe->id_work_editor)->get();
                foreach ($existingImage as $existingImg) {
                    if (file_exists(public_path('images/work_end/' .$existingImg->code_document))) {
                        unlink(public_path('images/work_end/' .$existingImg->code_document));
                    }
                }
                $count = 0;
                foreach ($request->file('upload_documents') as $key => $file) {
                    $count++;
                }
                if ($count >= 2 && $count <= 4 )  {

                    DB::table('work_end')
                        ->where('work_editor_id', $existe->id_work_editor)
                        ->delete();
                    foreach ($request->file('upload_documents') as $key => $file) {
                        $extension = $file->getClientOriginalExtension();
                        $filename = time().'edit.'. $extension;
                        $file->move('images/work_end/', $filename);
                        $code = $filename;
                        DB::table('work_end')->insert(
                            [
                                'work_editor_id' => $existe->id_work_editor,
                                'code_document' => $code,
                            ]
                        );
                    }
                    return redirect()->back()
                    ->with('success', 'Documents mis à jour avec success.');
            }else{
                return redirect()->back()
                    ->with('error', 'Fournir entre 2 et 4 documents.');
            }
        }
       } else if ($request->input('action_') == 3) {

        $existingImage = DB::table('work_end')->where('work_editor_id', $existe->id_work_editor)->get();
        foreach ($existingImage as $existingImg) {
            if (file_exists(public_path('images/work_end/' .$existingImg->code_document))) {
                unlink(public_path('images/work_end/' .$existingImg->code_document));
            }
        }
            DB::table('work_end')
                    ->where('work_editor_id', $existe->id_work_editor)
                    ->delete();
           return redirect()->back()
               ->with('error', 'Documents supprimés avec success.');
       } 
   }

   // TRANSCRIPTION 

   public function EditeurInsertUpdateDeleteTranscription(Request $request)  
   {
    $dt = new DateTime();
    
    $existe = DB::table('work_editor')
        ->where('work_id', $this->controle_space($request->input('work_id')))
        ->where('editor_id', auth()->user()->id)
        ->first('id_work_editor');
       if ($request->input('action_') == 1) {
           $validator = Validator::make($request->all(), [
               'upload_documents' => 'required|max:51200',
           ]);
           $users = DB::table('users')
                   ->where('id', auth()->user()->id)
                   ->first();

           if ($validator->fails()) {
               return redirect()->back()
                   ->with('error', 'champ requis ou limite du fichier atteinte.');
           } else {

           
            $count = 0;
            foreach ($request->file('upload_documents') as $key => $file) {
                $count++;
            }
               if ($count >= 1 && $count <= 2 ) {
                foreach ($request->file('upload_documents') as $key => $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'edit.'. $extension;
                    $file->move('images/work_end/', $filename);
                    $code = $filename;
                    DB::table('work_end')->insert(
                        [
                            'work_editor_id' => $existe->id_work_editor,
                            'code_document' => $filename,
                        ]
                    );
                }
                return redirect()->back()
                    ->with('success', 'Documents déposés avec success.');
            }else{
                return redirect()->back()
                    ->with('error', 'Fournir entre 1 et 2 documents.');
            }
           }
       } else if ($request->input('action_') == 2) { //update function
           $validator = Validator::make($request->all(), [
            'upload_documents' => 'required|max:51200',
           ]);

           if ($validator->fails()) {
               return redirect()->back()
                    ->with('error', 'champ requis ou limite du fichier atteinte.');
           } else {
               // Vérifier si une image existe déjà dans le dossier et dans la table
               $existingImage = DB::table('work_end')->where('work_editor_id', $existe->id_work_editor)->get();
                foreach ($existingImage as $existingImg) {
                    if (file_exists(public_path('images/work_end/' .$existingImg->code_document))) {
                        unlink(public_path('images/work_end/' .$existingImg->code_document));
                    }
                }
                $count = 0;
                foreach ($request->file('upload_documents') as $key => $file) {
                    $count++;
                }
                if ($count >= 1 && $count <= 2 )  {

                    DB::table('work_end')
                        ->where('work_editor_id', $existe->id_work_editor)
                        ->delete();
                    foreach ($request->file('upload_documents') as $key => $file) {
                        $extension = $file->getClientOriginalExtension();
                        $filename = time().'edit.'. $extension;
                        $file->move('images/work_end/', $filename);
                        $code = $filename;
                        DB::table('work_end')->insert(
                            [
                                'work_editor_id' => $existe->id_work_editor,
                                'code_document' => $code,
                            ]
                        );
                    }
                    return redirect()->back()
                    ->with('success', 'Documents mis à jour avec success.');
            }else{
                return redirect()->back()
                    ->with('error', 'Fournir entre 1 et 2 documents.');
            }
        }
       } else if ($request->input('action_') == 3) {

        $existingImage = DB::table('work_end')->where('work_editor_id', $existe->id_work_editor)->get();
        foreach ($existingImage as $existingImg) {
            if (file_exists(public_path('images/work_end/' .$existingImg->code_document))) {
                unlink(public_path('images/work_end/' .$existingImg->code_document));
            }
        }
            DB::table('work_end')
                    ->where('work_editor_id', $existe->id_work_editor)
                    ->delete();
           return redirect()->back()
               ->with('error', 'Documents supprimés avec success.');
       } 
   }

   public function work_end(Request $request)
   {
       $dt = new DateTime();

       $validator = Validator::make($request->all(), []);
       if ($validator->fails()) {
           return response()->json([
               'status' => 400,
               'errors' => ' renseignez les champs requis'
           ]);
       } else {
           $existe = DB::table('work_editor')
               ->where('work_id', $this->controle_space($request->input('id_projet')))
               ->where('editor_id', $this->controle_space($request->input('editor')))
               ->first();

           $val = DB::table('work_end')
               ->where('work_editor_id', $existe->id_work_editor)
               ->count();

           if ($val == 2) {

               DB::table('work_end')
                   ->where('work_editor_id', $existe->id_work_editor)
                   ->update(array(
                       'work_end_at' =>  $dt->format('Y-m-d H:i:s'),
                   ));
                   return redirect()->back()->with('success', 'Travail clôturé.');
           
           } else {
               return redirect()->back()
                   ->with('error', '❌ Envoyez deux documents word et Pdf ❌');
           }
       }
    }
}
