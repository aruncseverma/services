<?php

namespace App\Http\Controllers\Admin\Posts\Tags;

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
        $tagName = $request->input('name');

        if (empty($tagName)) {
            return response()->json([
                'status' => 0,
                'data' => null,
                'message' => __('Tag name is required.')
            ]);
        }

        // check if tag name and langcode is already exists
        $tag = $this->descriptionRepository->getBuilder()
            ->where('name', $tagName)
            ->where('lang_code', $langCode)
            ->first();
        if ($tag) {
            return response()->json([
                'status' => 1,
                'data' => $tag->tag_id,
                'message' => 'Tag is already exists'
            ]);
        }

        // push to repository
        $tag = $this->saveData($tagName, $langCode);

        if (!$tag) {
            return response()->json([
                'status' => 0,
                'data' => null,
                'message' => 'failed'
            ]);
        }
        return response()->json([
            'status' => 1,
            'data' => $tag->getKey(),
            'message' => 'success'
        ]);
    }

    /**
     * save data to repository
     *
     * @param  string $tagName
     * @param  string $code
     *
     * @return null|App\Models\PostTag
     */
    protected function saveData($tagName, $code)
    {
        $attributes = [
            'slug' => $tagName,
            'is_active' => true,
        ];

        // save data to the repository
        $tag = $this->repository->store($attributes);

        if (!$tag) {
            return null;
        }

        $langRepository = $this->getLanguageRepository();
        $language = $langRepository->findByCode($code);

        if ($language) {
            $this->descriptionRepository->store(
                [
                    'name' => $tagName,
                    'description' => null,
                ],
                $language,
                $tag,
                $tag->getDescription($code, false)
            );
        }

        return $tag;
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
