<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Socialite;
use Exception;
use Auth;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class SocialController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        try {

            $googleUser = Socialite::driver('google')->user();
            $dbUser = User::where('google_id', $googleUser->id)->orWhere('email',$googleUser->email)->first();
            if ($dbUser) {
                $dbUser->update(['google_id' => $googleUser->id]);

                // Auth::login($isUser);
                $tokenResult = $dbUser->createToken('Personal Access Token');
                $token = $tokenResult->token;
                // if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();
                $url = URL::to('/');
                $access_token = $tokenResult->accessToken;
                $user_id = $dbUser->id;
                return view('login', compact('url', 'user_id', 'access_token'));
            } else {
                //fb user data
                $googleEmail = $googleUser->email;
                $googleId = $googleUser->id;
                $user = User::create([
                    'email' => $googleEmail,
                    'google_id' => $googleId
                ]);
                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->token;
                // if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();
                $url = URL::to('/');
                $access_token = $tokenResult->accessToken;
                $user_id = $user->id;
                return view('login', compact('url', 'user_id', 'access_token'));
            }
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function loginWithFacebook()
    {
        try {

            $fbUser = Socialite::driver('facebook')->user();
            $dbUser = User::where('fb_id', $fbUser->id)->orWhere('email',$fbUser->email)->first();


            if ($dbUser) {
                $dbUser->update(['fb_id' => $fbUser->id]);
                // Auth::login($isUser);
                $tokenResult = $dbUser->createToken('Personal Access Token');
                $token = $tokenResult->token;
                // if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();
                $url = URL::to('/');
                $access_token = $tokenResult->accessToken;
                $user_id = $dbUser->id;
                return view('login', compact('url', 'user_id', 'access_token'));
            } else {
                //fb user data
                $fbEmail = $fbUser->email;
                $fbId = $fbUser->id;
                $user = User::create([
                    'email' => $fbEmail,
                    'fb_id' => $fbId
                ]);
                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->token;
                // if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();
                $url = URL::to('/');
                $access_token = $tokenResult->accessToken;
                $user_id = $user->id;
                return view('login', compact('url', 'user_id', 'access_token'));
            }
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
