<?php
/**
 * settings eloquent model repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Setting;
use App\Events\Repository\Settings as Events;

class SettingRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\Setting $model
     */
    public function __construct(Setting $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * @override
     *
     * @throw  InvalidArgumentException
     *
     * @param  array                   $attributes
     * @param  App\Models\Setting|null $setting
     *
     * @return App\Models\Setting
     */
    public function save(array $attributes, $setting = null) : Setting
    {
        // check if given setting model instance of App\Models\Setting class
        $this->isModelInstanceOf($setting, Setting::class);

        if (is_null($setting)) {
            $setting = $this->getModel()->newInstance();
        }

        $setting = parent::save($attributes, $setting);

        event(new Events\SavedModelInstance($setting, $attributes));

        return $setting;
    }

    /**
     * find setting given by group and key
     *
     * @param  string $group
     * @param  string $key
     *
     * @return App\Models\Setting|null
     */
    public function findSetting(string $group, string $key)
    {
        return $this->getBuilder()
            ->where('group', $group)
            ->where('key', $key)
            ->first();
    }
}
