<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class ExactSearchProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Builder::macro('exactSearch', function ($attributes, array $searchTerms) {
            
            $this->where(function (Builder $query) use ($attributes, $searchTerms) {
                foreach (array_wrap($attributes) as $key => $attribute) {
                    $query->when(str_contains($attribute, '.'), function (Builder $query) use ($attribute, $searchTerms, $key) {
                        [
                        $relationName,
                        $relationAttribute
                        ] = explode('.', $attribute);
                        
                        $query->whereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerms, $key) {
                            $query->whereIn($relationAttribute, $searchTerms[$key]);
                        });
                    }, function (Builder $query) use ($attribute, $searchTerms, $key) {
                        $query->whereIn($attribute, $searchTerms[$key]);
                    });
                }
            });
                
                return $this;
        });
    }
}
