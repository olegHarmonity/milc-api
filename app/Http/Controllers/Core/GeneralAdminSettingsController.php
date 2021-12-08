<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\GeneralAdminSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Core\GeneralAdminSettingsRequest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Http\Resources\Resource;

class GeneralAdminSettingsController extends Controller
{
    public function store(GeneralAdminSettingsRequest $request)
    {
        Gate::authorize('create', GeneralAdminSettings::class);
        
        $generalAdminSettings = $request->validated();
        
        if(count(GeneralAdminSettings::all()) !== 0){
            throw new BadRequestHttpException("Only one general admin settings entry can exist!");
        }
        
        $generalAdminSettings = GeneralAdminSettings::create($generalAdminSettings);
        
        return new Resource($generalAdminSettings);
    }

    public function show(Request $request, $id)
    {
        $generalAdminSettings = GeneralAdminSettings::findOrFail($id);
        
        Gate::authorize('view', $generalAdminSettings);
        
        return new Resource($generalAdminSettings);
    }

    public function update(GeneralAdminSettingsRequest $request, $id)
    {
        $generalAdminSettings = GeneralAdminSettings::findOrFail($id);
        
        Gate::authorize('update', $generalAdminSettings);
        
        $generalAdminSettingsRequest = $request->validated();
        
        $generalAdminSettings->update($generalAdminSettingsRequest);
        
        return new Resource($generalAdminSettings);
    }
}
