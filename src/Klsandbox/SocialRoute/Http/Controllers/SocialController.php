<?php

namespace Klsandbox\SocialRoute\Http\Controllers;


use App\Http\Controllers;
use App\User;
use Auth;
use Laravel\Socialite\Contracts\Factory as Socialite;

class SocialController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Socialite $socialite)
    {
        $this->socialite = $socialite;
    }


    public function getSocialAuth($provider = null)
    {
        if (!config("services.$provider")) abort('404'); //just to handle providers that doesn't exist

        return $this->socialite->with($provider)->redirect();
    }


    public function getSocialAuthCallback($provider = null)
    {
        $user = $this->socialite->with($provider)->user();
        if ($user) {
            $authUser = $this->findOrCreateUser($user);

            Auth::login($authUser, true);

            return redirect('/');
        } else {
            return 'something went wrong';
        }
    }


    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $facebookUser
     * @return User
     */
    private function findOrCreateUser($facebookUser)
    {
        $authUser = User::where('facebook_id', $facebookUser->id)->first();

        if ($authUser) {
            return $authUser;
        }

        $user = new User();
        $user->name = $facebookUser->name;
        $user->email = $facebookUser->email;
        $user->facebook_id = $facebookUser->id;
        $user->avatar = $facebookUser->avatar;

        $user->save();

        return $user;
    }
}
