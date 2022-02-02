<?php

declare(strict_types=1);

namespace App\Services\Transport;

use App\Models\Transport;

class TransportFactory
{
    /**
     *
     */
    public function __construct(
    ) {}

    public function create(int $userId, array $parameters): Transport
    {
        $transport = new Transport([
            'type' => $parameters['type'],
            'mark' => $parameters['type'],
            'model' => $parameters['type'],
            'cost' => $parameters['type'],
        ]);

        $transport->customer()->associate($userId);

        return $transport->id;
    }
}