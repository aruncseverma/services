<?php
/**
 * save settings controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Http\RedirectResponse;

class SaveController extends Controller
{
    public function handle() : RedirectResponse
    {
        // checks group if present and filled
        if (! $this->request->has('group') || ! $this->request->filled('group')) {
            $this->notifyError(__('Settings group is not defined.'));
            return $this->redirectTo();
        }

        // get requested group
        $group = $this->request->input('group');

        // process fields
        $this->saveSettings($group);

        return $this->redirectTo();
    }

    /**
     * redirect to next request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo() : RedirectResponse
    {
        return redirect()->back();
    }

    /**
     * save settings information
     *
     * @param  string $group
     *
     * @return void
     */
    protected function saveSettings(string $group) : void
    {
        $fields = $this->request->only($group);

        // notifies that request has no data to be processed
        if (! isset($fields[$group])) {
            $this->notifyWarning(__('No data has been processed'));
            return;
        }

        // dd($this->repository->findSetting('site', 'is_maintenance'));

        foreach ($fields[$group] as $key => $value) {
            // get setting using group and key value
            $setting = $this->repository->findSetting($group, $key);

            // save updated/new settings
            $this->repository->save(['group' => $group, 'key' => $key, 'value' => $value], $setting);
        }

        // clear cache @todo must be constant
        app('cache')->forget('settings');

        $this->notifySuccess(__('Settings updated successfully'));
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware() : void
    {
        $this->middleware('can:general_settings.manage');
    }
}
