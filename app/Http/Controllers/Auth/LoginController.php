<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function redirectToProvider($provider)
    {
        
        return Socialite::driver($provider)->redirect();

    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $providerUser = Socialite::driver($provider)->user();
        
      

           if(null!==$providerUser->getNickname()){
               $username=$providerUser->getNickname();
           }
           else{
               $username=$providerUser->getName();
           }
        $user = User::firstOrCreate([
            'provider_id' => $providerUser->getId(),
        ],
        [ 
            'username' => $username,
            'email' => $providerUser->getEmail(),
            'name'=>   $providerUser->getName(),
            'avatar' => $providerUser->getAvatar(),
        ],
    );

        auth()->login($user,true);
        
        return redirect()->route('home');
    }


}
