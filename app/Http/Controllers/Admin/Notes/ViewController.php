<?php
/**
 * view notes controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Notes;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Repository\UserNoteRepository;

class ViewController extends Controller
{
    /**
     * show view
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index() : View
    {
        $objectId = $this->request->get('object_id');

        // get all notes created
        $note = $this->repository->findNoteByObject($objectId);

        // create view and render it
        return view('Admin::notes.view', ['note' => $note]);
    }
}
