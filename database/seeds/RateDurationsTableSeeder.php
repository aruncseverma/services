<?php

use Illuminate\Database\Seeder;
use App\Support\Concerns\NeedsLanguages;
use App\Repository\RateDurationRepository;
use App\Repository\RateDurationDescriptionRepository;

class RateDurationsTableSeeder extends Seeder
{
    use NeedsLanguages;

    /**
     * duration repository
     *
     * @var App\Repository\RateDurationRepository
     */
    protected $durationRepository;

    /**
     * duration description repository
     *
     * @var App\Repository\RateDurationDescriptionRepository
     */
    protected $descriptionRepository;

    /**
     * create instance
     *
     * @param App\Repository\RateDurationRepository            $durationRepository
     * @param App\Repository\RateDurationDescriptionRepository $descriptionRepository
     */
    public function __construct(RateDurationRepository $durationRepository, RateDurationDescriptionRepository $descriptionRepository)
    {
        $this->durationRepository = $durationRepository;
        $this->descriptionRepository = $descriptionRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getDurations() as $key => $description) {
            // create duration
            $duration = $this->durationRepository->store([
                'is_active' => true,
                'position' => $key + 1,
            ]);

            // create descriptions
            foreach ($this->getLanguages() as $language) {
                $this->descriptionRepository->store(['content' => $description], $language, $duration);
            }
        }
    }

    /**
     * get all durations
     *
     * @return array
     */
    protected function getDurations() : array
    {
        return [
            '1 Hour',
            '2 Hours',
            '3 Hours',
            'Overnight',
            '1 Day',
            '2 Days',
            'Weekend',
        ];
    }
}
