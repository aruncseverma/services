<?php
/**
 * save rate duration information controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\RateDurations;

use App\Models\RateDuration;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Support\Concerns\NeedsLanguages;
use App\Support\Concerns\NeedsRateDurations;

class SaveController extends Controller
{
    use NeedsLanguages,
        NeedsRateDurations;

    /**
     * handles incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request) : RedirectResponse
    {
        $duration = null;

        if ($id = $request->input('id')) {
            // get duration requested from repository
            $duration = $this->durationRepository->find($id);

            if (! $duration) {
                $this->notifyError(__('Requested rate duration is invalid'));
                return back();
            }
        }

        // validate
        $this->validateRequest($request);

        // push to repository
        $duration = $this->saveDuration($request, $duration);

        // redirect to next request
        return $this->redirectTo($duration);
    }

    /**
     * validates incoming request data
     *
     * @throws Illuminate\Validation\ValidationException
     *
     * @return void
     */
    protected function validateRequest(Request $request) : void
    {
        $this->validate(
            $request,
            [
                'duration.position' => 'numeric',
                'descriptions'   => 'array',
                'descriptions.*' => 'required',
                'duration.is_active' => 'boolean'
            ]
        );
    }

    /**
     * save duration to repository
     *
     * @param  Illuminate\Http\Request $request
     * @param  App\Models\RateDuration $duration
     *
     * @return null|App\Models\RateDuration
     */
    protected function saveDuration(Request $request, RateDuration $duration = null)
    {
        $attributes = [
            'is_active' => $request->input('duration.is_active', false),
            'position' => $request->input('duration.position', 0),
        ];

        // save duration to the repository
        $duration = $this->durationRepository->store($attributes, $duration);

        if (! $duration) {
            return;
        }

        $langRepository = $this->getLanguageRepository();

        foreach ($request->input('descriptions', []) as $code => $content) {
            $language = $langRepository->findByCode($code);

            // if invalid language
            if (! $language) {
                continue;
            }

            $description = $this->descriptionRepository->store(
                ['content' => $content],
                $language,
                $duration,
                $duration->getDescription($code, false)
            );
        }

        return $duration;
    }

    /**
     * redirect to next request
     *
     * @param  App\Models\RateDuration $duration
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(RateDuration $duration = null) : RedirectResponse
    {
        if (is_null($duration)) {
            $this->notifyError(__('Unable to save your request. Please try again sometime'));
        } else {
            $this->notifySuccess(__('Rate duration successfully saved'));
        }

        // clear cache
        $this->forgetRateDurationCache();

        return redirect()->route('admin.rate_duration.update', ['id' => $duration->getKey()]);
    }
}
