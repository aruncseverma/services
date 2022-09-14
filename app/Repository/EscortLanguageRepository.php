<?php
/**
 * user descriptions repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Attribute;
use App\Models\User;
use App\Models\EscortLanguage;
use Illuminate\Support\Facades\DB;

class EscortLanguageRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\EscortLanguage $model
     */
    public function __construct(EscortLanguage $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/updates model data to storage
     *
     * @param  array                      $attributes
     * @param  App\Models\User            $user
     * @param  App\Models\EscortLanguage $model
     *
     * @return App\Models\EscortLanguage
     */
    public function store(array $attributes, User $user, EscortLanguage $model = null) : EscortLanguage
    {
        if (is_null($model)) {
            $model = $this->getModel()->newInstance();
        }

        // save attributes
        foreach ($attributes as $attribute => $value) {
            $model->setAttribute($attribute, $value);
        }

        $user->escortLanguages()->save($model);

        return $model;
    }

    /**
     * find escort language by attribute_id that is attached from the user
     *
     * @param  string $attributeId
     * @param  App\Models\User $user
     *
     * @return App\Models\EscortLanguage|null
     */
    public function findEscortLanguageByAttributeId(string $attributeId, User $user)
    {
        return $user->escortLanguages()->where('attribute_id', $attributeId)->first();
    }
}
