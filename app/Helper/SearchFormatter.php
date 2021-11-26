<?php
namespace App\Helper;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class SearchFormatter
{

    public static function getPaginatedSearchResults(Request $request, $model, Builder $query = null)
    {
        $searchQuery = self::getSearchQueries($request, $model, $query);

        return $searchQuery->paginate($request->input('per_page'));
    }

    public static function getSearchResults(Request $request, $model, Builder $query = null)
    {
        return self::getSearchQueries($request, $model, $query)->get();
    }

    public static function getSearchQueries(Request $request, $model, Builder $query = null)
    {
        $search = $request->get('search');

        $exactSearch = $request->get('exact_search');

        $startDateSearch = $request->get('start_date');
        $endDateSearch = $request->get('end_date');
        $dateSearch = $request->get('date');
        
        $sort = $request->get('sort') ?? ['created_at' => 'DESC'];
        foreach($sort as $parameter => $direction){
            $query = $model::orderBy($parameter, $direction);
        }

        if ($search) {
            $query = self::getSearchQuery($request, $model, $query);
        }

        if ($exactSearch) {
            $query = self::getExactSearchQuery($request, $model, $query);
        }

        if ($startDateSearch or $endDateSearch or $dateSearch) {

            $query = self::getDateSearchQuery($request, $model, $query);
        }

        if ($query) {
            return $query;
        }

        return $model::query();
    }

    public static function requestHasSearchParameters(Request $request)
    {
        $search = $request->get('search');

        $exactSearch = $request->get('exact_search');

        $startDateSearch = $request->get('start_date');
        $endDateSearch = $request->get('end_date');
        $dateSearch = $request->get('date');

        if ($search or $exactSearch or $startDateSearch or $endDateSearch or $dateSearch) {
            return true;
        }
        return false;
    }

    private static function getSearchQuery(Request $request, $model, Builder $existinQuery = null)
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

            return $model::search($attributes, $searchTerm, $existinQuery);
        }

        return $model::query();
    }

    public static function getExactSearchQuery(Request $request, $model, Builder $existinQuery = null)
    {
        $search = $request->get('exact_search');

        if ($search) {
            $searchTerms = [];
            $attributes = [];
            foreach ($search as $attribute => $term) {
                if (empty($term)) {
                    continue;
                }

                if ($attribute === 'full_name') {
                    $attributes[] = DB::raw("CONCAT(`first_name`, ' ', `last_name`)");

                    if (is_array($term)) {
                        $searchTerms[] = $term;
                    } else {
                        $searchTerms[] = [
                            $term
                        ];
                    }
                    continue;
                }

                $attributes[] = $attribute;

                if (is_array($term)) {
                    $searchTerms[] = $term;
                } else {
                    $searchTerms[] = [
                        $term
                    ];
                }
            }

            return $model::exactSearch($attributes, $searchTerms, $existinQuery);
        }

        return $model::query();
    }

    public static function getDateSearchQuery(Request $request, $model, Builder $existinQuery = null)
    {
        $startDateSearch = $request->get('start_date');
        $endDateSearch = $request->get('end_date');
        $dateSearch = $request->get('date');

        $startDate = '';
        $endDate = '';
        $searchAttribute = '';

        if ($dateSearch) {

            foreach ($dateSearch as $attribute => $term) {
                if (empty($term)) {
                    continue;
                }

                $searchAttribute = $attribute;
                $startDate = $term;
                $endDate = $term;
            }
        }

        if ($startDateSearch) {

            foreach ($startDateSearch as $attribute => $term) {
                if (empty($term)) {
                    continue;
                }

                $searchAttribute = $attribute;
                $startDate = $term;
            }
        }

        if ($endDateSearch) {

            foreach ($endDateSearch as $attribute => $term) {
                if (empty($term)) {
                    continue;
                }

                $searchAttribute = $attribute;
                $endDate = $term;
            }
        }

        return $model::dateFilter($searchAttribute, $startDate, $endDate, $existinQuery);
    }
}