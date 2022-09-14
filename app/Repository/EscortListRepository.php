<?php
/**
 * Index's model repostory class
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Repository;

use App\Models\Escort;
use App\Models\EscortList;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EscortListRepository extends EscortRepository
{
    /**
     * create instance
     *
     * @param App\Models\EscortList $model
     */
    public function __construct(EscortList $model)
    {
        parent::__construct($model);
    }

    /**
     * fetches all escorts
     *
     * @return Collection|null
     */
    public function getAll(array $param)
    {
        $escorts = $this->newModelInstance()
            ->with('memberships')
            ->where('type', Escort::USER_TYPE)
            ->where('is_approved', 1)
            ->get();

        return $escorts;
    }

    /**
     * fetches all escorts according to provided filter
     *
     * @param array $params
     * @return Collection|null
     */
    public function filter(array $params)
    {
        $model = $this->getBuilder();
        $mainTable = $model->getModel()->getTable();
        $mainTableKey = $model->getModel()->getKeyName();

        $model->with('memberships')
            ->with('reviews')
            ->with('userData')
            ->with('mainLocation')
            ->with('mainLocation.city');

        //$mainTable = $model->getModel()->getTable();
        $model->select("{$mainTable}.*");
    
        $model->where("{$mainTable}.type", Escort::USER_TYPE)
            ->where("{$mainTable}.is_approved", 1);

        // get approved escorts by age
        if (isset($params['age'])) {
            $age = explode('-', $params['age']);
            $model->whereBetween(DB::raw('TIMESTAMPDIFF(YEAR, birthdate, NOW())'), [$age[0], $age[1]]);
        }

        // filter by gender
        if (isset($params['gender'])) {
            $model->where('gender', $params['gender']);
        }

        // filter pornstar only
        if (isset($params['pornstar'])) {

            $relation = $model->getModel()->userData();
            $mainTable = $model->getModel()->getTable();
            $mainTableKey = $model->getModel()->getKeyName();
            $foreignTable = $relation->getModel()->getTable();

            $model->join($foreignTable, "{$mainTable}.{$mainTableKey}", "=", $relation->getQualifiedForeignKeyName());
            $model->where("{$foreignTable}.field", "pornstar");
            $model->where("{$foreignTable}.content", $params['pornstar']);
        }

        // filter user data
        if (isset($params['ethnicity']) 
            || isset($params['height']) 
            // basic
            || isset($params['orientation'])
            || isset($params['origin'])
            || isset($params['service_type'])
            // physical
            || isset($params['hair_color_id'])
            || isset($params['eye_color_id'])
            || isset($params['hair_length'])
        ) {
            $relation = $model->getModel()->userData();
            $mainTable = $model->getModel()->getTable();
            $mainTableKey = $model->getModel()->getKeyName();
            $foreignTable = $relation->getModel()->getTable();
            $foreignKeyName = $relation->getForeignKeyName();

            // filter by ethnicity
            if (isset($params['ethnicity'])) {
                $asTable = 'ethnicityData';
                $model->join("$foreignTable as $asTable", "{$mainTable}.{$mainTableKey}", "=", $asTable . '.' . $foreignKeyName);
                $model->where("{$asTable}.field", "ethnicity_id");
                $model->where("{$asTable}.content", $params['ethnicity']);
            }

            // filter by height
            if (isset($params['height'])) {
                $asTable = 'heightData';
                $model->join("$foreignTable as $asTable", "{$mainTable}.{$mainTableKey}", "=", $asTable . '.' . $foreignKeyName);
                $model->where("{$asTable}.field", "height_id");
                $model->where("{$asTable}.content", $params['height']);
            }

            // filter by orientation
            if (isset($params['orientation'])) {
                $asTable = 'orientationData';
                $model->join("$foreignTable as $asTable", "{$mainTable}.{$mainTableKey}", "=", $asTable . '.' . $foreignKeyName);
                $model->where("{$asTable}.field", "orientation_2_liner");
                $model->where("{$asTable}.content", $params['orientation']);
            }

            // filter by origin
            if (isset($params['origin'])) {
                $asTable = 'originData';
                $model->join("$foreignTable as $asTable", "{$mainTable}.{$mainTableKey}", "=", $asTable . '.' . $foreignKeyName);
                $model->where("{$asTable}.field", "origin_id");
                $model->where("{$asTable}.content", $params['origin']);
            }

            // filter by service_type
            if (isset($params['service_type'])) {
                $asTable = 'serviceTypeData';
                $model->join("$foreignTable as $asTable", "{$mainTable}.{$mainTableKey}", "=", $asTable . '.' . $foreignKeyName);
                $model->where("{$asTable}.field", "service_type");
                $model->where("{$asTable}.content",
                    $params['service_type']
                );
            }

            // filter by hair_color_id
            if (isset($params['hair_color_id'])) {
                $asTable = 'hairColorData';
                $model->join("$foreignTable as $asTable", "{$mainTable}.{$mainTableKey}", "=", $asTable . '.' . $foreignKeyName);
                $model->where("{$asTable}.field", "hair_color_id");
                $model->where(
                    "{$asTable}.content",
                    $params['hair_color_id']
                );
            }

            // filter by eye_color_id
            if (isset($params['eye_color_id'])) {
                $asTable = 'eyeColorData';
                $model->join("$foreignTable as $asTable", "{$mainTable}.{$mainTableKey}", "=", $asTable . '.' . $foreignKeyName);
                $model->where("{$asTable}.field", "eye_color_id");
                $model->where(
                    "{$asTable}.content",
                    $params['eye_color_id']
                );
            }
            
            // filter by hair_length
            if (isset($params['hair_length'])) {
                $asTable = 'hairLengthData';
                $model->join("$foreignTable as $asTable", "{$mainTable}.{$mainTableKey}", "=", $asTable . '.' . $foreignKeyName);
                $model->where("{$asTable}.field", "hair_length_2_liner_id");
                $model->where(
                    "{$asTable}.content",
                    $params['hair_length']
                );
            }
        }

        // filter by verification
        if (isset($params['verification'])) {
            $model->where('user_group_id', $params['verification']);
        }

        // select average
        if (isset($params['reviews'])) {
            $relation = $model->getModel()->reviews();
            $mainTable = $model->getModel()->getTable();
            $mainTableKey = $model->getModel()->getKeyName();
            $foreignTable = $relation->getModel()->getTable();

            $model->join($foreignTable, "{$mainTable}.{$mainTableKey}", "=", $relation->getQualifiedForeignKeyName())
                ->addSelect(DB::raw("FORMAT(SUM({$foreignTable}.rating)/COUNT({$foreignTable}.object_id), 1) AS rating"));
            $model->where("{$foreignTable}.is_approved", 1);
            $model->havingRaw('rating >= ? AND rating < ?', [
                $params['reviews'], 
                ($params['reviews']+1)
            ]);
        }

        if (isset($params['with_review'])) {
            $relation = $model->getModel()->reviews();
            $mainTable = $model->getModel()->getTable();
            $mainTableKey = $model->getModel()->getKeyName();
            $foreignTable = $relation->getModel()->getTable();

            if ($params['with_review'] == 1) {
                $whereExists = "1 FROM {$foreignTable} WHERE object_id = " . $mainTable . '.' . $mainTableKey;
                $model->whereExists(function ($query) use ($whereExists) {
                    $query->select(DB::raw($whereExists));
                });
            } elseif ($params['with_review'] == 0) {
                $whereExists = "1 FROM {$foreignTable} WHERE object_id = " . $mainTable . '.' . $mainTableKey;
                $model->whereNotExists(function ($query) use ($whereExists) {
                    $query->select(DB::raw($whereExists));
                });
            }
        }

        // search by keyword
        if (isset($params['search'])) {
            $model->where('name', 'LIKE', "%{$params['search']}%");
        }

        // filter by country
        if (isset($params['country_id'])) {
            $relation = $model->getModel()->mainLocation();
            $mainTable = $model->getModel()->getTable();
            $mainTableKey = $model->getModel()->getKeyName();
            $foreignTable = $relation->getModel()->getTable();

            $model->join($foreignTable, "{$mainTable}.{$mainTableKey}", "=", $relation->getQualifiedForeignKeyName());
            $model->where('country_id', $params['country_id']);

            if (isset($params['state_id'])) {
                $model->where('state_id', $params['state_id']);
            }

            if (isset($params['city_id'])) {
                $model->where('city_id', $params['city_id']);
            }

            $model->select(["{$mainTable}.*",
                "{$foreignTable}.country_id", 
                "{$foreignTable}.state_id", 
                "{$foreignTable}.city_id"
            ]);
        }

        // filter by video
        if (isset($params['with_video'])) {
            if ($params['with_video'] == 1) {
                $whereExists = '1 FROM user_videos WHERE user_id = ' . $mainTable . '.' . $mainTableKey;
                $model->whereExists(function ($query) use ($whereExists) {
                    $query->select(DB::raw($whereExists));
                });
            } elseif ($params['with_video'] == 0) {
                $whereExists = '1 FROM user_videos WHERE user_id = ' . $mainTable . '.' . $mainTableKey;
                $model->whereNotExists(function ($query) use ($whereExists) {
                    $query->select(DB::raw($whereExists));
                });
            }
        }

        // filter by today
        if (isset($params['today']) && $params['today'] == 1) {
            $model->whereDate('created_at', Carbon::today());
        } else if (isset($params['new']) && $params['new'] == 1) {
            // filter by new
            $model->whereDate('created_at', '>=', Carbon::now()->subDays(7));
            $model->whereDate('created_at', '<=', Carbon::today());
        }

        // filter by languages
        if (isset($params['lang_ids']) && !empty($params['lang_ids'])) {
            $langIds = is_array($params['lang_ids']) ? $params['lang_ids'] : explode(',', $params['lang_ids']);
            if (!empty($langIds)) {
                $relation = $model->getModel()->escortLanguages();
                $foreignTable = $relation->getModel()->getTable();
                $foreignKeyName = $relation->getForeignKeyName();

                foreach($langIds as $langId) {
                    // we can use where exists or multiple joins
                    $asTable = 'langData'.$langId;
                    $model->join("$foreignTable as $asTable", "{$mainTable}.{$mainTableKey}", "=", $asTable . '.' . $foreignKeyName);
                    $model->where("{$asTable}.attribute_id", $langId);
                }
                
            }
        }

        // filter by escort services
        if (isset($params['escort_service_ids']) && !empty($params['escort_service_ids'])) {
            $ids = is_array($params['escort_service_ids']) ? $params['escort_service_ids'] : explode(',', $params['escort_service_ids']);
            if (!empty($ids)) {
                $foreignTable = 'escort_services';
                $foreignKeyName = 'user_id';
                foreach ($ids as $id) {
                    $asTable = 'escortServiceData' . $id;
                    $model->join("$foreignTable as $asTable", "{$mainTable}.{$mainTableKey}", "=", $asTable . '.' . $foreignKeyName);
                    $model->where("{$asTable}.service_id", $id);
                }
            }
        }

        // filter by erotic services
        if (isset($params['erotic_service_ids']) && !empty($params['erotic_service_ids'])) {
            $ids = is_array($params['erotic_service_ids']) ? $params['erotic_service_ids'] : explode(',', $params['erotic_service_ids']);
            if (!empty($ids)) {
                $foreignTable = 'escort_services';
                $foreignKeyName = 'user_id';
                foreach ($ids as $id) {
                    $asTable = 'eroticServiceData' . $id;
                    $model->join("$foreignTable as $asTable", "{$mainTable}.{$mainTableKey}", "=", $asTable . '.' . $foreignKeyName);
                    $model->where("{$asTable}.service_id", $id);
                }
            }
        }

        // filter by extra services
        if (isset($params['extra_service_ids']) && !empty($params['extra_service_ids'])) {
            $ids = is_array($params['extra_service_ids']) ? $params['extra_service_ids'] : explode(',', $params['extra_service_ids']);
            if (!empty($ids)) {
                $foreignTable = 'escort_services';
                $foreignKeyName = 'user_id';
                foreach ($ids as $id) {
                    $asTable = 'extraServiceData' . $id;
                    $model->join("$foreignTable as $asTable", "{$mainTable}.{$mainTableKey}", "=", $asTable . '.' . $foreignKeyName);
                    $model->where("{$asTable}.service_id", $id);
                }
            }
        }

        // filter by fetish services
        if (isset($params['fetish_service_ids']) && !empty($params['fetish_service_ids'])) {
            $ids = is_array($params['fetish_service_ids']) ? $params['fetish_service_ids'] : explode(',', $params['fetish_service_ids']);
            if (!empty($ids)) {
                $foreignTable = 'escort_services';
                $foreignKeyName = 'user_id';
                foreach ($ids as $id) {
                    $asTable = 'fetishServiceData' . $id;
                    $model->join("$foreignTable as $asTable", "{$mainTable}.{$mainTableKey}", "=", $asTable . '.' . $foreignKeyName);
                    $model->where("{$asTable}.service_id", $id);
                }
            }
        }

        $model->groupBy('id');

        //dump($model->toSql());
        //dd($model->get()->toArray());
        return $model->get();
        
    }

    /**
     * Get total escort with or without review
     * @param bool $withReview
     * @return int
     */
    public function getTotalEscortByReview($withReview = true)
    {
        $model = $this->getBuilder();
        $mainTable = $model->getModel()->getTable();
        $mainTableKey = $model->getModel()->getKeyName();
        $foreignTable = 'user_reviews';

        $model->selectRaw('COUNT(*) as total');
        $model->where("{$mainTable}.type", Escort::USER_TYPE);
        $model->where("{$mainTable}.is_approved", 1);

        if ($withReview) {
            $whereExists = "1 FROM {$foreignTable} WHERE object_id = " . $mainTable . '.' . $mainTableKey;
            $model->whereExists(function ($query) use ($whereExists) {
                $query->select(DB::raw($whereExists));
            });
        } else {
            $whereExists = "1 FROM {$foreignTable} WHERE object_id = " . $mainTable . '.' . $mainTableKey;
            $model->whereNotExists(function ($query) use ($whereExists) {
                $query->select(DB::raw($whereExists));
            });
        }
        
        return $model->first()->total;
    }

    /**
     * Get total escort with or without video
     * @param bool $withVideo
     * @return int
     */
    public function getTotalEscortByVideo($withVideo = true)
    {
        $model = $this->getBuilder();
        $mainTable = $model->getModel()->getTable();
        $mainTableKey = $model->getModel()->getKeyName();
        $foreignTable = 'user_videos';

        $model->selectRaw('COUNT(*) as total');
        $model->where("{$mainTable}.type", Escort::USER_TYPE);
        $model->where("{$mainTable}.is_approved", 1);

        if ($withVideo) {
            $whereExists = "1 FROM {$foreignTable} WHERE user_id = " . $mainTable . '.' . $mainTableKey;
            $model->whereExists(function ($query) use ($whereExists) {
                $query->select(DB::raw($whereExists));
            });
        } else {
            $whereExists = "1 FROM {$foreignTable} WHERE user_id = " . $mainTable . '.' . $mainTableKey;
            $model->whereNotExists(function ($query) use ($whereExists) {
                $query->select(DB::raw($whereExists));
            });
        }

        return $model->first()->total;
    }

    /**
     * Get total escort by availability
     * @return array|null
     */
    public function getTotalEscortByAvailability()
    {
        $model = $this->getBuilder();
        $mainTable = $model->getModel()->getTable();
        $mainTableKey = $model->getModel()->getKeyName();
        $relation = $model->getModel()->userData();
        $foreignTable = $relation->getModel()->getTable();

        $model->selectRaw("{$foreignTable}.content, COUNT(*) as total");
        $model->where("{$mainTable}.type", Escort::USER_TYPE);
        $model->where("{$mainTable}.is_approved", 1);

        $model->join($foreignTable, "{$mainTable}.{$mainTableKey}", "=", $relation->getQualifiedForeignKeyName());
        $model->where("{$foreignTable}.field", "service_type");
        $model->groupBy("{$foreignTable}.content");
        $res = $model->get()->pluck('total', 'content');
        return $res;
    }

    /**
     * Get All available origin with escorts
     *
     * @return Collection
     */
    public function getEscortOrigins()
    {
        $model = $this->getBuilder();
        $mainTable = $model->getModel()->getTable();
        $mainTableKey = $model->getModel()->getKeyName();
        $relation = $model->getModel()->userData();
        $foreignTable = $relation->getModel()->getTable();

        $countryTable = 'countries';
        $countryKey = 'id';

        $model->selectRaw("{$countryTable}.id, {$countryTable}.name, COUNT(*) as total");
        $model->where("{$mainTable}.type", Escort::USER_TYPE);
        $model->where("{$mainTable}.is_approved", 1);

        $model->join($foreignTable, "{$mainTable}.{$mainTableKey}", "=", $relation->getQualifiedForeignKeyName());
        $model->where("{$foreignTable}.field", "origin_id");

        $model->join($countryTable, "{$foreignTable}.content", "=", "{$countryTable}.{$countryKey}");
 
        $model->groupBy("{$foreignTable}.content");
        $model->orderBy('name');
        $res = $model->get();
        return $res;


        $model = $this->getModel()->newModelInstance()
            ->with('country');

        $mainTable = $model->getModel()->getTable();
        $mainTableKey = $model->getModel()->getKeyName();

        $relation = $model->getModel()->country();
        $foreignTable = $relation->getModel()->getTable();

        $model->join($foreignTable, "{$mainTable}.{$relation->getForeignKey()}", "=", "{$foreignTable}.{$mainTableKey}");

        $model->select('country_id', DB::raw('count(*) as total'));
        $model->groupBy('country_id');

        return $model->orderBy('name')->get();
    }
}