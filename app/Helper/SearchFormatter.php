<?php
namespace App\Helper;

use Symfony\Component\HttpFoundation\Request;

class SearchFormatter
{
    public static function getSearchResults(Request $request, $model)
    {
        $search = $request->get('search');

        if ($search) {
            $searchTerm = '';
            $attributes = [];
            foreach ($search as $attribute => $term) {
                if($attribute === 'full_name'){
                    $attributes[] = 'first_name';
                    $attributes[] = 'last_name';
                    $searchTerm = $term;
                    continue;
                }
                
                $attributes[] = $attribute;
                $searchTerm = $term;
            }

            return $model::search($attributes, $searchTerm)->get();
        }
        
        return $model::all();
    }
}