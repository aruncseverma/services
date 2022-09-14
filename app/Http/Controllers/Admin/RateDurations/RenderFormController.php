<?php
/**
 * renders form view controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\RateDurations;

use App\Models\RateDuration;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Support\Concerns\NeedsLanguages;

class RenderFormController extends Controller
{
    use NeedsLanguages;

    /**
     * renders form view
     *
     * @param  Illuminate\Http\Request
     *
     * @return Illuminate\Contracts\View\View
     *         Illuminate\Http\RedirectResponse
     */
    public function view(Request $request)
    {
        // get duration model from old input if necessary
        $duration = $this->getModelFromOldRequest();

        // requested rate duration
        if ($id = $request->get('id')) {
            // try fetching the duration model from the repository
            $duration = $this->durationRepository->find($id);

            if (! $duration) {
                $this->notifyError(__('Requested rate duration not found'));
                return redirect()->route('admin.rate_durations.create');
            }
        }

        // set necessary title for this form
        $this->setTitle(
            ($duration->getKey()) ? __('Update Rate Duration') : __('New Rate Duration')
        );

        return view('Admin::rate_durations.form', [
            'duration' => $duration,
            'languages' => $this->getLanguages(),
        ]);
    }

    /**
     * get model instance from old request values
     *
     * @return App\Models\RateDuration
     */
    protected function getModelFromOldRequest() : RateDuration
    {
        $duration = $this->durationRepository->getModel();

        // set duration info
        foreach (old('duration', []) as $key => $value) {
            $duration->setAttribute($key, $value);
        }

        // get descriptions
        foreach (old('descriptions', []) as $code => $value) {
            // get new model instance
            $description = $duration->descriptions()->getModel();
            $description->setAttribute('lang_code', $code);
            $description->setAttribute('content', $value);

            // append to collection
            $duration->descriptions->add($description);
        }

        return $duration;
    }
}
