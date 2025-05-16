<?php 
namespace App\Services\API;


use App\Http\Resources\NotificationResource;
use Illuminate\Support\Facades\DB;
use Soundasleep\Html2Text;


class NotificationService  
{


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

   
    public function read(): \Illuminate\Http\JsonResponse
    {
        foreach (auth('api')->user()->unreadNotifications()->get() as $notification) {
            $notification->markAsRead();
        }
        return response()->json(['message' => 'Notifications marked as read']);
    }

}