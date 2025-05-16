<?php

namespace App\Services\API;


use Illuminate\Http\JsonResponse;
use App\Http\Controllers\NotificationController;
use App\Http\Resources\RolloverResource;
use App\Models\Investment;
use App\Models\Package;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RolloverService
{

    public function store(Request $request): JsonResponse
    {
        //Validate request
        $validator = Validator::make($request->all(), [
            'investment_id' => ['required'],
            'package_id' => ['required'],
            'slots' => ['required', 'numeric', 'min:1'],
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()], 422);
        }
        //Check if rollover is allowed
        if (Setting::all()->first()['rollover'] == 0) {
            return response()->json(['message' => 'Investment rollover is currently unavailable, check back later'], 400);
        }
        //Find investment
        $investment = Investment::query()->where('user_id', auth('api')->user()['id'])
            ->where('id', $request['investment_id'])->first();
        if (!$investment) {
            return response()->json(['message' => 'Investment not found'], 400);
        }
        //Check if investment can rollover
        if ($investment["status"] != "active") {
            return response()->json(['message' => 'Investment cannot be rolled over'], 400);
        }
        //Check if investment has rollover
        if ($investment->rollover) {
            return response()->json(['message' => 'Investment already rolled over'], 400);
        }
        //Find package and check if investment is enabled
        $package = Package::all()->where('id', $request['package_id'])->first();
        if (!($package && $package['investment'] == 'enabled')) {
            return response()->json(['message' => 'Can\'t process rollover, package not found or disabled'], 400);
        }
        //Check if returns can buy slots
        if ($investment['total_return'] < ($request['slots'] * $package['price']))
            return response()->json(['message' => 'Investment return not sufficient for rollover slots'], 400);
        //Create rollover
        $rollover = $investment->rollover()->create([
            'package_id' => $package['id'],
            'slots' => $request['slots']
        ]);
        if ($rollover) {
            NotificationController::sendRolloverSuccessfulNotification($rollover);
            return response()->json(['message' => 'Investment rollover successful', 'data' => new RolloverResource($rollover)]);
        }
        return response()->json(['message' => 'Error rolling over investment'], 400);
    }
}
