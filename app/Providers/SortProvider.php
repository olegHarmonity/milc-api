<?php
namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class SortProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        Builder::macro('sort', function ($attribute, string $sortDirection, Builder $query = null) {

            if (! $query) {
                $query = $this;
            }

            $query->orderBy($attribute, $sortDirection);
            
            return $query;
        });
    }
}

