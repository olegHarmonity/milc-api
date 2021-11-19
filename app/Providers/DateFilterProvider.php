<?php
namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class DateFilterProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        Builder::macro('dateFilter', function ($attribute, $fromDate, $toDate, Builder $query = null) {
            
            if(!$query){
                $query = $this;
            }
            
            $query->where(function (Builder $query) use ($attribute, $fromDate, $toDate) {
                $query->when(str_contains($attribute, '.'), function (Builder $query) use ($attribute, $fromDate, $toDate) {
                    [
                        $relationName,
                        $relationAttribute
                    ] = explode('.', $attribute);

                    $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $fromDate, $toDate) {
                        if (! empty($fromDate))
                            $query->whereDate($relationAttribute, '>=', $fromDate);
                        if (! empty($toDate))
                            $query->whereDate($relationAttribute, '<=', $toDate);
                    });
                }, function (Builder $query) use ($attribute, $fromDate, $toDate) {
                    if (! empty($fromDate))
                        $query->whereDate($attribute, '>=', $fromDate);
                    if (! empty($toDate))
                        $query->whereDate($attribute, '<=', $toDate);
                });
            });
            
                return $query;
        });
    }
}
