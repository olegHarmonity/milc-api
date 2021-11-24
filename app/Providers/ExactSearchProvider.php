<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class ExactSearchProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Builder::macro('exactSearch', function ($attributes, array $searchTerms, Builder $query = null) {
            
            if(!$query){
                $query = $this;
            }
            
            $query->where(function (Builder $query) use ($attributes, $searchTerms) {
                
                foreach (array_wrap($attributes) as $key => $attribute) {
                    
                    $searchTermsInput = [];
                    if(is_array($searchTerms[$key])){
                        foreach($searchTerms[$key] as $searchItem){
                            $searchTermsInput[] = strtoupper($searchItem);
                        }
                    }else{
                        $searchTermsInput[] = strtoupper($searchTerms[$key]);
                    }
                    
                    $query->when(str_contains($attribute, '.'), function (Builder $query) use ($attribute, $searchTermsInput, $key) {
                        [
                        $relationName,
                        $relationAttribute
                        ] = explode('.', $attribute);
                        
                        $query->whereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTermsInput, $key) {
                            $query->whereIn(DB::raw('upper('.$relationAttribute.')'), $searchTermsInput);
                        });
                    }, function (Builder $query) use ($attribute, $searchTermsInput, $key) {
                        $query->whereIn(DB::raw('upper('.$attribute.')'), $searchTermsInput);
                    });
                }
            });
                
            return $query;
        });
    }
}
