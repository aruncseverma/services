<?php
/**
 * 
 */

namespace App\Http\Controllers\Admin\Finance;
use App\Repository\BillerRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * renders the form for the transactions in the admin backend site
 */
class BillersController extends Controller
{
    /**
     * billers repository instance
     *
     * @var App\Repository\BillerRepository
     */
    protected $billers;

    /**
     * view site transactions form
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index(BillerRepository $billers) : View
    {
        $this->setTitle(__('Billers'));

        $limit = $this->getPageSize();
        $search = array_merge(
            [
                'limit' => $limit,
                'is_active' => '*',
                'name' => '',
            ],
            $this->request->query()
        );
        $billers = $billers->search($limit, $search);

        // create view
        return view('Admin::finance.billers', [
            'search'    => $search,
            'billers' => $billers,
        ]);
    }

    /**
     * New biller
     *
     * @return Illuminate\Contracts\View\View
     */
    public function new(BillerRepository $billers) : View
    {
        // get biller info
        $biller = $billers->new();

        // create view instance
        return view('Admin::finance.editbiller', [
            'biller' => $biller,
        ]);
    }

    /**
     * edit biller
     *
     * @return Illuminate\Contracts\View\View
     */
    public function edit(BillerRepository $billers) : View
    {
        // get biller info
        $biller = $billers->find($this->request->get('id'));

        // create view instance
        return view('Admin::finance.editbiller', [
            'biller' => $biller,
        ]);
    }

    public function save(BillerRepository $billers) : RedirectResponse
    {
      $limit = $this->getPageSize();
      $search = array_merge(
        [
            'limit' => $limit,
            'is_active' => '*',
            'name' => '',
        ],
        $this->request->query()
      );

      $biller = $billers->find($this->request->input('id'));

      $attributes = [
        'name' => $this->request->input('name'),
        'logo' => $this->request->input('logo'),
        'rank' => $this->request->input('rank'),
        'is_active' => $this->request->input('is_active'),
      ];

      if ($this->request->filled('adminurl')) $attributes['adminurl'] = $this->request->input('adminurl');
      else $attributes['adminurl'] = Null;
      if ($this->request->filled('apiurl')) $attributes['apiurl'] = $this->request->input('apiurl');
      else $attributes['apiurl'] = Null;
      if ($this->request->filled('supported')) $attributes['supported'] = $this->request->input('supported');
      else $attributes['supported'] = Null;
      if ($this->request->filled('apiuser')) $attributes['apiuser'] = $this->request->input('apiuser');
      else $attributes['apiuser'] = Null;
      if ($this->request->filled('apipass')) $attributes['apipass'] = $this->request->input('apipass');
      else $attributes['apipass'] = Null;
      if ($this->request->filled('apikey1')) $attributes['apikey1'] = $this->request->input('apikey1');
      else $attributes['apikey1'] = Null;
      if ($this->request->filled('apikey2')) $attributes['apikey2'] = $this->request->input('apikey2');
      else $attributes['apikey2'] = Null;
      if ($this->request->filled('billnote')) $attributes['billnote'] = $this->request->input('billnote');
      else $attributes['billnote'] = Null;

      // save to repository
      $billers->save($attributes, $biller);

      return redirect()->route('admin.finance.billers', $search);
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
