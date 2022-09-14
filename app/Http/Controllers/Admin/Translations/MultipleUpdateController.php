<?php

namespace App\Http\Controllers\Admin\Translations;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class MultipleUpdateController extends Controller
{
    /**
     * handles incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request): RedirectResponse
    {
        $text = $request->input('text');
        if (!$text) {
            $this->notifyError(__('No data to update'));
            return back();
        }

        // save
        $affected = $this->saveTranslations($text);

        // redirect to next request
        if (!$affected) {
            $this->notifyError(__('Unable to save your request. Please try again sometime'));
        } else {
            $this->notifySuccess(__('Translations successfully updated.'));
        }

        return back();
    }

    /**
     * update translations to repository
     *
     * @param  array $texts
     *
     * @return int
     */
    protected function saveTranslations(array $texts)
    {
        $affected = 0;
        foreach($texts as $transId => $text) {
            $attributes = [
                'text' => $text,
            ];
            $translation = $this->repository->find($transId);
            if ($translation) {
                $res = $this->repository->store($attributes, $translation);
                if ($res) {
                    ++$affected;
                }
            }
            
        }

        return $affected;
    }
}
