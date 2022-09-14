<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\AgencyRanking;
use App\Models\Agency;

class AgencyRankingRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\AgencyRanking $model
     */
    public function __construct(AgencyRanking $model)
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

        $userType = Agency::USER_TYPE;
        return DB::insert('INSERT INTO agency_ranking (user_id, rank, total, created_at)
            SELECT er.id, @curRank := @curRank + 1 AS rank, er.total_reviews, CURRENT_TIMESTAMP 
            FROM (
                SELECT u.id, SUM(ur.rating) AS total_rating, COUNT(ur.user_id) AS total_reviews, AVG(ur.rating) AS avg 
                FROM users AS u 
                LEFT JOIN (
                        SELECT * 
                        FROM user_reviews 
                        WHERE 1 AND is_approved = 1
                        GROUP BY object_id, user_id /* OR AND id IN(SELECT min(id) FROM user_reviews GROUP BY user_id) */
                ) as ur ON u.id = ur.object_id
                WHERE 1 AND u.type = "' . $userType . '"
                GROUP BY u.id  
                ORDER BY total_rating DESC, id ASC
            ) AS er, (SELECT @curRank := 0) r
            ');
    }
}
