<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Saving;
use Illuminate\Http\Request;
use App\Models\SavingPackage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SavingsController extends Controller
{
    public function index()
    {
        return view('admin.package.savings', ['packages' => SavingPackage::all()]);
    }

    public function all()
    {
        return view('admin.savings.index', ['type' => \request('type') ?? 'all']);
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

    public function showUserSavings(User $user, Saving $saving)
    {
        $paid = $saving->transaction()->where('status', 'approved')->count();

        return view('admin.user.saving.show', ['user' => $user, 'savings' => $saving, 'packages' => SavingPackage::all(), 'paid' => $paid]);
    }
    
    // Savings Package CRUD

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:packages,name'],
            'roi' => ['required', 'numeric'],
            'price' => ['required', 'numeric', 'gt:0'],
            // 'duration' => ['required'],
            // 'milestone' => ['required', 'numeric', 'gt:0'],
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
        // Define all column names
        $columns = [
            'id', 'name', 'timeframe', 'deposit', 'contribution', 'total_return', 'return_date', 'status', 'action'
        ];

        // Determine the data to retrieve based on the requested type
        switch ($type) {
            case 'active':
                $savings = Saving::query()->latest()->where('status', 'active');
                break;
            case 'pending':
                $savings = Saving::query()->latest()->where('status', 'pending');
                break;
            case 'cancelled':
                $savings = Saving::query()->latest()->where('status', 'cancelled');
                break;
            case 'settled':
                $savings = Saving::query()->latest()->where('status', 'settled');
                break;
            default:
                $savings = Saving::query()->latest();
        }

        // Set helper variables from request and DB
        $totalData = $totalFiltered = $savings->count();
        $limit = $request['length'];
        $start = $request['start'];
        $order = $columns[$request['order.0.column']];
        $dir = $request['order.0.dir'];
        $search = $request['search.value'];

        // Check if a search is being conducted
        if (empty($search)) {
            $savings = $savings->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $savings = $savings->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhere('total_return', 'LIKE', "%{$search}%")
                ->orWhere('deposit', 'LIKE', "%{$search}%");
            $totalFiltered = $savings->count();
            $savings = $savings->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }

        // Prepare data for the DataTable
        $data = [];
        $i = $start + 1;
        foreach ($savings as $saving) {
            $statusBadge = $actionButtons = null;
            switch ($saving['status']) {
                case 'active':
                    $statusBadge = '<span class="badge badge-pill badge-success">Active</span>';
                    break;
                case 'pending':
                    $statusBadge = '<span class="badge badge-pill badge-warning">Pending</span>';
                    $actionButtons = $this->generateActionButtons($saving);
                    break;
                case 'cancelled':
                    $statusBadge = '<span class="badge badge-pill badge-danger">Cancelled</span>';
                    break;
                case 'settled':
                    $statusBadge = '<span class="badge badge-pill badge-secondary">Settled</span>';
                    break;
            }



            $data[] = [
                'sn' => $i,
                'name' => auth()->user()->can('View Users') && $saving->user 
                    ? '<a href="' . route('admin.users.show', $saving->user['id']) . '">' . ucwords($saving->user['name']) . '</a>' 
                    : ($saving->user ? ucwords($saving->user['name']) : 'Deleted Account'),
                'timeframe' => ucfirst($saving['timeframe']),
                'deposit' => '$ ' . number_format($saving['deposit'], 2),
                'contribution' => '$ ' . number_format($saving['contribution'], 2),
                'total_return' => '$ ' . number_format($saving['total_return'], 2),
                'return_date' => $saving->return_date->format('M d, Y'),
                'status' => $statusBadge,
                'action' => '<div class="dropdown">
                                <button class="btn btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action <i class="icon-lg fa fa-angle-down"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">'.
                                    '<a class="dropdown-item d-flex align-items-center" href="'.route('admin.savings.show', $saving['id']).'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-eye mr-2"></i> <span class="">View</span></a>'.
                                    $actionButtons.
                                '</div>
                            </div>',
            ];
            $i++;
        }

        // Return the prepared data as JSON for DataTables
        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ]);
    }

    /**
     * Helper method to generate action buttons for pending savings
     */
    private function generateActionButtons($saving)
    {
        $action = '';
        if (auth()->user()->can('Approve Transactions')) {
            $action .= '<a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit(\'transactionApprove'.$saving['id'].'\')" href="'.route('admin.transactions.approve', $saving['transaction']['id']).'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-check mr-2"></i> <span class="">Approve</span></a>
                        <form id="transactionApprove'.$saving['id'].'" action="'.route('admin.transactions.approve', $saving['transaction']['id']).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="PUT">
                        </form>';
        }
        if (auth()->user()->can('Decline Transactions')) {
            $action .= '<a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit(\'transactionDecline'.$saving['id'].'\')" href="'.route('admin.transactions.decline', $saving['transaction']['id']).'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-times mr-2"></i> <span class="">Decline</span></a>
                        <form id="transactionDecline'.$saving['id'].'" action="'.route('admin.transactions.decline', $saving['transaction']['id']).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="PUT">
                        </form>';
        }
        return $action;
    }

}
