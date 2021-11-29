<?php
namespace App\Http\Controllers\User;

use App\Helper\SearchFormatter;
use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;
use App\Models\User;

class UserActivityController extends Controller
{
    
    public function index(Request $request)
    {
        Gate::authorize('viewAny', UserActivity::class);
        $userActivities = SearchFormatter::getSearchQueries($request, UserActivity::class);

        $userActivities = $this->getUserActivityResponseData($userActivities);

        $userActivities = $userActivities->paginate($request->input('per_page'));
        
        return CollectionResource::make($userActivities);
    }
    
    public function getUserActivitiesByUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        
        Gate::authorize('viewByUser', $user);
        $userActivities = SearchFormatter::getSearchQueries($request, UserActivity::class, UserActivity::where('user_id', $userId));
        
        $userActivities = $this->getUserActivityResponseData($userActivities);
        
        $userActivities = $userActivities->paginate($request->input('per_page'));
        
        return CollectionResource::make($userActivities);
    }

    public function show(UserActivity $userActivity)
    {
        Gate::authorize('view', $userActivity);

        return new Resource($userActivity);
    }

    private function getUserActivityResponseData($userActivity)
    {
        $userActivity = $userActivity->select([
            'id',
            'activity',
            'user_activities.created_at',
            'user_id'
        ]);

        return $userActivity;
    }
}
