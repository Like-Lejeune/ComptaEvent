<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use \Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class customer_accountController extends Controller

{
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
 
   public function add_customer(Request $request)
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
        $nb = DB::table('users')->where('type', 'client')->count();
        
        $nb++; 
        $nb = $nb++;
       $user = new user();
       $user->name =  $this->controle_space($request->input('name_user_'));
       $user->email = 'MT' . $nb. "C" . date('Y')[2] . date('Y')[3].'@default.com';
       $user->type = 'client';
       $user->password =  Hash::make('mytaskwork');
       $user->phone = '6 95 25 48 '.$nb.$nb;
       $user->wallet = 0;
       $user->status = 1;
       $user->action = '';
       $user->matricule = 'MT' . $nb. "C" . date('Y')[2] . date('Y')[3];
       $user->save();

       return redirect()->route('all_customers');
     }
   }

   public function update_customer(Request $request)
  {
    DB::table('users')
      ->where('id', $request->id_user)
      ->update(array(
        'name' => $this->controle_space($request->name_user),
        'email' => $this->controle_space($request->email_user),
        'phone' => $this->controle_space($request->phone_user),
        'type' => 'client',
        'password' => $this->controle_space($request->password_user),
        'wallet' => 0,
        'status' => 0,
        'action' => '',
        'matricule' => $this->controle_space($request->matricule_user),
      ));
      return redirect()->route('all_customers');
  }
}
