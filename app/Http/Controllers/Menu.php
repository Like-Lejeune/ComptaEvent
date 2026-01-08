<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Evenement;
use Carbon\Carbon;
class Menu extends Controller
{
    public function controle_space($chaine)
    {
        $chaine = trim($chaine);
        $chaine = str_replace("###antiSlashe###t", " ", $chaine);
        $chaine = preg_replace("!\s+!", " ", $chaine);
        $chaine = htmlspecialchars($chaine);
        return $chaine;
    }

    public function Menu()
    {
        return view('vitrine.Menu');
    }

    public function administrator()
    {
        // Compter les événements de l’utilisateur connecté
        $count = Evenement::where('utilisateur_id', auth()->User()->id)->count();
        $event_id = Evenement::where('utilisateur_id', auth()->User()->id)->first();
        // Redirection intelligente
        if ($count > 3) {
            return redirect()->route('events');   // l’utilisateur a plusieurs événements
        }

        $userId = auth()->User()->id;

        // Liste des services
        $services = DB::table('services')
            ->join('evenements', 'evenements.id', '=', 'services.evenement_id')
            ->where('evenements.utilisateur_id', $userId)
            ->where('evenements.id', $event_id)
            ->orderBy('s_name', 'asc')
            ->get();

        // Statistiques globales
        $countService = DB::table('services')
            ->join('evenements', 'evenements.id', '=', 'services.evenement_id')
            ->where('evenements.utilisateur_id', $userId)
            ->count();

        $sumPrix = DB::table('evenements')
            ->where('utilisateur_id', $userId)
            ->where('evenements.id', $event_id)
            ->sum('budget_total');
        $sumDepenses = DB::table('depense')
            ->join('evenements', 'evenements.id', '=', 'depense.evenement_id')
            ->where('evenements.utilisateur_id', $userId)
            ->where('evenements.id', $event_id)
            ->sum('s_depense');

        $sumSolde = DB::table('services')
            ->join('evenements', 'evenements.id', '=', 'services.evenement_id')
            ->where('evenements.utilisateur_id', $userId)
            ->where('evenements.id', $event_id)
            ->sum('s_solde');
    
        return view('admin.Menu', compact(
            'services',
            'countService',
            'sumPrix',
            'sumDepenses',
            'sumSolde',
            'event_id'
        ));

        
    }


    public function user_menu()
    { 
        $service = DB::table('services')
                ->join('user_service', 'id_service', '=', 'service_id')
                ->where('user_id', auth()->User()->id)
                ->get();
        return view('users.Menu')->with('services',  $service);
    }

    public function serviceMenu($event_id)
    {
        
        $userId = auth()->User()->id;

        // Liste des services
        $services = DB::table('services')
            ->join('evenements', 'evenements.id', '=', 'services.evenement_id')
            ->where('evenements.utilisateur_id', $userId)
            ->where('evenements.id', $event_id)
            ->orderBy('s_name', 'asc')
            ->get();

        // Statistiques globales
        $countService = DB::table('services')
            ->join('evenements', 'evenements.id', '=', 'services.evenement_id')
            ->where('evenements.utilisateur_id', $userId)
            ->count();

        $sumPrix = DB::table('evenements')
            ->where('utilisateur_id', $userId)
            ->where('evenements.id', $event_id)
            ->sum('budget_total');
        $sumDepenses = DB::table('depense')
            ->join('evenements', 'evenements.id', '=', 'depense.evenement_id')
            ->where('evenements.utilisateur_id', $userId)
            ->where('evenements.id', $event_id)
            ->sum('s_depense');

        $sumSolde = DB::table('services')
            ->join('evenements', 'evenements.id', '=', 'services.evenement_id')
            ->where('evenements.utilisateur_id', $userId)
            ->where('evenements.id', $event_id)
            ->sum('s_solde');
    
        return view('admin.Menu', compact(
            'services',
            'countService',
            'sumPrix',
            'sumDepenses',
            'sumSolde',
            'event_id'
        ));

       // return view('admin.Menu');  // sinon, menu admin
    }

    public function eventMenu()
    {
        $evenements = Evenement::with('utilisateur')
        ->where('utilisateur_id', auth()->User()->id)
        ->orderBy('date_debut', 'ASC')
        ->get()
        ->map(function ($evt) {

            $fin = Carbon::parse($evt->date_fin);
            $aujourdhui = Carbon::now();

            if ($aujourdhui->lessThanOrEqualTo($fin)) {
                // Événement en cours ou futur
                $jours = $aujourdhui->diffInDays($fin);
                $evt->jours_text = $jours . ' jour(s) restant(s)';
                $evt->jours_color = 'text-success';
            } else {
                // Événement dépassé
                $jours = $fin->diffInDays($aujourdhui);
                $evt->jours_text = $jours . ' jour(s) de retard';
                $evt->jours_color = 'text-danger fw-bold';
            }

            return $evt;
        });

        return view('admin.event', compact('evenements'));
    }


}