<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Tools;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Depense;
use App\Models\Service;

class pdfController extends Controller
{
    //

    public function etat_service_pdf($service_id)
    {     

         $countService = DB::table('depense')
             ->where('service_id', '=', $service_id)
             ->count();
    
         $budget = DB::table('services')
         ->where('id_service', '=', $service_id)
         ->sum('s_budget');
       
         $sum_depense = DB::table('depense')
         ->where('service_id', '=', $service_id)
         ->sum('s_depense');
        
             $solde = DB::table('services')
                ->where('id_service', '=', $service_id)
                ->sum('s_solde');
    
            $depense = DB::table('depense')
                ->where('service_id', '=', $service_id)
                ->get();
            $conso =($sum_depense*100)/$budget;

            $pos= 0;

        $depense = Depense::where('service_id', $service_id)
            ->get()
            ->map(function ($d) {
                $d->nb_piece = DB::table('piece_jointe')
                    ->where('depense_id', $d->id_depense)
                    ->count();
                return $d;
        });

        /* ===== GRAPH BAR CHART ===== */
        $im = imagecreatetruecolor(480, 260);
        $white = imagecolorallocate($im, 255,255,255);
        $black = imagecolorallocate($im, 0,0,0);
        $blue  = imagecolorallocate($im, 0,51,102);

        imagefilledrectangle($im, 0, 0, 480, 260, $white);

        imagefilledrectangle($im, 60, 200 - ($budget/10000), 120, 200, $blue);
        imagestring($im, 4, 70, 210, "Budget", $black);

        imagefilledrectangle($im, 180, 200 - ($sum_depense/10000), 240, 200, $blue);
        imagestring($im, 4, 180, 210, "Depense", $black);

        ob_start();
        imagepng($im);
        $chartBase64 = "data:image/png;base64," . base64_encode(ob_get_clean());
        imagedestroy($im);

        $conso = $budget > 0 ? ($sum_depense * 100) / $budget : 0;

        $currentDateTime = Carbon::now()->format('Y-m-d H:i');   
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
            $pdf = Pdf::loadView('pdf.etat_service_pdf', [
                'service' => $service,
                'info'  => $info_service,
                'date_courante' => $currentDateTime,
                'countService'=>  $countService,
                'budget'=>  $budget,
                'sum_depense'=> $sum_depense,
                'solde'=> $solde,
                'conso'=> $conso,
                'depense'=> $depense,
                'chartBase64'=> $chartBase64,
                'pos' =>$pos
            ]);
             return $pdf->stream('ETAT PDF :'.$info_service->s_name.'.pdf');
        } else {
            return redirect()->back();
        }
        
    }

    public function etat_global_pdf()
    {     
        $user = auth()->user();
        $currentDateTime = Carbon::now()->format('Y-m-d H:i');   
        $service = DB::table('services')
            ->join('evenements', 'evenements.id', '=', 'services.evenement_id')
            ->where('evenements.utilisateur_id', $user->id)
            ->orderBy('s_name', 'asc')
            ->get(); 
        $count = DB::table('depense')
                    ->join('evenements', 'evenements.id', '=', 'depense.evenement_id')
                    ->where('evenements.utilisateur_id', $user->id)
                    ->count();
        $info_service = DB::table('services')
            ->join('evenements', 'evenements.id', '=', 'services.evenement_id')
            ->where('evenements.utilisateur_id', $user->id)
            ->orderBy('s_name', 'asc')
            ->get(); 

             $countService = DB::table('services')->count();

        // Liste des services
         $services = DB::table('services')
            ->join('evenements', 'evenements.id', '=', 'services.evenement_id')
            ->where('evenements.utilisateur_id', $user->id)
            ->orderBy('s_name', 'asc')
            ->get(); 
        $sum_depense = DB::table('depense')
                    ->join('evenements', 'evenements.id', '=', 'depense.evenement_id')
                    ->where('evenements.utilisateur_id', $user->id)
                    ->sum('s_depense');
        $budget = DB::table('evenements')
                    ->where('evenements.utilisateur_id', $user->id)
                    ->sum('budget_total');
        $solde = DB::table('services')
            ->join('evenements', 'evenements.id', '=', 'services.evenement_id')
            ->where('evenements.utilisateur_id', $user->id)
            ->orderBy('s_name', 'asc')
            ->sum('s_solde');
        $conso = $budget > 0 ? ($sum_depense * 100) / $budget : 0;
        $pos = 0;
            if ($count > 0) {
                $pdf = Pdf::loadView('pdf.etat_global_pdf', [
                    'service' => $service,
                    'info' => $info_service,
                    'date_courante' => $currentDateTime,
                    'countService' => $countService,
                    'services'=> $services,
                    'sum_depense'=> $sum_depense,
                    'budget'=> $budget ,
                    'solde'=>$solde,
                    'conso'=>$conso,
                    'pos' =>$pos
                ])->setPaper('a4', 'landscape'); // Définir le papier au format A4 et en mode paysage
                
                return $pdf->stream('Etat Global ' . $currentDateTime . '.pdf');
        } else {
            return redirect()->back();
        }
        
    }
}
