<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use App\Services\API\PackageService;
use Illuminate\Http\Request;

class PackageController extends Controller
{

    public function __construct(public PackageService $packageService){  }

    public function index()
    {
        return $this->packageService->index();
    }

    // public function index(): \Illuminate\Http\JsonResponse
    // {
    //     $packages = Package::where('investment', 'enabled');
    //     if (request()->get('type')){
    //         switch (request()->get('type')){
    //             case "enabled":
    //                 $packages->where('investment', 'enabled');
    //                 break;
    //             case "disabled":
    //                 $packages->where('investment', 'disabled');
    //                 break;
    //             default:
    //                 return response()->json(['message' => 'The type can only be enabled or disabled.'], 422);
    //         }
    //     }
    //     return response()->json(['data' => PackageResource::collection($packages->get())]);
    // }

    public function show(Package $package)
    {
        return $this->packageService->show($package);
    }
    // public function show(Package $package): \Illuminate\Http\JsonResponse
    // {
    //     return response()->json(['data' => new PackageResource($package)]);
    // }
}

