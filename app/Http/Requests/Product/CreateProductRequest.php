<?php

namespace App\Http\Requests\Product;

use App\Util\ProductionStatuses;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => [
                'required'
            ],
            'alternative_title',
            'content_type',
            'runtime' => [
                'required',
            ],
            'synopsis',
            'genre_id' => [
                'required'
            ],
            'available_formats',
            'keywords',
            'languages',
            'links',
            'allow_requests' => [
                'required',
            ],
            'movie',
            'screener',
            'trailer',
            'dub_files',
            'subtitles',
            'promotional_videos',
            'production_info_id',
            'marketing_assets_id',
            'rights_information_id',
            'production_info.release_year' => [
                'required',
            ],
            'production_info.production_year' => [
                'required',
            ],
            'production_info.production_status' => [
                'required',
                'in:' . ProductionStatuses::getProductionStatuses()
            ],
            'production_info.country_of_origin',
            'production_info.directors',
            'production_info.producers',
            'production_info.writers',
            'production_info.cast',
            'production_info.awards',
            'production_info.festivals',
            'production_info.box_office',

            'marketing_assets.key_artwork',
            'marketing_assets.production_images',
            'marketing_assets.copyright_information',
            'marketing_assets.links',
            'rights_information',
/*
            'rights_information.available_from_date' => [
                'required',
            ],
            'rights_information.expiry_date' => [
                'required',
            ],
            'rights_information.available_rights',
            'rights_information.holdbacks',
            'rights_information.territories',*/
        ];
    }
}
