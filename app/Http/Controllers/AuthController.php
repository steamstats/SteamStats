<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Invisnik\LaravelSteamAuth\SteamAuth;
use App\Models\User;
use mysql_xdevapi\Session;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * The SteamAuth instance.
     *
     * @var SteamAuth
     */
    protected $steam;

    /**
     * The redirect URL.
     *
     * @var string
     *
     */

//    protected $redirectURL;

    /**
     * AuthController constructor.
     *
     * @param SteamAuth $steam
     */
    public function __construct(SteamAuth $steam)
    {
        $this->steam = $steam;
    }


    /**
     * @return RedirectResponse
     */
    public function redirectToSteam(Request $request)
    {
        $test = session()->previousUrl();

        $request->session()->put('testUrl', $test);

        return $this->steam->redirect();
    }

    /**
     * Get user info and log in
     *
     * @return RedirectResponse|Redirector
     */
    public function handle(Request $request)
    {
        $redirectUrl = $request->session()->get('testUrl');

        if ($this->steam->validate()) {
            $info = $this->steam->getUserInfo();

            if (!is_null($info)) {
                $user = $this->findOrNewUser($info);

                Auth::login($user, true);

                return redirect($redirectUrl); // redirect to site
            }
        }
        return $this->redirectToSteam();
    }

    /**
     * Getting user by info or created if not exists
     *
     * @param $info
     * @return User
     */
    protected function findOrNewUser($info)
    {
        $user = User::where('steamid', $info->steamID64)->first();

        if (!is_null($user)) {

            User::where('steamid', $info->steamID64)
                ->update([
                    'name' => $info->personaname,
                    'avatar' => $info->avatarfull,
                    'steamid' => $info->steamID64
                ]);

            return $user;
        }

        return User::create([
            'name' => $info->personaname,
            'avatar' => $info->avatarfull,
            'steamid' => $info->steamID64
        ]);
    }
}
