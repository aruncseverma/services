<?php

namespace App\Http\Controllers\Admin\Scripts\Concerns;

use App\Models\Escort;
use App\Repository\EscortLanguageRepository;

trait GenerateLanguageProficiency
{
    /**
     * Generate language proficiency
     * 
     * @return array
     */
    private function generateLanguageProficiency()
    {
        $langAttributes = $this->getAttributesByName('languages');

        $languageProficiency = [];
        if (!empty($langAttributes)) {
            foreach ($langAttributes as $lang) {
                $languageProficiency[$lang->id] = $this->getRandomValue(array_keys($this->getLanguageProficiencyOptions()));
            }
        }
        return $languageProficiency;
    }

    /**
     * save escort language
     *
     * @param  App\Models\Escort $user
     * @param array $data
     *
     * @return void
     */
    private function saveEscortLanguage(Escort $user, $data): void
    {
        $repository = app(EscortLanguageRepository::class);

        foreach ($data as $languageId => $proficiency) {
            // save it
            $repository->store(
                [
                    'attribute_id' => $languageId,
                    'proficiency' => $proficiency,
                ],
                $user
            );
        }
    }
}