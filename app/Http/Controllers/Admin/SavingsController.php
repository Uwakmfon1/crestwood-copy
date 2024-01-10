<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Saving;
use App\Models\SavingPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SavingsController extends Controller
{
    public function index()
    {
        return view('admin.package.savings', ['packages' => SavingPackage::all()]);
    }

    public function show(Saving $saving)
    {
        return view('admin.savings.show', ['investment' => $saving, 'packages' => SavingPackage::all()]);
    }

    public function create()
    {
        return view('admin.savingsPackage.create');
    }

    public function savings(SavingPackage $savings)
    {
        return view('admin.savings.index', ['investments' => $savings->savings()->get(), 'type' => 'packages', 'id' => $savings['id']]);
    }

    public function edit(SavingPackage $package)
    {
        return view('admin.savingsPackage.edit', ['package' => $package]);
    }
    
    // Savings Package CRUD

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:packages,name'],
            'roi' => ['required', 'numeric'],
            'price' => ['required', 'numeric', 'gt:0'],
            'duration' => ['required'],
            'milestone' => ['required', 'numeric', 'gt:0'],
            'description' => ['required'],
            'image' => ['required', 'mimes:jpeg,jpg,png', 'max:1024']
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
        $data = $request->all();
        
        $data['image'] = $this->uploadPackageImageAndReturnPathToSave($request['image']);
        
        if (SavingPackage::create($data)){
            return redirect()->route('admin.saving.package')->with('success', 'Package created successfully');
        }
        return back()->with('error', 'Error creating package');
    }

    public function update(Request $request, SavingPackage $package): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:packages,name,'.$package['id']],
            'roi' => ['required', 'numeric'],
            'price' => ['required', 'numeric', 'gt:0'],
            'duration' => ['required'],
            'milestone' => ['required', 'numeric', 'gt:0'],
            'description' => ['required'],
            'image' => ['sometimes', 'mimes:jpeg,jpg,png'],
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
        $data = $request->except('image');
        
        if ($request->file('image')){
            $data['image'] = $this->uploadPackageImageAndReturnPathToSave($request['image']);
        }

        if ($package->update($data)){
            return redirect()->route('admin.saving.package')->with('success', 'Package updated successfully');
        }
        return back()->with('error', 'Error updating package');
    }

    public function destroy(SavingPackage $package)
    {
        if ($package->savings()->count() > 0){
            return back()->with('error', 'Can\'t delete package, Savings already associated');
        }
        unlink($package['image']);
        if ($package->delete()){
            return redirect()->route('admin.saving.package')->with('success', 'Package deleted successfully');
        }
        return back()->with('error', 'Error deleting package');
    }

    protected function uploadPackageImageAndReturnPathToSave($image): string
    {
        $destinationPath = 'assets/savings'; // upload path
        $transferImage = \auth()->user()['id'].'-'. time() . '.' . $image->getClientOriginalExtension();
        $image->move($destinationPath, $transferImage);
        return $destinationPath ."/".$transferImage;
    }

    public function fetchSavingsWithAjax(Request $request, $type)
    {
        //        Define all column names
        $columns = [
            'id', 'name', 'package', 'slots', 'total_invested', 'expected_returns', 'return_date', 'status', 'action'
        ];
        //        Find data based on page
        switch ($type){
            case 'active':
                $investments = Saving::query()->latest()->where('status', 'active');
                break;
            case 'pending':
                $investments = Saving::query()->latest()->where('status', 'pending');
                break;
            case 'cancelled':
                $investments = Saving::query()->latest()->where('status', 'cancelled');
                break;
            case 'settled':
                $investments = Saving::query()->latest()->where('status', 'settled');
                break;
            case 'packages':
                $investments = Saving::query()->latest()->whereHas('package',function ($q) use ($request) { $q->where('id', $request['package']); });
                break;
            default:
                $investments = Saving::query()->latest();

        }
        //        Set helper variables from request and DB
        $totalData = $totalFiltered = $investments->count();
        $limit = $request['length'];
        $start = $request['start'];
        $order = $columns[$request['order.0.column']];
        $dir = $request['order.0.dir'];
        $search = $request['search.value'];
        //        Check if request wants to search or not and fetch data
        if(empty($search))
        {
            $investments = $investments->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $investments = $investments->whereHas('user',function ($q) use ($search) { $q->where('name', 'LIKE',"%{$search}%"); })
                ->orWhereHas('package',function ($q) use ($search) { $q->where('name', 'LIKE',"%{$search}%"); })
                ->orWhere('slots', 'LIKE',"%{$search}%")
                ->orWhere('status', 'LIKE',"%{$search}%")
                ->orWhere('total_return', 'LIKE',"%{$search}%")
                ->orWhere('amount', 'LIKE',"%{$search}%");
            $totalFiltered = $investments->count();
            $investments = $investments->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        //        Loop through all data and mutate data
        $data = [];
        $i = $start + 1;
        foreach ($investments as $investment)
        {
            $status = $action = null;
            if($investment['status'] == 'active'){
                $status = '<span class="badge badge-pill badge-success">Active</span>';
            }elseif ($investment['status'] == 'pending'){
                $status = '<span class="badge badge-pill badge-warning">Pending</span>';
                $action .= '<a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit(\'transactionApprove'.$investment['id'].'\')" href="'.route('admin.transactions.approve', $investment['transaction']['id']).'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-check mr-2"></i> <span class="">Approve</span></a>
                           <form id="transactionApprove'.$investment['id'].'" action="'.route('admin.transactions.approve', $investment['transaction']['id']).'" method="POST">
                               <input type="hidden" name="_token" value="'.csrf_token().'">
                               <input type="hidden" name="_method" value="PUT">
                           </form>';
                $action .= '<a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit(\'transactionDecline'.$investment['id'].'\')" href="'.route('admin.transactions.decline', $investment['transaction']['id']).'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-times mr-2"></i> <span class="">Decline</span></a>
                           <form id="transactionDecline'.$investment['id'].'" action="'.route('admin.transactions.decline', $investment['transaction']['id']).'" method="POST">
                               <input type="hidden" name="_token" value="'.csrf_token().'">
                               <input type="hidden" name="_method" value="PUT">
                           </form>';
                if (!auth()->user()->can('Approve Transactions') && !auth()->user()->can('Decline Transactions')){
                    $action = null;
                }
            }elseif ($investment['status'] == 'cancelled'){
                $status = '<span class="badge badge-pill badge-danger">Cancelled</span>';
            }elseif ($investment['status'] == 'settled'){
                $status = '<span class="badge badge-pill badge-secondary">Settled</span>';
            }
            $datum['sn'] = $i;
            if (auth()->user()->can('View Users')){
                $datum['name'] = '<a href="'.route('admin.users.show', $investment->user['id']).'">'.ucwords($investment->user['name']).'</a>';
            }else{
                $datum['name'] = ucwords($investment->user['name']);
            }
            $datum['package'] = $investment->package['name'];
            // $datum['slots'] = $investment['slots'];
            $datum['total_invested'] = '₦ '.number_format($investment['amount']);
            $datum['expected_returns'] = '₦ '.number_format($investment['total_return']);
            $datum['return_date'] = $investment->return_date->format('M d, Y');
            $datum['status'] = $status;
            $datum['action'] = '<div class="dropdown">
                                        <button class="btn btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action <i class="icon-lg fa fa-angle-down"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                            <a class="dropdown-item d-flex align-items-center" href="'.route('admin.savings.show', $investment['id']).'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-eye mr-2"></i> <span class="">View</span></a>'.
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
    }
}
