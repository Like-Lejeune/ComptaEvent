<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;
use App\Models\Abonnement;

class SubscriptionController extends Controller
{
    /**
     * Page principale d'abonnement
     */
    public function index()
    {
        $plans = Plan::all();
        return view('subscription.index', compact('plans'));
    }

    /**
     * Page d’upgrade (présente les offres payantes)
     */
    public function upgrade()
    {
        // On récupère uniquement les plans payants
        $plans = Plan::where('nom', '!=', 'Freemium')->get();
        return view('subscription.upgrade', compact('plans'));
    }

    /**
     * Page spécifique pour le plan PRO
     */
    public function pro()
    {
        $plan = Plan::where('nom', 'Premium Pro')->firstOrFail();
        return view('subscription.pro', compact('plan'));
    }

    /**
     * Traitement du paiement (simulé)
     */
    public function pay(Request $request, Plan $plan)
    {
        $user = Auth::user();

        // Création ou mise à jour de l'abonnement
        $abonnement = Abonnement::updateOrCreate(
            ['user_id' => $user->id],
            [
                'plan_id' => $plan->id,
                'date_debut' => now(),
                'date_fin' => $plan->duree_jours ? now()->addDays($plan->duree_jours) : null,
                'is_active' => true
            ]
        );

        return redirect()->route('dashboard')->with('success', "Félicitations 🎉, vous êtes maintenant sur le plan {$plan->nom} !");
    }
}
