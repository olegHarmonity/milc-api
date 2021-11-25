<?php
namespace App\Http\Controllers\User;

use App\Helper\SearchFormatter;
use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;

class UserActivityController extends Controller
{

    public function index(Request $request)
    {
        Gate::authorize('viewAny', UserActivity::class);
        $movieGenres = SearchFormatter::getSearchQueries($request, UserActivity::class);

        $movieGenres = $this->getUserActivityResponseData($movieGenres)->get();

        return new CollectionResource($movieGenres);
    }

    public function show(UserActivity $userActivity)
    {
        Gate::authorize('view', $userActivity);

        return new Resource($userActivity);
    }

    private function getUserActivityResponseData($userActivity)
    {
        $userActivity = $userActivity->with('user:id,first_name,last_name');

        $userActivity = $userActivity->select([
            'id',
            'activity',
            'user_activities.created_at',
            'user_id'
        ]);

        return $userActivity;
    }
}
