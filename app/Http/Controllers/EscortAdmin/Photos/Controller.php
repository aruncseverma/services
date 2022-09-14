<?php
/**
 *  base controller for escort admin's photo namespace
 *
 *  @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\EscortAdmin\Photos;

use Illuminate\Http\Request;
use App\Repository\PhotoRepository;
use App\Repository\FolderRepository;
use App\Http\Controllers\EscortAdmin\Controller as EscortController;
use App\Models\UserActivity;

abstract class Controller extends EscortController
{
    /**
     * default user activity type
     *
     * @const
     */
    const ACTIVITY_TYPE = UserActivity::PHOTO_TYPE;

    /**
     *  Request variable
     *
     * @var Illuminate\Http\Request;
     */
    protected $request;

    /**
     * Folder Repository variable
     *
     * @var App\Repository\FolderRepository
     */
    protected $folderRepository;

    /**
     * Photo Repository variable
     *
     * @var App\Repository\PhotoRepository
     */
    protected $photoRepository;

    /**
     * Initialize Controller
     *
     * @param Illuminate\Http\Request $httpRequest
     * @param App\Repository\FolderRepository $folders
     * @param App\Repository\PhotoRepository $photos
     */
    public function __construct(Request $httpRequest, FolderRepository $folders, PhotoRepository $photos)
    {
        $this->request = $httpRequest;
        $this->photoRepository = $photos;
        $this->folderRepository = $folders;

        parent::__construct();
    }
}
