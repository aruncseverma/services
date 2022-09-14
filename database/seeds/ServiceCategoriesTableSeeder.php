<?php

use Illuminate\Database\Seeder;
use App\Support\Concerns\NeedsLanguages;
use App\Repository\ServiceCategoryRepository;
use App\Repository\ServiceCategoryDescriptionRepository;

class ServiceCategoriesTableSeeder extends Seeder
{
    use NeedsLanguages;

    /**
     * category repository instance
     *
     * @var App\Repository\ServiceCategoryRepository
     */
    protected $categoryRepository;

    /**
     * description repository instance
     *
     * @var App\Repository\ServiceCategoryDescriptionRepository
     */
    protected $descriptionRepository;

    /**
     * create instance
     *
     * @param App\Repository\ServiceCategoryRepository            $categoryRepository
     * @param App\Repository\ServiceCategoryDescriptionRepository $descriptionRepository
     */
    public function __construct(
        ServiceCategoryRepository $categoryRepository,
        ServiceCategoryDescriptionRepository $descriptionRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->descriptionRepository = $descriptionRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getCategories() as $description) {
            // create category
            $category = $this->categoryRepository->save([
                'is_active' => true,
            ]);

            foreach ($this->getLanguages() as $language) {
                $this->descriptionRepository->store(
                    [
                        'content' => $description,
                    ],
                    $category,
                    $language
                );
            }
        }
    }

    /**
     * get default service categories
     *
     * @return array
     */
    protected function getCategories() : array
    {
        return [
            'Escort Services',
            'Erotic Services',
            'Kinky Services',
            'Fetish Services',
        ];
    }
}
