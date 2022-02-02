<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

interface TransportInterface
{
    public function createTransport(Model $instance): Model;
}