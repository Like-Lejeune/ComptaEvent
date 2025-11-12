<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke($id, $hash)
    {
        $user = User::find($id);
        // Log::info('user-req' , ['user' => $request]);
        if (!$user) {
            return response()->json(['message' => __('user_not_found')], 404);
        }
        Log::info($user->getEmailForVerification());
        // Verify that the hash matches the one associated with the email
        if (sha1($user->getEmailForVerification()) !== $hash) {
            return response()->json(['message' => __('invalid_verification_link')], 400);
        }

        // Check if the email is already verified
        if ($user->hasVerifiedEmail()) {
            Auth::login($user);
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'message' => __('already_verified'),
                'token' => $token,
                'verified' => true
            ]);
        }

        // If not verified, mark as verified and trigger the Verified event
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // Generate the token after verification
        $token = $user->createToken('auth-token')->plainTextToken;
        Auth::login($user);

        return response()->json([
            'message' => __('email_verified'),
            'token' => $token,
            'verified' => true
        ]);
    }
}