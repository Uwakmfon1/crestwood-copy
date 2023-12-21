<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\TradeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Soundasleep\Html2Text;

class NotificationController extends Controller
{
    /**
     * @OA\Get(
     ** path="/api/notifications",
     *   tags={"Notification"},
     *   summary="Get Notifications",
     *   operationId="get notifications",
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
    public function index(): \Illuminate\Http\JsonResponse
    {
        $notifications = auth('api')->user()->notifications();
        if (request()->get('paginate') == 'true'){
            $data = $notifications->paginate(request()->get('limit') ?? 10);
            return response()->json(['data' => NotificationResource::collection($data), 'pagination_links' => \App\Http\Controllers\API\HomeController::fetchPaginationLinks($data)]);
        }else{
            return response()->json(['data' => NotificationResource::collection($notifications->get())]);
        }
    }

    /**
     * @OA\Get(
     ** path="/api/notifications/{id}/show",
     *   tags={"Notification"},
     *   summary="Show Notifications",
     *   operationId="show notifications",
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
    public function show($notification): \Illuminate\Http\JsonResponse
    {
        DB::table('notifications')->where('id', $notification)->update(['read_at' => now()]);
        $notification = DB::table('notifications')->where('id', $notification)->first();
        return response()->json(['data' => [
            'id' => $notification->id,
            'title' => json_decode($notification->data, true)['title'],
            'body' => Html2Text::convert(json_decode($notification->data, true)['body']),
            'read' => !is_null($notification->read_at),
            "read_at" => $notification->read_at ? date('M d, Y \a\t h:i A', strtotime($notification->read_at)) : null,
            "created_at" => date('M d, Y \a\t h:i A', strtotime($notification->created_at)),
        ]]);
    }

    /**
     * @OA\Get(
     ** path="/api/notifications/read",
     *   tags={"Notification"},
     *   summary="Read All Notifications",
     *   operationId="read all notifications",
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
    public function read(): \Illuminate\Http\JsonResponse
    {
        foreach (auth('api')->user()->unreadNotifications()->get() as $notification) {
            $notification->markAsRead();
        }
        return response()->json(['message' => 'Notifications marked as read']);
    }
}
