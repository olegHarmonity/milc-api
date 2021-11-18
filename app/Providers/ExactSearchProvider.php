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
                foreach (array_wrap($attributes) as $attribute) {
                    $query->when(str_contains($attribute, '.'), function (Builder $query) use ($attribute, $searchTerms) {
                        [
                        $relationName,
                        $relationAttribute
                        ] = explode('.', $attribute);
                        
                        $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerms) {
                            $query->whereIn($relationAttribute, $searchTerms);
                        });
                    }, function (Builder $query) use ($attribute, $searchTerms) {
                        $query->whereIn($attribute, $searchTerms);
                    });
                }
            });
                
                return $this;
        });
    }
}
