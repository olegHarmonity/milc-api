<?php
namespace App\Http\Controllers;

use App\Http\Requests\Product\UpdatePersonRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Product\PersonResource;
use App\Models\Person;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Helper\FileUploader;
use App\Helper\SearchFormatter;

class PersonController extends Controller
{

    public function index(Request $request)
    {
        $persons = SearchFormatter::getSearchQuery($request, Person::class);
        
        $persons = $this->getPersonResponseData($persons);
        
        $persons = $persons->paginate($request->input('per_page'));
        
        return new CollectionResource($persons);
    }

    public function show(Person $person)
    {
        return new PersonResource($person);
    }

    public function update(UpdatePersonRequest $request, Person $person)
    {
        Gate::authorize('update', $person);

        $personRequest = $request->all();

        if ($request->file('image')) {
            $image = FileUploader::uploadFile($request, 'image', 'image');
            $personRequest['image_id'] = $image->id;
        }

        $person->update($personRequest);

        return new PersonResource($person);
    }

    public function store(UpdatePersonRequest $request)
    {
        Gate::authorize('create', Person::class);

        $personRequest = $request->all();

        if ($request->file('image')) {
            $image = FileUploader::uploadFile($request, 'image', 'image');
            $personRequest['image_id'] = $image->id;
        }

        $person = Person::create($personRequest);
        
        return new PersonResource($person);
    }
    
    private function getPersonResponseData($person){
        
        $person = $person->with('image:id,image_name,image_url,mime,created_at,updated_at');
        
        $person = $person->select([
            'id',
            'first_name',
            'last_name',
            'image_id'
        ]);
        
        return $person;
    }
}