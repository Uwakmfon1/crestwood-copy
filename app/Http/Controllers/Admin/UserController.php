<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
        $user->transactions()->delete();
        $user->trades()->delete();
        $user->investments()->delete();
        $user->nairaWallet()->delete();
        $user->goldWallet()->delete();
        $user->silverWallet()->delete();
        $user->payments()->delete();
        $user->referrals()->delete();
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
