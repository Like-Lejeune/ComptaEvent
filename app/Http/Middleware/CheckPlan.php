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

        $planType = $user->getPlanType();

        switch ($planType) {
            case 'Freemium':
                return redirect()->route('subscription.upgrade')
                    ->with('error', 'Votre plan actuel est Freemium. Passez à Premium pour accéder à cette fonctionnalité.');
            
            case 'Premium pro':
                return redirect()->route('subscription.pro')
                    ->with('info', 'Améliorez votre plan vers Pro pour débloquer cette fonctionnalité.');

            case 'Premium  Standard':
                return $next($request);

            default:
                return redirect()->route('subscription.page')
                    ->with('error', 'Veuillez souscrire à un plan pour accéder à cette page.');
        }
    }
}

