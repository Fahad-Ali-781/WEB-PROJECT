<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class SocialAuthController extends Controller
{
    public function redirect(string $provider)
    {
        abort_unless(in_array($provider, ['google', 'facebook'], true), 404);

        if (! config("services.$provider.client_id") || ! config("services.$provider.client_secret")) {
            return redirect()->back()->withErrors([
                'social' => ucfirst($provider) . ' login is not configured yet. Set the client ID and client secret in your .env file.',
            ]);
        }

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        abort_unless(in_array($provider, ['google', 'facebook'], true), 404);

        if (! config("services.$provider.client_id") || ! config("services.$provider.client_secret")) {
            return redirect()->route('login')->withErrors([
                'social' => ucfirst($provider) . ' login is not configured yet. Set the client ID and client secret in your .env file.',
            ]);
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (InvalidStateException $exception) {
            // Retry once without state validation for cases where callback session state is lost.
            Log::warning('Social auth invalid state. Retrying stateless callback.', [
                'provider' => $provider,
                'ip' => request()->ip(),
                'error' => $exception->getMessage(),
            ]);

            $socialUser = Socialite::driver($provider)->stateless()->user();
        }

        $email = $socialUser->getEmail() ?: $provider . '_' . $socialUser->getId() . '@gamegrid.local';

        $user = User::where(function ($query) use ($provider, $socialUser, $email) {
            $query->where('provider', $provider)
                ->where('provider_id', $socialUser->getId())
                ->orWhere('email', $email);
        })->first();

        if ($user) {
            $user->update([
                'name' => $socialUser->getName() ?: $socialUser->getNickname() ?: $user->name,
                'email' => $email,
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);
        } else {
            $user = User::create([
                'name' => $socialUser->getName() ?: $socialUser->getNickname() ?: 'GameGrid User',
                'email' => $email,
                'password' => Hash::make(str()->random(32)),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);
        }

        Auth::login($user, true);

        return redirect()->route('home')->with('success', 'Signed in successfully with ' . ucfirst($provider) . '.');
    }
}