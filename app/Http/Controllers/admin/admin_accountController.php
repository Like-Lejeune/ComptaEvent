<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use \Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Tools;

class admin_accountController extends Controller
{
     //

     private $tools;

     public function __construct(Tools $tools)
     {
         $this->tools = $tools;
     }
 
     public function controle_space($chaine)
     {
         $chaine = trim($chaine);
         $chaine = str_replace("###antiSlashe###t", " ", $chaine);
         $chaine = preg_replace("!\s+!", " ", $chaine);
         $chaine = htmlspecialchars($chaine);
         return $chaine;
     }
 
     public function index(Request $request)
     {
     }
 
  
   public function edit($user_id)
   {
     $user = DB::table('users')->where('id', $user_id)->first();
     return response()->json($user);
   }
 
   public function add_admin(Request $request)
   {
 
     $validator = Validator::make($request->all(), [
 
       'name_user_' => 'required|max:50',
       
       
 
     ]);
     if ($validator->fails()) {
       return response()->json([
         'status' => 400,
         'errors' => ' renseignez les champs requis'
       ]);
     } else {
        $nb = DB::table('users')->where('type', 'admin')->count();
        $nb = $nb++;
        
       $user = new user();
       $user->name =  $this->controle_space($request->input('name_user_'));
       $user->email = 'MT' . $nb. "A" . date('Y')[2] . date('Y')[3].'@default.com';
       $user->type = 'admin';
       $user->phone = '6 95 25 48 '.$nb.$nb;
       $user->password = Hash::make('mytaskwork');
       $user->wallet = 0;
       $user->status = 1;
       $user->action = '';
       $user->matricule = 'MT' . $nb. "A" . date('Y')[2] . date('Y')[3];
       $user->save();

       return view("admin.account_admin");
     }
   }

   public function update_admin(Request $request)
  {
    
    DB::table('users')
      ->where('id', $request->id_user)
      ->update(array(
        'name' => $this->controle_space($request->name_user),
        'email' => $this->controle_space($request->email_user),
        'phone' => $this->controle_space($request->phone_user),
        'type' => 'admin',
        'password' => $this->controle_space($request->password_user),
        'wallet' => 0,
        'status' => 0,
        'action' => '',
        'matricule' => $this->controle_space($request->matricule_user),
      ));
    return view("admin.account_admin");
  }

  public function affectxedit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'editor' => 'required|max:50',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => ' renseignez les champs requis'
            ]);
        } else {
            DB::table('work_editor')->insert(
                [
                    'work_id' =>  $this->controle_space($request->input('id_work')),
                    'editor_id' => $this->controle_space($request->input('editor')),
                ]
            );

            $editor = DB::table('users')
                ->where('id', $request->input('editor'))
                ->first('name');
            $users = DB::table('users')
                ->where('id', auth()->User()->id)
                ->first('name');
            $p = DB::table('works')
                ->where('id_work', $request->input('id_work'))
                ->first('titre_travail');
        
            return redirect()->back()->with('success', 'Assignation réussie');
            $editor2 = DB::table('users')->where('id', $request->input('editor'))->first();
            if ($editor2) {
                session(['editor' => $editor2]); // Store the editor data in the session
                return redirect()->route('send-editor-email')->with('success', 'Assignation réussie');
            } else {
                return redirect()->back()->with('success', "Assignation réussie sans envoie de l'email.");
            }
        }
    }


    public function update_admin_redation($work_id)
    {
        return view('admin.redaction.update')
            ->with('work_id', $work_id);
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
            $docs = [];
            $element_forme = $request->input('element_forme');
            if (!is_null($element_forme)) {
                foreach ($element_forme as $doc) {
                    array_push($docs, $doc);
                }
            }

            DB::table('mise_en_forme')
                ->where('work_id', $request->work_id)
                ->update(array(
                    'police' => $this->tools->controle_space($request->input('police')),
                    'element_inclure' => json_encode($docs),
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
                    $file_path = 'images/work_doc/'.$codes_doc->code_doc;
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }

                if ($request->file('link_doc')) {
                    foreach ($request->file('link_doc') as $key => $file) {
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $request->work_id . time() . rand(1, 99999).'.'.$extension;
                        $file->move('images/work_doc/',$fileName);
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
                
            return redirect()->route('status', ['id' => $request->work_id]);
        }
    }

    public function  send_customer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rework' => 'required|max:50',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => ' renseignez les champs requis'
            ]);
        } else {
            DB::table('rework_end')
                ->where('rework_editor_id', $this->controle_space($request->input('rework')))
                ->update(array(
                    'statut' =>  'admin_send',
                    'admin' => $this->controle_space($request->input('admin')),
                ));
        $users = DB::table('users')
                ->where('id', auth()->User()->id)
                ->first('name');
        } 
        return redirect()->back()->with('success', 'You have successfully sent this reworked image to client.');
    }


  
}
