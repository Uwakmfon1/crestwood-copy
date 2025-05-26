<?php 
namespace App\Services\Admin;

use App\Models\User;
use App\Models\Setting;
use App\Models\Package;
use App\Models\Investment;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Validator;


class RolloverService
{
 
    public function __construct(public NotificationService $notificationService){}

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        //        Validate request
        $validator = Validator::make($request->all(), [
            'investment' => ['required'],
            'package' => ['required'],
            'slots' => ['required', 'numeric', 'min:1'],
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
        //        Find investment
        $investment = Investment::find($request['investment']);
        if (!$investment){
            return back()->with('error', 'Investment not found');
        }
        //        Check if investment has rollover
        if ($investment->rollover){
            return back()->with('error', 'Investment already rolled over');
        }
        //        Check if investment can rollover
        if ($investment["status"] != "active"){
            return back()->with('error', 'Investment cannot be rolled over');
        }
        //        Find package and check if investment is enabled
        $package = Package::all()->where('name', $request['package'])->first();
        if (!$package){
            return back()->with('error', 'Can\'t process rollover, package not found');
        }
        //        Check if returns can buy slots
        if ($investment['total_return'] < ($request['slots'] * $package['price']))
            return back()->with('error', 'Investment return not sufficient for rollover slots');
        //        Create rollover
        $rollover = $investment->rollover()->create([
            'package_id' => $package['id'], 'slots' => $request['slots']
        ]);
        if ($rollover){
            $this->notificationService->sendRolloverSuccessfulNotification($rollover);
            return back()->with('success', 'Investment rollover successful');
        }
        return back()->with('error', 'Error rolling over investment');
    }

}