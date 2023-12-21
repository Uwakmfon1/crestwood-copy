<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest', 'guest:admin']);
    }

    public function redirect($provider): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function socialLoginAttempt($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
            $existingUser = $this->getUser($user->getId());
            if($existingUser){
                Auth::login($existingUser);
                return redirect('/dashboard');
            } else {
                if (User::where('email', $user->email)->first()){
                    return redirect('/login')->with('error', 'Email already exist, try using a different account');
                }
                $data = [
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'password' => bcrypt($user->getId()),
                    'avatar' => $user->getAvatar()
                ];
                switch ($provider){
                    case 'facebook':
                        $data['facebook_id'] = $user->getId();
                        break;
                    case 'google' :
                        $data['google_id'] = $user->getId();
                        break;
                }
                $user = User::create($data);
                $user['email_verified_at'] = now();
                $user->update();
                Auth::login($user);
                return redirect()->to('/dashboard');
            }
        }catch (\Exception $exception)
        {
            return redirect('/login')->with('error', 'An error occurred, try again');
        }
    }

    protected function getUser($id) {
        return User::where(function ($q) use ($id) {
            $q->where('facebook_id', $id)
                ->orWhere('google_id', $id);
        })->first();
    }
}
