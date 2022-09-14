<?php

namespace App\Http\Controllers\Admin\Scripts\Concerns;

use App\Repository\AttributeRepository;

trait Helpers
{
    private function getRandomBoolean()
    {
        return rand(0, 1);
    }

    private function getRandomValue(array $values)
    {
        //$value = substr(str_shuffle(str_repeat($x = implode('',$values), ceil(1 / strlen($x)))), 1, 1);
        $value = $values[array_rand($values, 1)];
        return $value;
    }

    /**
     * get attribute options
     *
     * @return Illuminate\Support\Collection
     */
    protected function getAttributesByName($name = '')
    {
        if (empty($name)) {
            return false;
        }

        $repository = app(AttributeRepository::class);

        return $repository->findAll([
            'name' => $name,
            'is_active' => true
        ]);
    }

    /**
     * get attribute options
     *
     * @return Illuminate\Support\Collection
     */
    protected function getRandomAttributesByName($name = '')
    {
        if (empty($name)) {
            return '';
        }

        $repository = app(AttributeRepository::class);

        $random = $repository->getBuilder()
            ->select('id')
            ->where('is_active', true)
            ->where('name', $name)
            ->inRandomOrder()
            ->first();
        return $random ? $random->id : '';
    }
}