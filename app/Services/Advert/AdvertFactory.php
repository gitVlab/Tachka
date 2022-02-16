<?php

declare(strict_types=1);

namespace App\Services\Advert;

use App\Models\Advert;
use App\Models\Customer;
use App\Models\CustomerProfile;
use App\Services\GreatStartReward\GreatStartRewardFactory;
use App\Services\MonthlyCommissionPeriod\CustomerMonthlyPeriod;
use App\Services\Transport\TransportFactory;
use App\Services\WeeklyCommissionPeriod\CustomerWeeklyPeriod;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;

class AdvertFactory
{

    /**
     * @param TransportFactory $transportFactory
     */
    public function __construct(
        private TransportFactory $transportFactory,
    ) {}

    /**
     * @param array $props
     *
     * @return Customer
     *
     * @throws \RuntimeException
     */
    public function create(array $props): Customer
    {
        return match ($props['advert_category']) {
            Advert::TRANSPORT_CATEGORY => $this->transportFactory->transport($props),
            Advert::SPARES_CATEGORY => $this->declarant($props),
            Advert::TIRES_CATEGORY => $this->declarant($props),
        };
    }

    public function transport(array $props)
    {
        $customer = new Customer($props);
//        $customerProfile = new CustomerProfile($props);

        $this->save($customer);

        return $customer;
    }

    /**
     * @param Customer        $customer
     * @param CustomerProfile $customerProfile
     *
     * @throws \RuntimeException
     */
    private function save(Customer $customer): void
    {
        DB::transaction(static function() use ($customer) {
            if (! $customer->save()) {
                throw new \RuntimeException('Failed to create a customer.');
            }
        });
    }
}