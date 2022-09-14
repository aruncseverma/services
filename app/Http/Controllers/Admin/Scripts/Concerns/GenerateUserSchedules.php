<?php

namespace App\Http\Controllers\Admin\Scripts\Concerns;

use Faker\Factory as Faker;
use App\Models\Escort;
use App\Models\EscortSchedule;
use App\Repository\EscortScheduleRepository;

trait GenerateUserSchedules
{
    /**
     * get schedule days
     *
     * @return array
     */
    private function getDays(): array
    {
        return [
            EscortSchedule::SCHEDULE_MONDAY => __('Monday'),
            EscortSchedule::SCHEDULE_TUESDAY => __('Tuesday'),
            EscortSchedule::SCHEDULE_WEDNESDAY => __('Wednesday'),
            EscortSchedule::SCHEDULE_THURSDAY => __('Thursday'),
            EscortSchedule::SCHEDULE_FRIDAY => __('Friday'),
            EscortSchedule::SCHEDULE_SATURDAY => __('Saturday'),
            EscortSchedule::SCHEDULE_SUNDAY => __('Sunday'),
        ];
    }

    /**
     * Generate user schedules
     * 
     * @return array
     */
    private function generateUserSchedules()
    {
        $days = $this->getDays();
        $userSchedules = [];
        if (!empty($days)) {
            $faker = Faker::create();
            $min = 0;
            $max = 24;
            foreach ($days as $day => $label) {
                $from = $faker->numberBetween($min, $max);
                $till = $faker->numberBetween($from, $max);
                $userSchedules[] = [
                    'day' => $day,
                    'from' => sprintf("%02d:00:00", $from),
                    'till' => sprintf("%02d:00:00", $till)
                ];
            }
        }
        return $userSchedules;
    }

    /**
     * save user schedules
     *
     * @param  App\Models\Escort $user
     * @param array $userSchedules
     *
     * @return void
     */
    private function saveUserSchedules(Escort $user, $userSchedules): void
    {
        $repository = app(EscortScheduleRepository::class);
        foreach ($userSchedules as $data) {
            $data['user_id'] = $user->getKey();
            $repository->save($data);
        }
    }
}