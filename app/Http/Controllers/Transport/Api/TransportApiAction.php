<?php

declare(strict_types=1);

namespace App\Http\Controllers\Transport\Api;

use App\Http\Controllers\BaseAction;
use App\Http\Filters\Transport\TransportFilter;
use App\Http\Resources\Transport\TransportResource;
use App\Models\Transport;

class TransportApiAction extends BaseAction
{
    public function __invoke(TransportFilter $filter)
    {
        $transport = Transport::filter($filter)->limit(10)->get();

        return TransportResource::collection($transport);
    }
}