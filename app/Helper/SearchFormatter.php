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

        $exactSearch = $request->get('exact_search');
        
        $startDateSearch = $request->get('start_date');
        $endDateSearch = $request->get('end_date');
        $dateSearch = $request->get('date');

        if ($search) {
            return self::getSearchQuery($request, $model)->get();
        }

        if ($exactSearch) {
            return self::getExactSearchQuery($request, $model)->get();
        }
        
        if ($startDateSearch or $endDateSearch or $dateSearch) {
            return self::getDateSearchQuery($request, $model)->get();
        }

        return $model::all();
    }
    
    public static function getSearchQueries(Request $request, $model)
    {
        $search = $request->get('search');
        
        $exactSearch = $request->get('exact_search');
        
        $startDateSearch = $request->get('start_date');
        $endDateSearch = $request->get('end_date');
        $dateSearch = $request->get('date');
        
        if ($search) {
            return self::getSearchQuery($request, $model);
        }
        
        if ($exactSearch) {
            return self::getExactSearchQuery($request, $model);
        }
        
        if ($startDateSearch or $endDateSearch or $dateSearch) {
            return self::getDateSearchQuery($request, $model);
        }
        
        return $model::query();
    }

    public static function getSearchQuery(Request $request, $model)
    {
        $search = $request->get('search');

        if ($search) {
            $searchTerm = '';
            $attributes = [];
            foreach ($search as $attribute => $term) {
                if (empty($term)) {
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

        $exactSearch = $request->get('exact_search');

        if ($exactSearch) {
            return self::getExactSearchQuery($request, $model);
        }

        return $model::query();
    }

    public static function getExactSearchQuery(Request $request, $model)
    {
        $search = $request->get('exact_search');

        if ($search) {
            $searchTerm = '';
            $attributes = [];
            foreach ($search as $attribute => $term) {
                if (empty($term)) {
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

            return $model::exactSearch($attributes, $searchTerm);
        }

        return $model::query();
    }
    
    public static function getDateSearchQuery(Request $request, $model) {
        
        $startDateSearch = $request->get('start_date');
        $endDateSearch = $request->get('end_date');
        $dateSearch = $request->get('date');
        
        
        $startDate = '';
        $endDate = '';
        $searchAttribute = '';
        
        if($dateSearch){
            
            foreach ($dateSearch as $attribute => $term) {
                if (empty($term)) {
                    continue;
                }
                
                $searchAttribute = $attribute;
                $startDate = $term;
                $endDate = $term;
            }
            
        }
        
        if($startDateSearch){
            
            foreach ($startDateSearch as $attribute => $term) {
                if (empty($term)) {
                    continue;
                }
                
                $searchAttribute = $attribute;
                $startDate = $term;
            }
        }
        
        if($endDateSearch){
            
            foreach ($endDateSearch as $attribute => $term) {
                if (empty($term)) {
                    continue;
                }
                
                $searchAttribute = $attribute;
                $endDate = $term;
            }
        }
        
        
        return $model::dateFilter($searchAttribute, $startDate, $endDate);
    }
}