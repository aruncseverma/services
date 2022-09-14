<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\EscortRanking;
use App\Models\Escort;

class EscortRankingRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\EscortRanking $model
     */
    public function __construct(EscortRanking $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * truncate table
     *
     * @return void
     */
    public function truncate()
    {
        DB::table($this->getTableFromModel())->truncate();
    }

    /**
     * generate ranking for escorts
     *
     * @return boolean
     */
    public function generateRanking() : bool
    {
        $this->truncate();

        $userType = Escort::USER_TYPE;
        return DB::insert('INSERT INTO escort_ranking (user_id, rank, total, created_at)
            SELECT er.id, @curRank := @curRank + 1 AS rank, er.total_reviews, CURRENT_TIMESTAMP 
            FROM (
                SELECT e.id, SUM(ur.rating) AS total_rating, COUNT(ur.user_id) AS total_reviews, AVG(ur.rating) AS avg 
                FROM users AS e 
                LEFT JOIN (
                        SELECT * 
                        FROM user_reviews 
                        WHERE 1 AND is_approved = 1
                        GROUP BY object_id, user_id /* OR AND id IN(SELECT min(id) FROM user_reviews GROUP BY user_id) */
                ) as ur ON e.id = ur.object_id
                WHERE 1 AND e.type = "' . $userType . '"
                GROUP BY e.id  
                ORDER BY total_rating DESC, id ASC
            ) AS er, (SELECT @curRank := 0) r
            ');
    }
}
