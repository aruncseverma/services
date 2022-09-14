<?php

namespace App\Http\Controllers\Admin\Scripts\Concerns;

use Faker\Factory as Faker;

use App\Models\Escort;
use App\Repository\UserDataRepository;
use App\Repository\CountryRepository;

trait GenerateUserData
{
    /**
     * Generate user data
     * 
     * @return array
     */
    private function generateUserData()
    {
        $faker = Faker::create();

        $originId = $this->getOriginId();
        $userDataFields = [
            // basic information
            'origin_id' => $originId,
            'ethnicity_id' => $this->getRandomAttributesByName('ethnicity'),
            'ethnicity_id2' => $this->getRandomAttributesByName('ethnicity'),
            'orientation_2_liner' => $this->getRandomValue([
                'S', // Straight
                'B', // Bisexual
            ]),
            'pornstar' => $this->getRandomValue([
                'Y', // Yes
                'N', // No
            ]),
            'service_type' => $this->getRandomValue([
                'I', // Incall Only
                'O', // Outcall Only
            ]),
            'social' => $this->getRandomValue([
                'Y', // Yes
                'N', // No
            ]),

            // physical information
            'blood_type_id' => $this->getRandomValue(array_keys($this->getBloodTypeOptions())),
            'bust_id' => $this->getRandomValue(array_keys($this->getBustOptions())),
            'cup_size_id' => $this->getRandomAttributesByName('cup_size'),
            'eye_color_id' => $this->getRandomAttributesByName('eye_color'),
            'hair_color_id' => $this->getRandomAttributesByName('hair_color'),
            'hair_length_2_liner_id' => $this->getRandomValue(array_keys($this->getHairLength2LinerOptions())),
            'height_id' => $this->getRandomValue(array_keys($this->getHeightOptions())),
            'weight_id' => $this->getRandomValue(array_keys($this->getWeightOptions())),

            // contact information
            'contact_platform_ids' => $this->getRandomValue([
                'call', 'sms', 'whatsapp', 'telegram', 'viber'
            ]),
            'skype_id' => $faker->username,
        ];

        return $userDataFields;
    }

    /**
     * Generate origin id
     * 
     * @return array
     */
    private function getOriginId()
    {
        $repo = app(CountryRepository::class);
        $origin = $repo->getBuilder()
            ->select('id')
            ->inRandomOrder()
            ->first();
        return $origin ? $origin->id : null;
    }

    /**
     * get language proficiency options
     *
     * @return array
     */
    protected function getLanguageProficiencyOptions()
    {
        return [
            'G' => 'Good',
            'M' => 'Moderate',
            'E' => 'Expert',
        ];
    }

    /**
     * get hair length 2 liner options
     *
     * @return array
     */
    protected function getHairLength2LinerOptions()
    {
        $min = 0.5;
        $max = 20;
        $add = $min;
        $options = [];

        for ($val = $min; $val <= $max; $val += $add) {
            $options["$val"] = sprintf('%s inches', $val);
        }

        return $options;
    }

    /**
     * get height options
     *
     * @return array
     */
    protected function getHeightOptions()
    {
        $oneInchToCm = 2.54;
        $minHeightCm = 152.4;
        $maxHeightCm = 213.36;

        $heights = [];
        for ($heightCm = $minHeightCm; $heightCm < $maxHeightCm; $heightCm += $oneInchToCm) {
            // convert centimetres to inches
            $inches = round($heightCm / 2.54);
            // now find the number of feet...
            $feet = floor($inches / 12);
            // ..and then inches
            $inches = ($inches % 12);
            $heights["$heightCm"] = sprintf('%d\'%d"', $feet, $inches);
        }

        return $heights;
    }

    /**
     * get weight options
     *
     * @return array
     */
    protected function getWeightOptions()
    {
        $minLbs = 80;
        $maxLbs = 300;
        $weights = [];

        for ($lbs = $minLbs; $lbs <= $maxLbs; ++$lbs) {
            $weights[$lbs] = sprintf('%dlbs', $lbs);
        }

        return $weights;
    }

    /**
     * get blood type options
     *
     * @return array
     */
    protected function getBloodTypeOptions()
    {
        return [
            'A' => 'A',
            'B' => 'B',
            'AB' => 'AB',
            'O' => 'O',
        ];
    }

    /**
     * get bust options
     *
     * @return array
     */
    protected function getBustOptions()
    {
        $minCm = 80;
        $maxCm = 300;
        $busts = [];

        for ($cm = $minCm; $cm <= $maxCm; ++$cm) {
            $busts[$cm] = sprintf('%dcm', $cm);
        }

        return $busts;
    }

    /**
     * save user data
     *
     * @param  App\Models\Escort $user
     * @param array $userDataFields
     *
     * @return void
     */
    protected function saveUserData(Escort $user, $userDataFields): void
    {
        $repository = app(UserDataRepository::class);

        $fields = [];
        foreach ($userDataFields as $field => $value) {
            $fields[$field] = $value;
        }
        $repository->saveUserData($user, $fields);
    }
}