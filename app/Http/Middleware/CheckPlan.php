<?php

// app/Http/Middleware/CheckPlan.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPlan
{
    public function handle(Request $request, Closure $next)
    {
         $user = $request->user();

    if (!$user) {
        return redirect()->route('login');
    }

    $plan = $user->getPlanType();

    // 🚫 Cas Freemium → bloqué
    if ($plan === 'Freemium') {
        return redirect()->route('subscription.upgrade')
            ->with('error', 'Votre plan actuel est Freemium. Passez à un plan supérieur pour accéder à cette fonctionnalité.');
    }

    // ✔ Cas Standard → accès normal
    if ($plan === 'Premium Standard') {
        return $next($request);
    }

    // ✔ Cas Pro → accès normal
    if ($plan === 'Premium Pro') {
        return $next($request);
    }

    // Si jamais un cas bizarre arrive
    return redirect()->route('subscription.page')
        ->with('info', 'Veuillez souscrire à un plan pour accéder à cette page.');
    }

}

