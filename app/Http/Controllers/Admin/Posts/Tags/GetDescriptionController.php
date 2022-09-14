<?php

namespace App\Http\Controllers\Admin\Posts\Tags;

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
        $tagId = $request->get('tag_id');

        $status = 0;
        $message = __('Failed');
        $data = '';

        // requested post data
        if ($tagId && $langCode) {
            // try fetching the post model from the repository
            $tag = $this->repository->find($tagId);
            if (!$tag) {
                $message = __('Requested tag not found');
            } else {
                // get description
                $description = $tag->getDescription($langCode, false);
                if (!$description) {
                    $message = __('Requested tag description not found');
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
