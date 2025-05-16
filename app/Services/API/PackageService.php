<?php 
namespace App\Services\API;

use App\Models\Package;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;
use Illuminate\Http\Request;

class PackageService
{

     public function index(): JsonResponse
    {
        $packages = Package::where('investment', 'enabled');
        if (request()->get('type')){
            switch (request()->get('type')){
                case "enabled":
                    $packages->where('investment', 'enabled');
                    break;
                case "disabled":
                    $packages->where('investment', 'disabled');
                    break;
                default:
                    return response()->json(['message' => 'The type can only be enabled or disabled.'], 422);
            }
        }
        return response()->json(['data' => PackageResource::collection($packages->get())]);
    }

    public function show(Package $package): JsonResponse
    {
        return response()->json(['data' => new PackageResource($package)]);
    }

}