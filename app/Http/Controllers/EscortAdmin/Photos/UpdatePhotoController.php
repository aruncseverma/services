<?php
/**
 * Handles any photo manipulation
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\EscortAdmin\Photos;

use Illuminate\Http\Request;
use App\Repository\PhotoRepository;
use Illuminate\Support\Facades\Auth;

class UpdatePhotoController extends Controller
{
    /**
     *  Changes the escort's primary photo
     *
     *  @param String $photoId
     *  @return int
     */
    public function changePrimary($photoId) : int
    {
        $this->photoRepository->resetPrimaryStatus($this->getAuthUser()->getKey());
        $query = $this->photoRepository->setAsPrimary($photoId);
        
        return $query;
    }
}
