<?php

namespace App\Http\Controllers\Admin\Scripts\Concerns;

use Faker\Factory as Faker;

use App\Support\Concerns\NeedsLanguages;

use App\Models\Escort;
use App\Repository\UserDescriptionRepository;

trait GenerateUserDescriptions
{
    use NeedsLanguages;

    private function generateUserDescriptions()
    {
        $faker = Faker::create();

        $languages = $this->getLanguages();
        $descriptions = [];
        foreach ($languages as $k => $lang) {
            $descriptions[$lang->code] = $faker->realText;
        }
        return $descriptions;
    }

    /**
     * save user description
     *
     * @param  App\Models\Escort $user
     * @param array $descriptions
     *
     * @return void
     */
    protected function saveUserDescription(Escort $user, $descriptions): void
    {
        $repository = app(UserDescriptionRepository::class);
        foreach ($descriptions as $code => $content) {
            $repository->store(
                [
                    'lang_code' => $code,
                    'content' => $content,
                ],
                $user
            );
        }
    }
}