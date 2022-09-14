<?php
/**
 * create note controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Notes;

use Illuminate\Http\RedirectResponse;
use App\Events\Admin\Notes\CreatingUserNotes;

class CreateController extends Controller
{
    /**
     * handles incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        // validate request first
        $this->validateRequest();

        $objectId = $this->request->input('object_id');

        // get previouse note
        $note = $this->repository->findNoteByObject($objectId);

        // save note
        $note = $this->repository->save(
            [
                'content' => $this->request->input('content'),
                'object_id' => $objectId,
                'user_id' => $this->getAuthUser()->getKey(), // @todo must be from authenticated user
            ],
            $note
        );

        /**
         * trigger event
         *
         * @param App\Models\UserNote
         */
        event(new CreatingUserNotes($note));

        $this->notifySuccess(__('Note added successfully'));

        return $this->redirectTo();
    }

    /**
     * validates incoming request
     *
     * @throws Illuminate\Validation\ValidationException
     *
     * @return void
     */
    protected function validateRequest() : void
    {
        $this->validate(
            $this->request,
            [
                'content'   => 'required|max:255',
                'object_id' => 'required',
            ]
        );
    }

    /**
     * redirects to next request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo() : RedirectResponse
    {
        return redirect()->back();
    }
}
