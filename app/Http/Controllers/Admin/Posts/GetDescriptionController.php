<?php

namespace App\Http\Controllers\Admin\Posts;

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
        $postId = $request->get('post_id');

        $status = 0;
        $message = __('Failed');
        $data = '';

        // requested post data
        if ($postId && $langCode) {
            // try fetching the post model from the repository
            $post = $this->repository->find($postId);
            if (!$post) {
                $message = __('Requested post not found');
            } else {
                // get description
                $description = $post->getDescription($langCode, false);
                if (!$description) {
                    $message = __('Requested post description not found');
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
