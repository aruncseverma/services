<?php
/**
 *  Handles public/private files processing
 *
 *  @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\EscortAdmin\Controller;
use App\Repository\Concerns\InteractsWithEscortAssets;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PrivateFileController extends Controller
{
    use InteractsWithEscortAssets;

    /**
     *  Default constructor
     */
    public function __construct()
    {
        // $this->middleware('auth');
        parent::__construct();
    }

    /**
     *  Invokes the private file and fetches the original file
     *
     *  @param  string|null $path
     *
     *  @return Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function __invoke(?string $path = null) : BinaryFileResponse
    {
        if (! Storage::exists($path)) {
            abort(404);
        }

        return response()->file(Storage::path($path));
    }
}
