<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\Service;
use \Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class option_accountController extends Controller
{
    //


     //
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

     public function menu_option(Request $request)
     {
 
     }

   public function edit($option_id)
   {
     $option = DB::table('options')->where('id_option', $option_id)->first();
     return response()->json($option);
   }
 
   public function update_option(Request $request)
   {
     DB::table('options')
       ->where('option_id', $request->id_option)
       ->update(array(
         'option_name' => $this->controle_space($request->name_option),
         'option_description' => $this->controle_space($request->description_option),
         'option_price' => $this->controle_space($request->price_option),
       ));
       return redirect()->route('all_options');
   }

}
