<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\UpdatePersonRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;
use App\Models\Person;
use Symfony\Component\HttpFoundation\Response;

class PersonController extends Controller
{
    public function index()
    {
        return new CollectionResource(Person::all());
    }

    public function show(int $id)
    {
        return new Resource(Person::find($id));
    }

    public function update(UpdatePersonRequest $request, int $id)
    {
        $person = Person::find($id);

        $person->update($request->all());

        return (new Resource($person))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function store(UpdatePersonRequest $request)
    {
        $person = Person::create($request->all());

        return (new Resource($person))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
