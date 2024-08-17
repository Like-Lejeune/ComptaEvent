<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Tools;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class pdfController extends Controller
{
    //

    public function etat_service_pdf($service_id)
    {     
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
            ]);
             return $pdf->stream('ETAT PDF :'.$info_service->s_name.'.pdf');
        } else {
            return redirect()->back();
        }
        
    }
}
