<?php

namespace App\Http\Controllers;

use App\Models\SocialProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
  public function redirectToSocialNetwork($socialNetwork) {

     try {
        return Socialite::driver($socialNetwork)->redirect();
     } catch (\Throwable $th) {
        return redirect()->route('login')->with('warning', 'No es posible autenticarse con ' . $socialNetwork);
     }
  }

  public function handleSocialNetworkCallback($socialNetwork) {

    if ( ! request('code'))
    {
        return redirect()->route('login')->with('warning', 'hubo un error...');
    }

    $socialUser = Socialite::driver($socialNetwork)->user();

    $socialProfile = SocialProfile::firstOrNew([
        'social_network' => $socialNetwork,
        'social_network_user_id' => $socialUser->getId()

    ]);

    if ( !  $socialProfile->exists )

    {
        $user = User::firstOrNew(['email' =>  $socialProfile->getEmail()]);
        if ( ! $user->exists )
        {
            $user->name = $socialUser->getName();
            $user->save();
        }

        $socialProfile->avatar = $socialUser->getAvatar();

        $user->profiles()->save( $socialProfile );
    }

    Auth::login( $socialProfile->user);

    return redirect()->route('home')->with('success', 'Bienvenido ' .  $socialProfile->user->name);
  }
}
