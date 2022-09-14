<?php

namespace App\Http\Controllers\Admin\Posts\Categories;

use Illuminate\Http\Request;
use App\Support\Concerns\NeedsLanguages;
use Illuminate\Http\JsonResponse;

class QuickAddController extends Controller
{
    use NeedsLanguages;

    /**
     * handles incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function handle(Request $request): JsonResponse
    {
        $langCode = app()->getLocale();
        $categoryName = $request->input('name');
        $parentId = $request->input('parent_id');

        if (empty($categoryName)) {
            return response()->json([
                'status' => 0,
                'data' => 'category_name',
                'message' => __('Category name is required.')
            ]);
        }

        if ($parentId > 0) {
            $parentCategory = $this->repository->find($parentId);
            if (!$parentCategory) {
                return response()->json([
                    'status' => 0,
                    'data' => 'parent_category',
                    'message' => __('Parent category is invalid.')
                ]);
            }
        }

        // check if category name and langcode is already exists
        $category = $this->descriptionRepository->getBuilder()
            ->where('name', $categoryName)
            ->where('lang_code', $langCode)
            ->first();
        if ($category) {
            return response()->json([
                'status' => 0,
                'data' => $category->category_id,
                'message' => __('Category is already exists.')
            ]);
        }

        // push to repository
        $category = $this->saveData($categoryName, $langCode, $parentId);

        if (!$category) {
            return response()->json([
                'status' => 0,
                'data' => null,
                'message' => __('Failed')
            ]);
        }
        return response()->json([
            'status' => 1,
            'data' => $category->getKey(),
            'message' => __('Success')
        ]);
    }

    /**
     * save data to repository
     *
     * @param  string $categoryName
     * @param  string $code
     * @param  int|null $parentId
     *
     * @return null|App\Models\PostCategory
     */
    protected function saveData($categoryName, $code, $parentId = null)
    {
        $attributes = [
            'slug' => $categoryName,
            'is_active' => true,
            'parent_id' => $parentId
        ];

        // save data to the repository
        $category = $this->repository->store($attributes);

        if (!$category) {
            return null;
        }

        $langRepository = $this->getLanguageRepository();
        $language = $langRepository->findByCode($code);

        if ($language) {
            $this->descriptionRepository->store(
                [
                    'name' => $categoryName,
                    'description' => null,
                ],
                $language,
                $category,
                $category->getDescription($code, false)
            );
        }

        return $category;
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware(): void
    {
        $this->middleware('can:posts.update');
        $this->middleware('can:posts.create');
    }
}
