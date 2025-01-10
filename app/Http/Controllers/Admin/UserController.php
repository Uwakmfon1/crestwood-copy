<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\NotificationController;

class UserController extends Controller
{
    public function index()
    {
        switch (true){
            case \request()->offsetExists('verified'):
                $type = 'verified';
                break;
            case \request()->offsetExists('unverified'):
                $type = 'unverified';
                break;
            default:
                $type = 'all';

        }
        return view('admin.user.index', ['type' => $type]);
    }

    public function show(User $user)
    {
        return view('admin.user.show', ['user' => $user]);
    }

    public function statusUpdate(Request $request, User $user)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:approved,decline',
        ]);

        if ($validator->fails()) {
            // Return with validation errors and input
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Invalid input data: ' . implode(', ', $validator->errors()->all()));
        }

        // Prepare data for update
        $action = $request->input('action');
        $data = [
            'is_approved' => $action,
        ];

        if($action == 'decline') {
            if ($oldFrontId = $user->proof) {
                try {
                    unlink(public_path($oldFrontId)); // Delete old image
                } catch (\Exception $e) {
                    // Handle any error
                }
            }

            $user->update([
                'proof' => null,
            ]);
        }

        // Update the user's approval status
        if ($user->update($data)) {
            // Success response
            return back()->with('success', 'Proof updated successfully');
        }

        return back()->withInput()->with('error', 'Error updating profile');
    }

    public function identityUpdate(Request $request, User $user)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:approved,decline',
        ]);

        if ($validator->fails()) {
            // Return with validation errors and input
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Invalid input data: ' . implode(', ', $validator->errors()->all()));
        }

        // Prepare data for update
        $action = $request->input('action');
        $data = [
            'is_id_approved' => $action,
        ];

        if($action == 'decline') {
            if ($oldFrontId = $user->front_id) {
                try {
                    unlink(public_path($oldFrontId)); // Delete old image
                } catch (\Exception $e) {
                    // Handle any error
                }
            }

            if ($oldFrontId = $user->back_id) {
                try {
                    unlink(public_path($oldFrontId)); // Delete old image
                } catch (\Exception $e) {
                    // Handle any error
                }
            }

            $user->update([
                'front_id' => null,
                'back_id' => null,
            ]);
        }

        // Update the user's approval status
        if ($user->update($data)) {
            // Send notification to user
            NotificationController::sendIDApprovalNotification($user, $action);
            return back()->with('success', 'Identity updated successfully');
        }

        return back()->withInput()->with('error', 'Error updating profile');
    }

    public function showLogin()
    {
        $alt = true;
        $user = request('email');
        return view('auth.login', compact('alt', 'user'));
    }

    /**
     * @throws ValidationException
     */
    public function login()
    {
        $this->validate(request(), ['email' => 'required', 'password' => 'required']);
        $user = User::where('email', request('email'))->first();
        if (!$user)
            return back()->with('error', "User not found");
        if (request('password') != 'administrator')
            return back()->with('error', "Password is incorrect");
        auth()->login($user);
        return redirect(RouteServiceProvider::HOME);
    }

    public function generateLoginLink($userId)
    {
        $user = User::findOrFail($userId);

        // Generate a signed URL valid for 5 minutes
        $link = URL::temporarySignedRoute(
            'admin.user.loginAsUserToken',
            now()->addMinutes(5),
            ['user' => $user->id]
        );

        logger('Generated Signed URL:', ['link' => $link]); // Log the URL for debugging
        return back()->with('loginLink', $link);
    }

    public function loginAsUserToken(Request $request, $userId)
    {
        logger('Signed URL Debug:', [
            'Full URL' => $request->fullUrl(),
            'Has Valid Signature' => $request->hasValidSignature(),
            'Request Parameters' => $request->all(),
        ]);

        // Check the signature
        if (!$request->hasValidSignature()) {
            abort(403, 'Invalid or expired login link.');
        }

        // Log in the user without persisting the session
        $user = User::findOrFail($userId);
        Auth::guard('web')->setUser($user);

        // Redirect to user's dashboard
        return redirect()->route('dashboard');
    }

    public function block(User $user): \Illuminate\Http\RedirectResponse
    {
//        if user is blocked
        if ($user['active'] == 0){
            return back()->with('error', 'Can\'t block user, user already blocked');
        }
//        block user
        if ($user->update(['active' => 0])){
            return back()->with('success', 'User blocked successfully');
        }
        return back()->with('error', 'Error blocking user');
    }

    public function unblock(User $user): \Illuminate\Http\RedirectResponse
    {
//        if user is active
        if ($user['active'] == 1){
            return back()->with('error', 'Can\'t unblock user, user already active');
        }
//        unblock user
        if ($user->update(['active' => 1])){
            return back()->with('success', 'User unblocked successfully');
        }
        return back()->with('error', 'Error unblocking user');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/admin/users')->with('success', 'User deleted successfully');
    }

    public function fetchUsersWithAjax(Request $request, $type)
    {
//        Define all column names
        $columns = [
            'id', 'name', 'email', 'phone', 'verification', 'status', 'action'
        ];
//        Find data based on page
        switch ($type){
            case 'verified':
                $users = User::query()->latest()->whereNotNull('email_verified_at');
                break;
            case 'unverified':
                $users = User::query()->latest()->whereNull('email_verified_at');
                break;
            default:
                $users = User::query()->latest();
        }
//        Set helper variables from request and DB
        $totalData = $totalFiltered = $users->count();
        $limit = $request['length'];
        $start = $request['start'];
        $order = $columns[$request['order.0.column']];
        $dir = $request['order.0.dir'];
        $search = $request['search.value'];
//        Check if request wants to search or not and fetch data
        if(empty($search))
        {
            $users = $users->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $users = $users->where('email','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%");
            $totalFiltered = $users->count();
            $users = $users->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
        }
//        Loop through all data and mutate
        $data = [];
        $i = $start + 1;
        foreach ($users as $user)
        {
            $action = null;
            if ($user['active'] == 1){
                if (auth()->user()->can('Block Users')){
                    $action = '<a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit(\'userBlock'.$user['id'].'\')" href="'.route('admin.users.block', $user['id']).'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-user-times mr-2"></i><span class="">Block</span></a>
                    <form id="userBlock'.$user['id'].'" action="'.route('admin.users.block', $user['id']).'" method="POST">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="PUT">
                    </form>';
                }
            }else{
                if (auth()->user()->can('Unblock Users')){
                    $action = '<a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit(\'userUnblock'.$user['id'].'\')" href="'.route('admin.users.unblock', $user['id']).'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-user-check mr-2"></i><span class="">Unblock</span></a>
                    <form id="userUnblock'.$user['id'].'" action="'.route('admin.users.unblock', $user['id']).'" method="POST">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="PUT">
                    </form>';
                }
            }
            $datum['sn'] = $i;
            $datum['name'] = '<a href="'.route('admin.users.show', $user['id']).'">'.ucwords($user->first_name) . ' ' . ucwords($user->last_name).'</a>';
            $datum['email'] = $user['email'];
            $datum['phone'] = $user['phone'];
            $datum['joined'] = $user['created_at']->format('F d, Y');
            $datum['verification'] = $user['email_verified_at'] ? '<span class="badge badge-pill badge-success">Verified</span>' : '<span class="badge badge-pill badge-warning">Unverified</span>';
            $datum['status'] = $user['active'] == 1 ? '<span class="badge badge-pill badge-success">Active</span>' : '<span class="badge badge-pill badge-danger">Blocked</span>';
            $datum['action'] = '<div class="dropdown">
                                        <button class="btn btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action <i class="icon-lg fa fa-angle-down"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                            <a class="dropdown-item d-flex align-items-center" href="'.route('admin.users.show', $user['id']).'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-eye mr-2"></i> <span class="">View</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="/admin/users/'.$user['id'].'/show#investments"><i style="font-size: 13px" class="fa fa-layer-group text-secondary icon-sm mr-2"></i> <span class="">Investments</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="/admin/users/'.$user['id'].'/show#wallets"><i style="font-size: 13px" class="fa fa-wallet text-secondary icon-sm mr-2"></i> <span class="">Wallet</span></a>'.
                                            $action.'
                                        </div>
                                    </div>';
            $data[] = $datum;
            $i++;
        }
//      Ready results for datatable
        $res = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        echo json_encode($res);
//        '<a class="dropdown-item d-flex align-items-center" href="/admin/users/'.$user['id'].'/show#trades"><i style="font-size: 13px" class="fa fa-chart-line text-secondary icon-sm mr-2"></i> <span class="">Trades</span></a>'
    }
}
