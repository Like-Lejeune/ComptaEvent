<?php

// app/Http/Middleware/CheckPlan.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPlan
{
    public function handle(Request $request, Closure $next, $feature = null)
    {
        $user = auth()->user();
        $plan = $user->abonnement?->plan;

        if (!$plan) {
            return response()->json(['message' => 'Aucun plan actif.'], 403);
        }

        // Vérifier une feature spécifique
        if ($feature && !$user->checkplan($feature)) {
            return response()->json([
                'message' => "Fonctionnalité réservée au Premium."
            ], 403);
        }

        return $next($request);
    }
}
