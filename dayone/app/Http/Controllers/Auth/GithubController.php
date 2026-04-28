<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GithubController extends Controller
{
    public function redirect(): RedirectResponse
    {
        if (! Config::get('services.github.client_id') || ! Config::get('services.github.client_secret') || ! Config::get('services.github.redirect')) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'github' => 'GitHub login is not configured. Set GITHUB_CLIENT_ID, GITHUB_CLIENT_SECRET, and GITHUB_REDIRECT_URI in .env.',
                ]);
        }

        return Socialite::driver('github')->redirect();
    }

    public function callback(): RedirectResponse
    {
        $githubUser = Socialite::driver('github')->user();
        $email = $githubUser->getEmail() ?: sprintf('%s@users.noreply.github.com', $githubUser->getId());

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $githubUser->getName() ?: $githubUser->getNickname() ?: 'GitHub User',
                'github_id' => (string) $githubUser->getId(),
                'github_token' => $githubUser->token,
                'github_refresh_token' => $githubUser->refreshToken,
                'password' => Hash::make(Str::password(32)),
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user, remember: true);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
