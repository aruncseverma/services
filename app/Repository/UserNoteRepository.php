<?php
/**
 * user note model repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\UserNote;

class UserNoteRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\UserNote $model
     */
    public function __construct(UserNote $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * get a user note based on a given object id
     *
     * @param  int $id
     *
     * @return App\Models\UserNote|null
     */
    public function findNoteByObject($id) : ?UserNote
    {
        return $this->getBuilder()
            ->where(['object_id' => $id])
            ->first();
    }
}
