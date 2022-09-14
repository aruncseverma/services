<?php
/**
 * view composer class form sidebar template
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Sidebar;

use Illuminate\Http\Request;
use Illuminate\Config\Repository;
use Illuminate\Contracts\View\View;
use App\Repository\UserEmailRepository;
use Illuminate\Contracts\Auth\Access\Gate;
use App\Support\Concerns\InteractsWithAuth;
use Illuminate\Auth\Access\AuthorizationException;

class SidebarViewComposer
{
    use InteractsWithAuth;

    /**
     * repository instance
     *
     * @var Illuminate\Config\Repository
     */
    protected $repository;

    /**
     * laravel request instance
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * create laravel gate instance
     *
     * @var Illuminate\Contracts\Auth\Access\Gate
     */
    protected $gate;

    /**
     * create instance
     *
     * @param Illuminate\Config\Repository          $repository
     * @param Illuminate\Http\Request               $request
     * @param Illuminate\Contracts\Auth\Access\Gate $gate
     */
    public function __construct(Repository $repository, Request $request, Gate $gate = null)
    {
        $this->repository = $repository;
        $this->request = $request;
        $this->gate = $gate;
    }

    /**
     * compose view parameters to view
     *
     * @param  Illuminate\Contracts\View\View $view
     *
     * @return void
     */
    public function compose(View $view) : void
    {
        $menus = [];
        foreach ($this->loadMenus($view->offsetGet('from')) as $key => $menu) {
            $menus[$key] = $this->createMenuObject($menu);
        }

        $view->with('menus', $menus);
        $view->with('user', $this->getAuthUser());
        $view->with('newEmailsCount', $this->getNewUnreadEmails());
        $view->with('notifications', $this->getNotifications());
    }

    /**
     * normalize menu options
     *
     * @param  array $menu
     *
     * @return array
     */
    protected function normalizeMenu($menu) : array
    {
        return array_merge(
            [
                'path'     => '#',
                'text'     => '',
                'icon'     => '',
                'children' => []

            ],
            $menu
        );
    }

    /**
     * create menu object
     *
     * @param  array $menu
     *
     * @return App\Support\Sidebar\Menu
     */
    protected function createMenuObject(array $menu) : Menu
    {
        // merege defaults
        $menu = $this->normalizeMenu($menu);
        $hasPermission = true;
        $hasBadge = false;
        $badge = null;

        // process children
        if (! empty($menu['children'])) {
            foreach ($menu['children'] as $key => $sub) {
                $children = $this->createMenuObject($sub);

                // check if current children has permission
                if ($children->hasPermission()) {
                    $menu['children'][$key] = $children;
                } else {
                    unset($menu['children'][$key]);
                }
            }

            // if no menu has been set then do not show parent menu
            if (empty($menu['children'])) {
                $hasPermission = false;
            }
        }

        // create menu link
        if (isset($menu['route'])) {
            $menu['route'] = (! is_array($menu['route'])) ? [$menu['route']] : $menu['route'];
            $link = call_user_func_array('route', $menu['route']);
        } elseif (isset($menu['path'])) {
            $link = $menu['path'];
        }

        if (isset($menu['badge'])) {
            $hasBadge = true;
            $badge = $menu['badge'];
        }

        if (isset($menu['permissions'])) {
            try {
                $this->gate->authorize($menu['permissions']);
            } catch (AuthorizationException $ex) {
                $hasPermission = false;
            }
        }

        // checks if current request url is this link
        $isActive = $this->isMenuActiveLink($link);

        return new Menu($menu['text'], $link, $menu['icon'], $badge, $menu['children'], $isActive, $hasBadge, $hasPermission);
    }

    /**
     * load menus from repository
     *
     * @param  string $from
     *
     * @return array
     */
    protected function loadMenus(string $from) : array
    {
        return $this->repository->get("sidebar.{$from}", []);
    }

    /**
     * checks if current menu is active
     *
     * @param  string $link
     *
     * @return boolean
     */
    protected function isMenuActiveLink(string $link) : bool
    {
        // parse link
        $path = parse_url($link, PHP_URL_PATH);

        // check request path
        return (! empty($path)) ? $this->request->is(trim($path, '/')) : false;
    }

    /**
     * retrieves all unread emails count
     *
     * @return void
     */
    protected function getNewUnreadEmails() : int
    {
        $emails = app(UserEmailRepository::class);
        return $emails->getAllUnreadEmails($this->getAuthUser()->getKey());
    }

    /**
     * fetches event list per user type
     *
     * @param string $type
     * @return array
     */
    private function getEvents($type) : array
    {
        $events = [];

        switch($type) {
            case 'A':
                return [
                    'manage_profile_validations' => 'NewValidation',
                    'manage' => 'NewMember',
                    'manage_pending' => 'NewEscort',
                    'credits' => 'NewPurchase',
                    'purchases' => 'NewVIPRequest',
                    'manage_pending_agency' => 'NewAgency'
                ];

            case 'E':
                return [
                    'reviews' => 'NewReview',
                    'email' => 'NewEmail'
                ];

            case 'G':
                return [];

            default:
                return [];
        }
    }

    /**
     * fetches notifications for user
     *
     * @return array
     */
    protected function getNotifications() : array
    {
        $user = $this->getAuthUser();
        $events = $this->getEvents($user->type);
        $notifications = [];

        foreach($this->getAuthUser()->unreadNotifications as $notification) {
            foreach($events as $k => $v) {
                if (strpos($notification->type, $v)) {
                    if (isset($notifications[$k])) {
                        $notifications[$k] += 1;
                    } else {
                        $notifications[$k] = 1;
                    }
                }
            }
        }

        if (array_key_exists('manage_profile_validations', $notifications)) {
            if (!isset($notifications['escorts'])) $notifications['escorts'] = 0;
            $notifications['escorts'] += $notifications['manage_profile_validations'];
        }

        if (array_key_exists('manage_pending', $notifications)) {
            if (!isset($notifications['escorts'])) $notifications['escorts'] = 0;
            $notifications['escorts'] += $notifications['manage_pending'];
        }

        if (array_key_exists('manage_pending_agency', $notifications)) {
            if (!isset($notifications['agency'])) $notifications['agency'] = 0;
            $notifications['agency'] += $notifications['manage_pending_agency'];
        }

        return $notifications;
    }
}
