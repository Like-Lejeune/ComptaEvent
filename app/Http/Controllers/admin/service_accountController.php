<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Service;
use Illuminate\Support\Facades\DB;
use \Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class service_accountController extends Controller
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

  public function edit($service_id)
  {
    $service = DB::table('services')->where('id_service', $service_id)->first();
    return response()->json($service);
  }


  public function update_service(Request $request)
  {
    if ($request->file('image')) {

      $file = $request->file('image');
      $extension = $file->getClientOriginalExtension();
      $filename = $this->controle_space($request->name_service).time().'.'. $extension;
      $file->move('images/services', $filename);
      $service = $filename;
    }
    DB::table('services')
      ->where('id_service', $request->id_service)
      ->update(array(
        's_name' => $this->controle_space($request->name_service),
        's_description' => $this->controle_space($request->description_service),
        's_price' => $this->controle_space($request->price_service),
        's_photo' => $service,
      ));
    return redirect()->back()
      ->with('success', 'You have successfully update services.');
  }


  public function add_service(Request $request)
  {

    $service_name = array(

      "SAISIE & MISE EN FORME",
      "REDACTION GENERALE",
      "MONTAGE POWERPOINT",
      "MONTAGE & RELECTURE CV",
      "TRANSCRIPTION NUMERIQUE",
      "ASSISTANCE TECHNOLOGIQUE",
    );

    for ($i = 0; $i < 9; $i++) {
      $service = new Service();
      $existe = DB::table('services')
        ->where('s_name', $service_name[$i])
        ->count();
      if ($existe == 0) {
        $service->s_name = $service_name[$i];
        $service->s_description = "this is the default text you must change this to match the description of the registered service. You must do this";
        $service->s_price = "5.50";
        $service->s_photo = "default.png";
        $service->save();
      }
    }
    return redirect()->back()
      ->with('success', 'You have successfully add services.');
  }

  public function AdminService(Request $request)
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

              return view('admin.mrcv.Mrcv')
                  ->with('service_id', $request->id);
              break;

          case ("REDACTION GENERALE"):

              return view('admin.redaction.redaction')
                  ->with('service_id', $request->id);

              break;

          case ("SAISIE & MISE EN FORME"):

              return view('admin.smf.Smf')
                  ->with('service_id', $request->id);

              break;

          case ("THE CONFIDENT"):

              return view('coming_soon');

              break;

          case ("MONTAGE-REDACTION PRO DES CV"):

              return view('coming_soon');

              break;

          case ("CONVERSION DOCUMENTS EN AUDIO"):

              return view('coming_soon');

              break;


          default:
              return view('coming_soon');

      endswitch;
  }

}
