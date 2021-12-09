<?php
namespace Database\Factories;

use App\Models\Organisation;
use App\Models\Percentage;
use App\Models\VatRule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Util\OrganisationStatuses;
use App\Helper\FileUploader;
use App\Http\Requests\Organisation\UpdateOrganisationRequest;

class OrganisationFactory extends Factory
{

    protected $model = Organisation::class;

    public function definition()
    {
        return [
            'email' => $this->faker->email(),
            'organisation_name' => $this->faker->company(),
            'registration_number' => $this->faker->randomNumber(7),
            'phone_number' => $this->faker->phoneNumber(),
            'telephone_number' => $this->faker->phoneNumber(),
            'organisation_role' => 'buyer',
            'description' => Str::random(10),
            'website_link' => $this->faker->url(),
            'social_links' => [
                "facebook" => $this->faker->url(),
                "twitter" => $this->faker->url(),
                "linkedin" => $this->faker->url(),
                "telegram" => $this->faker->url()
            ],
            'date_activated' => $this->faker->dateTime(),
            'status' => OrganisationStatuses::$ACCEPTED,
            'organisation_type_id' => rand(1, 4),
            'logo_id' => 1,
            'country' => array_random(['DE','AU','GB','HR','US']),
            'city' => $this->faker->city(),
            'address' => $this->faker->address(),
            'postal_code' => $this->faker->postcode(),
            'iban' => $this->faker->iban(),
            'swift_bic' => $this->faker->swiftBicNumber(),
            'bank_name' => $this->faker->city() . ' bank inc.'
        ];
    }
    
    public static function updateFromRequest(UpdateOrganisationRequest $request, Organisation $organisation) {
        
        $data = $request->validated();
        
        if ($request->file('logo')) {
            $image = FileUploader::uploadFile($request, 'image', 'logo');
            $data['logo_id'] = $image->id;
        }
        
        $organisation->update($data);
        
        if (isset($data['vat_rules'])) {
            $organisationFromDb = Organisation::findOrFail($organisation->id);
            $idsToDelete = (array)$organisationFromDb->vat_rules()->pluck('id')->toArray();
            
            $vatRulesRequests = $data['vat_rules'];
            
            foreach ($vatRulesRequests as $vatRuleRequest) {
                
                if (isset($vatRuleRequest['id'])) {
                    $vatRule = VatRule::findOrFail($vatRuleRequest['id']);
                    if (($key = array_search($vatRule->id, $idsToDelete)) !== false) {
                        unset($idsToDelete[$key]);
                    }
                } else {
                    $vatRule = new VatRule();
                }
                
                if (isset($vatRuleRequest['vat'])) {
                    if (isset($vatRuleRequest['vat']['id'])) {
                        $vat = Percentage::findOrFail($vatRuleRequest['vat']['id']);
                        $vat->value = $vatRuleRequest['vat']['value'];
                    } else {
                        $vat = PercentageFactory::createPercentage($vatRuleRequest['vat']['value']);
                    }
                    
                    $vat->save();
                    
                    $vatRule->vat_id = $vat->id;
                    unset($vatRuleRequest['vat']);
                }
                
                $vatRule->organisation_id = $organisation->id;
                $vatRule->rule_type = $vatRuleRequest['rule_type'];
                
                if(isset($vatRuleRequest['country'])){
                    $vatRule->country = $vatRuleRequest['country'];
                }
                
                $vatRule->save();
            }
            
            foreach ($idsToDelete as $id){
                $vatRuleToDelete = VatRule::findOrFail($id);
                $vatRuleToDelete->delete();
            }
        }
        
        return $organisation;
    }
}
