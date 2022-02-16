<?php

declare(strict_types=1);

namespace App\Services\Transport;

use App\Models\Transport;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransportFactory
{
    /**
     *
     */
    public function __construct(
    ) {}

    public function create(User $user, array $parameters): Transport
    {
        $transport = new Transport([
            'type' => $parameters['type'],
            'mark' => $parameters['mark'],
            'model' => $parameters['model'],
            'cost' => $parameters['cost'],
            'transmission' => $parameters['transmission'],
            'age' => $parameters['age'],
            'engine_type' => $parameters['engine_type'],
            'drive_type' => $parameters['drive_type'],
        ]);

        $transport->customer()->associate($user);
        $this->save($transport);

        return $transport;
    }

    private function save(Transport $transport): void
    {
        DB::transaction(static function() use ($transport) {
            if (! $transport->save()) {
                throw new \RuntimeException('Failed to create a transport.');
            }
        });
    }
}