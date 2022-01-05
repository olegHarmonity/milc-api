<?php
namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\StoreNotificationRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Helper\SearchFormatter;
use App\Http\Resources\CollectionResource;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Resource;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class NotificationController extends Controller
{

    public function index(Request $request)
    {
        Gate::authorize('viewAny', Notification::class);

        $user = $this->user();

        if (! $user->isAdmin()) {
            $notificationsQuery = Notification::where('organisation_id', $user->organisation->id);
        } else {
            $notificationsQuery = Notification::where('is_for_admin', true);
        }

        $notifications = SearchFormatter::getSearchQueries($request, Notification::class, $notificationsQuery);

        $notifications = $notifications->with('sender:id,organisation_name,logo_id', 'sender.logo:id,image_name,image_url');

        $notifications = $notifications->select([
            'id',
            'title',
            'message',
            'is_read',
            'organisation_id',
            'sender_id',
            'is_for_admin',
            'category',
            'created_at'
        ]);

        $notification = $notifications->paginate($request->input('per_page'));

        return CollectionResource::make($notification);
    }

    public function store(StoreNotificationRequest $request)
    {
        $data = $request->validated();

        if ((! isset($data['organisation_id']) or $data['organisation_id'] == null) && (! isset($data['is_for_admin']) or $data['is_for_admin'] == false)) {
            throw new BadRequestHttpException("Notification must be sent to either administrator or to an organisation!");
        }

        $user = $this->user();

        if ($user->organisation) {
            $data['sender_id'] = $user->organisation_id;
        }

        $notification = Notification::create($data);

        return new Resource($notification);
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);

        Gate::authorize('markAsRead', $notification);

        $notification->is_read = true;
        $notification->save();

        return new Resource($notification);
    }

    public function markAllAsRead(Request $request)
    {
        Gate::authorize('viewAny', Notification::class);

        $user = $this->user();

        $notifications = Notification::where('organisation_id', $user->organisation_id)->get();
        foreach ($notifications as $notification) {
            $notification->is_read = true;
            $notification->save();
        }
        
        $notificationsResponse = Notification::where('organisation_id', $user->organisation_id);
        
        $notificationsResponse = $notificationsResponse->select([
            'id',
            'title',
            'message',
            'is_read',
            'organisation_id',
            'sender_id',
            'is_for_admin',
            'category',
            'created_at'
        ]);
        
        $notificationsResponse = $notificationsResponse->paginate($request->input('per_page'));

        return CollectionResource::make($notificationsResponse);
    }

    public function hasUnreadNotifications(Request $request)
    {
        $user = $this->user();

        if (! $user->isAdmin()) {
            $notifications = Notification::where([
                [
                    'organisation_id',
                    '=',
                    $user->organisation->id
                ],
                [
                    'is_read',
                    '=',
                    false
                ]
            ])->count();
        } else {
            $notifications = Notification::where([
                [
                    'is_for_admin',
                    '=',
                    true
                ],
                [
                    'is_read',
                    '=',
                    false
                ]
            ])->count();
        }

        return response()->json([
            'success' => true,
            'has_notifications' => (int) $notifications > 0,
            'notifications_count' => $notifications
        ], 200);
    }

    public function show(Notification $notification)
    {
        Gate::authorize('view', $notification);

        $notification = $notification->with('sender:id,organisation_name,logo_id', 'sender.logo:id,image_name,image_url');

        $notification = $notification->select([
            'id',
            'title',
            'message',
            'is_read',
            'organisation_id',
            'sender_id',
            'is_for_admin',
            'category'
        ])->first();

        return new Resource($notification);
    }

    public function destroy(Notification $notification)
    {
        Gate::authorize('delete', $notification);

        $notification->delete();

        return response()->json([
            'message' => 'Notification deleted!'
        ]);
    }
}
