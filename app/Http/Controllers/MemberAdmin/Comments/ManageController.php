<?php
namespace App\Http\Controllers\MemberAdmin\Comments;

use App\Http\Controllers\MemberAdmin\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Repository\CommentRepository;
use App\Models\Comment;

class ManageController extends Controller
{
    /**
     * Request Variable
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * Favorite Repository
     *
     * @var CommentRepository
     */
    protected $commentRepo;

    /**
     * Undocumented function
     *
     * @param Request               $request
     * @param CommentRepository    $favorite
     */
    public function __construct(Request $request, CommentRepository $commentRepo)
    {
        $this->request = $request;
        $this->commentRepo = $commentRepo;

        parent::__construct();
    }

    /**
     * renders the emails listing view
     *
     * @param  Illuminate\Http\Request
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index(Request $request): View
    {
        $this->setTitle(__('Comments'));

        $search = array_merge(
            [
                'limit' => $limit = 4,
            ],
            $request->query(),
            [
                'user_id' => $this->getAuthUser()->getKey(),
                'object_type' => Comment::ESCORT_TYPE,
                'with_data' => ['escort'],
            ]
        );

        $comments = $this->commentRepo->search($limit, $search);

        foreach ($comments as $key => $comment) {
            if ($comment->escort) {
                $comment->escort->setAttribute('profilePhotoUrl', $comment->escort->getProfileImage());
            }
        }

        return view('MemberAdmin::comments.manage', [
            'comments' => $comments,
        ]);
    }
}
