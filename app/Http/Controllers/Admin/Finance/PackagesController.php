<?php
/**
 * 
 */

namespace App\Http\Controllers\Admin\Finance;
use App\Repository\PackageRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * renders the form for the transactions in the admin backend site
 */
class PackagesController extends Controller
{
    /**
     * packages repository instance
     *
     * @var App\Repository\PackageRepository
     */
    protected $packages;

    /**
     * view site transactions form
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index(PackageRepository $packages) : View
    {
        $this->setTitle(__('Packages'));

        $limit = $this->getPageSize();
        $search = array_merge(
            [
                'limit' => $limit,
                'is_active' => '*',
                'biller' => '*',
                'currency' => '*'
            ],
            $this->request->query()
        );
        $packages = $packages->search($limit, $search);

        // create view
        return view('Admin::finance.packages', [
            'search' => $search,
            'packages' => $packages,
        ]);
    }

    /**
     * New package
     *
     * @return Illuminate\Contracts\View\View
     */
    public function new(PackageRepository $packages) : View
    {
        // get biller info
        $package = $packages->new();
        $package->is_active = 1;

        // create view instance
        return view('Admin::finance.editpackage', [
            'package' => $package,
        ]);
    }

    /**
     * edit package
     *
     * @return Illuminate\Contracts\View\View
     */
    public function edit(PackageRepository $packages) : View
    {
        // get biller info
        $package = $packages->find($this->request->get('id'));

        // create view instance
        return view('Admin::finance.editpackage', [
            'package' => $package,
        ]);
    }

    public function save(PackageRepository $packages) : RedirectResponse
    {
      $limit = $this->getPageSize();
      $search = array_merge(
          [
              'limit' => $limit,
              'is_active' => '*',
              'biller' => '*',
              'currency' => '*'
          ],
          $this->request->query()
      );

      $package = $packages->find($this->request->input('id'));

      $attributes = [
        'biller_id' => $this->request->input('biller'),
        'currency_id' => $this->request->input('currency'),
        'credits' => $this->request->input('credits'),
        'discount' => $this->request->input('discount'),
        'price' => $this->request->input('price'),
        'is_active' => $this->request->input('is_active'),
      ];

      // save to repository
      $packages->save($attributes, $package);

      return redirect()->route('admin.finance.packages', $search);
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
