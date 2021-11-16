<?php
namespace App\Helper;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class SearchFormatter
{

    public static function getPaginatedSearchResults(Request $request, $model)
    {
        $searchQuery = self::getSearchQuery($request, $model);

        return $searchQuery->paginate($request->input('per_page'));
    }

    public static function getSearchResults(Request $request, $model)
    {
        $search = $request->get('search');

        if ($search) {
            return self::getSearchQuery($request, $model)->get();
        }

        return $model::all();
    }

    public static function getSearchQuery(Request $request, $model)
    {
        $search = $request->get('search');

        if ($search) {
            $searchTerm = '';
            $attributes = [];
            foreach ($search as $attribute => $term) {
                if(empty($term)){
                    continue;
                }
                
                if ($attribute === 'full_name') {
                    $attributes[] = DB::raw("CONCAT(`first_name`, ' ', `last_name`)");
                    $searchTerm = $term;
                    continue;
                }

                $attributes[] = $attribute;
                $searchTerm = $term;
            }

            return $model::search($attributes, $searchTerm);
        }

        return $model::query();
    }
}