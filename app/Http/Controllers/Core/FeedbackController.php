<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\SearchFormatter;
use App\Http\Resources\CollectionResource;
use App\Http\Requests\Core\CreateFeedbackRequest;
use App\Http\Requests\Core\UpdateFeedbackRequest;
use App\Models\Feedback;
use Throwable;
use Illuminate\Support\Facades\Gate;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Feedback::class);
        $feedback = SearchFormatter::getSearchQueries($request, Feedback::class);
        $feedback = $feedback->with('user:id,first_name,last_name');
        $feedback = $feedback->paginate($request->input('per_page'));

        return CollectionResource::make($feedback);
    }

    public function store(CreateFeedbackRequest $request)
    {
        $data = $request->validated();
        if(auth()->id() != null)
            $data['user_id'] = auth()->id();
            
        $feedback = Feedback::create($data);

        return new CollectionResource($feedback);
    }

    public function update(UpdateFeedbackRequest $request, Feedback $feedback)
    {
   
        Gate::authorize('update', $feedback);

        $feedback->update($request->validated());

        return new CollectionResource($feedback);
    }

    public function show(Feedback $feedback)
    {
        Gate::authorize('view', $feedback);
        return new CollectionResource($feedback);
    }

    public function destroy(Feedback $feedback)
    {
        Gate::authorize('delete', $feedback);

        $feedback->delete();

        return response()->json([
            'message' => 'Feedback deleted!'
        ]);
    }
}
