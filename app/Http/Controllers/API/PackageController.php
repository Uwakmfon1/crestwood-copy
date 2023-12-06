<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * @OA\Get(
     ** path="/api/packages",
     *   tags={"Package"},
     *   summary="Get Packages",
     *   operationId="get packages",
     *
     *     @OA\Parameter(
     *      name="type",
     *      description="should be enabled or disabled",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=422,
     *       description="Unprocessed Entity",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
    public function index(): \Illuminate\Http\JsonResponse
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

    /**
     * @OA\Get(
     ** path="/api/packages/{id}/show",
     *   tags={"Package"},
     *   summary="Show Package",
     *   operationId="show package",
     *
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
    public function show(Package $package): \Illuminate\Http\JsonResponse
    {
        return response()->json(['data' => new PackageResource($package)]);
    }
}
