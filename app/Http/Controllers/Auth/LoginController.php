<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Login;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @param mixed $provider
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @param mixed $provider
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        $user = Socialite::driver($provider)->user();

        try {
            $laravelUser = User::where($provider, $user->id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $laravelUser = User::create([
                'first_name' => $user->user['given_name'],
                'last_name' => $user->user['family_name'],
                'email' => $user->email,
                'avatar' => $user->avatar,
                'google' => $user->id,
                'password' => bcrypt(Str::random(32)),
            ]);
        }

        Auth::login($laravelUser);

        return $this->sendLoginResponse($request);
    }

    public function username()
    {
        return 'username';
    }

    public function authenticated()
    {
        $user = auth()->user();

        if (! $user->hasAnyRole(['Super Administrator', 'Administrator'])) {
            auth()->logout();
            session()->flash('login.error', 'You are not authorized to access this website');

            return redirect()->back();
        }
    }
}
