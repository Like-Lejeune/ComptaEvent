<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Tools;
use Illuminate\Support\Facades\Validator;

class serviceController extends Controller
{
    //
    private $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }


   public function index()
    {
        $services = Service::all();
        return view('admin.services', compact('services'));
    }

    public function nouveauService(Request $request)
  {

    $validator = Validator::make($request->all(), [

        's_service' => 'required',
        's_budget' => 'required',
    ]);
    if ($validator->fails()) {

        return redirect()->back()->with('error', 'informations insuffisantes');
    } else {

        $service = DB::table('services')->insertGetId(
            [
                's_name' => $this->tools->controle_space($request->input('s_service')),
                //'s_description' => $this->tools->controle_space($request->input('description')),
                //'s_photo' => "default.png",
                's_solde' => $this->tools->controle_space($request->input('s_budget')),
                's_budget' => $this->tools->controle_space($request->input('s_budget')),
            ]
        );
    }
    return redirect()->back()
      ->with('success', 'You have successfully add services.');
  }

  public function editService($service_id)
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
      $image = $filename;
    }
    DB::table('services')
      ->where('id_service', $request->id_service)
      ->update(array(
        's_name' => $this->controle_space($request->name_service),
        's_description' => $this->controle_space($request->description_service),
        's_budget' => $this->controle_space($request->budget_service),
        's_photo' => $image,
      ));
    return redirect()->back()
      ->with('success', 'You have successfully update services.');
  }

  public function updateBudget(Request $request)
  {
    $validator = Validator::make($request->all(), [

        'budget' => 'required',
        'service' => 'required',

    ]);
    if ($validator->fails()) {

        return redirect()->back()->with('error', 'Remplissez les champs requis');
    } else {
            $total_depense = DB::table('depense')
              ->where('service_id', $request->service)
              ->sum('s_depense');

            DB::table('services')
            ->where('id_service', $request->service)
            ->update(array(
                's_budget' => $this->tools->controle_space($request->input('budget')),
                's_solde' => $this->tools->controle_space($request->input('budget'))- $total_depense,
            ));

            return redirect()->back()->with('success', 'Modification du budget réussie.');
    }
  }
}
