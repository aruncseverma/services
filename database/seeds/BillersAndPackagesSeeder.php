<?php

use Illuminate\Database\Seeder;
use App\Repository\BillerRepository;
use App\Repository\PackageRepository;

class BillersAndPackagesSeeder extends Seeder
{

    /**
     * duration repository
     *
     * @var App\Repository\BillerRepository
     */
    protected $BillerRepository;

    /**
     * duration description repository
     *
     * @var App\Repository\PackageRepository
     */
    protected $PackageRepository;

    /**
     * create instance
     *
     * @param App\Repository\BillerRepository   $BillerRepository
     * @param App\Repository\PackageRepository $PackageRepository
     */
    public function __construct(BillerRepository $BillerRepository, PackageRepository $PackageRepository)
    {
        $this->BillerRepository = $BillerRepository;
        $this->PackageRepository = $PackageRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getBillers() as $key => $biller) {
            // create biller
            $biller['rank'] = $key + 1;
            $newBiller = $this->BillerRepository->save($biller);

            // create descriptions
            foreach ($this->getPackages() as $package) {
                $package['biller_id'] = $newBiller->id;
                $this->PackageRepository->save($package);
            }
        }
    }

    /**
     * get all billers
     *
     * @return array
     */
    protected function getBillers() : array
    {
        return [
            [
                'name' => 'Bank Wire',
                'logo' => 'payment-direct.jpg',
                'billnote' => '<div>Bank Name: <strong>Bank of the Philippine Islands</strong></div>
                <div>ABA Number: <strong>BPI-1001-123456</strong></div>
                <div>Account Name: <strong>Bloxmedia Inc.</strong></div>
                <div>Account Number: <strong>1902-123-987-123000</strong></div>
                <div>Order Number: <strong>10015</strong></div>',
                'is_active' => true,
            ],
            [
                'name' => 'Credit Card',
                'logo' => 'payment-cc.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Paypal',
                'logo' => 'payment-paypal.jpg',
                'billnote' => '<div>You have chosen to pay using Paypal</div>
                <div>You will be exiting our website and will be re-directed to Paypal\'s payment gateway</div>
                <div>Paying with paypal is <strong>Fast, Easy & Secure</strong></div>',
                'is_active' => true,
            ],
            [
                'name' => 'Western Union',
                'logo' => 'payment-wu.jpg',
                'billnote' => '<div>Bank Name: <strong>Arik Bloxmedia</strong></div>
                <div>Mobile Number: <strong>1234-567-890</strong></div>
                <div>Address: <strong>11f, Tower 2, The Insular Life, Makati, Philippines</strong></div>',
                'is_active' => true,
            ],
            [
                'name' => 'Dummy',
                'logo' => 'payment-dummy.jpg',
                'billnote' => 'Just a dummy biller, click confirm to add funds to your account.',
                'is_active' => true,
            ],
        ];
    }

    /**
     * get all packages
     *
     * @return array
     */
    protected function getPackages() : array
    {
        return [
            [
                'currency' => 'EUR',
                'credits' => 100,
                'discount' => 0,
                'price' => 100,
                'is_active' => true,
            ],
            [
                'currency' => 'EUR',
                'credits' => 200,
                'discount' => 5,
                'price' => 190,
                'is_active' => true,
            ],
            [
                'currency' => 'USD',
                'credits' => 100,
                'discount' => 0,
                'price' => 100,
                'is_active' => true,
            ],
            [
                'currency' => 'USD',
                'credits' => 200,
                'discount' => 5,
                'price' => 190,
                'is_active' => true,
            ],
        ];
    }
}
