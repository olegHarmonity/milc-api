<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\Product;
use App\Models\ProductionInfo;
use Illuminate\Database\Seeder;

class ProductionInfoSeeder extends Seeder
{
    public function run()
    {
      
        ProductionInfo::factory()
            ->count(5)
            ->create();

        $persons = Person::all();

        $firstProductionInfo = ProductionInfo::where('id', 1)->firstOrFail();

        $firstProductionInfo->directors()->attach([1]);

        $firstProductionInfo->producers()->attach([1]);

        $firstProductionInfo->writers()->attach([1]);

        $firstProductionInfo->cast()->attach([1]);

        ProductionInfo::where('id', '!=', 1)->each(function ($productionInfo) use ($persons) {

            $productionInfo->directors()->attach(
                $persons->random(rand(1, 3))->pluck('id')->toArray()
            );

            $productionInfo->producers()->attach(
                $persons->random(rand(1, 2))->pluck('id')->toArray()
            );

            $productionInfo->writers()->attach(
                $persons->random(rand(2, 5))->pluck('id')->toArray()
            );

            $productionInfo->cast()->attach(
                $persons->random(rand(3, 5))->pluck('id')->toArray()
            );

        });
    }
}
