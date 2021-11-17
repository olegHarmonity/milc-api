<?php
namespace App\Http\Requests\Product;

use App\Util\ProductionStatuses;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'title' => [
                'sometimes',
                'required'
            ],
            'alternative_title' => 'sometimes',
            'content_type_id' => 'sometimes',
            'runtime' => [
                'sometimes',
                'required',
            ],
            'synopsis' => 'sometimes',
            'genres' => 'sometimes',
            'available_formats' => 'sometimes',
            'keywords' => 'sometimes',
            'original_language' => 'sometimes',
            'dubbing_languages' => 'sometimes',
            'subtitle_languages' => 'sometimes',
            'links' => 'sometimes',
            'allow_requests' => [
                'sometimes',
                'required',
            ],
            'movie_id' => 'sometimes',
            'screener_id' => 'sometimes',
            'trailer_id' => 'sometimes',
            'dub_files' => 'sometimes',
            'subtitles' => 'sometimes',
            'promotional_videos' => 'sometimes',
            'production_info_id' => 'sometimes',
            'marketing_assets_id' => 'sometimes',
            'rights_information_id' => 'sometimes',
            'production_info.release_year' => [
                'sometimes',
                'required',
            ],
            'production_info.production_year' => [
                'sometimes',
                'required',
            ],
            'production_info.production_status' => [
                'sometimes',
                'required',
                'in:' . ProductionStatuses::getProductionStatuses()
            ],
            'production_info.country_of_origin' => 'sometimes',
            'production_info.directors' => 'sometimes',
            'production_info.directors.*.first_name'=> [
                'sometimes',
                'required',
            ],
            'production_info.directors.*.last_name'=> [
                'sometimes',
                'required',
            ],
            'production_info.producers' => 'sometimes',
            'production_info.producers.*.first_name'=> [
                'sometimes',
                'required',
            ],
            'production_info.producers.*.last_name'=> [
                'sometimes',
                'required',
            ],
            'production_info.writers' => 'sometimes',
            'production_info.writers.*.first_name'=> [
                'sometimes',
                'required',
            ],
            'production_info.writers.*.last_name'=> [
                'sometimes',
                'required',
            ],
            'production_info.cast' => 'sometimes',
            'production_info.cast.*.first_name'=> [
                'sometimes',
                'required',
            ],
            'production_info.cast.*.last_name'=> [
                'sometimes',
                'required',
            ],
            'production_info.awards' => 'sometimes',
            'production_info.festivals' => 'sometimes',
            'production_info.box_office' => 'sometimes',
            
            'marketing_assets.key_artwork_id' => 'sometimes',
            'marketing_assets.production_images' => 'sometimes',
            'marketing_assets.copyright_information' => 'sometimes',
            'marketing_assets.links' => 'sometimes',
            'rights_information' => 'sometimes',
            'rights_information.*.available_from_date'=> [
                'sometimes',
                'required',
            ],
            'rights_information.*.expiry_date'=> [
                'sometimes',
                'required',
            ],
            'rights_information.*.available_rights' => 'sometimes',
            'rights_information.*.holdbacks' => 'sometimes',
            'rights_information.*.territories' => 'sometimes',
        ];
    }
}


