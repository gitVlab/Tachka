<?php

declare(strict_types=1);

namespace App\Services\Customer;

use App\Models\Customer;
use App\Models\CustomerProfile;
use Illuminate\Support\Facades\DB;

class CustomerFactory
{
    /**
     * @param array $props
     *
     * @return Customer
     *
     * @throws \RuntimeException
     */
    public function create(array $props): Customer
    {
        return match ($props['type']) {
            Customer::TYPE_DECLARANT => $this->declarant($props),
//            Customer::TYPE_RETAIL     => $this->retail($props),
        };
    }

    public function declarant(array $props)
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