<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Services\Admin\UserService;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\NotificationController;

class UserController extends Controller
{
    public function __construct
    (
        public UserService $userService
    ) { }

    public function index(){ return $this->userService->index();}

    
    public function show($user) { return $this->userService->show($user);}


    public function statusUpdate(Request $request, User $user)
    {
        return $this->userService->statusUpdate($request, $user);
    }

    public function identityUpdate(Request $request, User $user)
    {
        return $this->userService->identityUpdate($request, $user);
    }

    public function showLogin(){ return $this->userService->showLogin();}
   

    /**
     * @throws ValidationException
     */
    public function login(){return $this->userService->login();}
   
    public function generateLoginLink($userId){ return $this->userService->generateLoginLink($userId);}
   
    public function loginAsUserToken(Request $request, $userId) 
    {
        return $this->userService->loginAsUserToken($request,$userId);
    }

    public function block(User $user)
    {
        return $this->userService->block($user);
    }

    public function unblock(User $user)
    {
        return $this->userService->unblock($user);
    }
    
    public function destroy(User $user)
    {
        return $this->userService->destroy($user);
    }

    public function fetchUsersWithAjax(Request $request, $type)
    {
        return $this->userService->fetchUsersWithAjax($request, $type);
    }

}
