<?php

namespace App\Http\Controllers\Admin\Posts\Categories;

use Illuminate\Http\Request;
use App\Support\Concerns\NeedsLanguages;
use Illuminate\Http\JsonResponse;

class GetDescriptionController extends Controller
{
    use NeedsLanguages;

    /**
     * renders form view
     *
     * @param  Illuminate\Http\Request
     *
     * @return JsonResponse
     */
    public function view(Request $request) : JsonResponse
    {
        $langCode = $request->input('lang_code', false);
        $catId = $request->get('category_id');

        $status = 0;
        $message = __('Failed');
        $data = '';

        // requested post data
        if ($catId && $langCode) {
            // try fetching the post model from the repository
            $category = $this->repository->find($catId);
            if (!$category) {
                $message = __('Requested category not found');
            } else {
                // get description
                $description = $category->getDescription($langCode, false);
                if (!$description) {
                    $message = __('Requested category description not found');
                } else {
                    $status = 1;
                    $message = __('Success');
                    $data = $description;
                }
            }
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware(): void
    {
        $this->middleware('can:posts.update');
    }
}
