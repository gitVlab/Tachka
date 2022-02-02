<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;

abstract class BaseAction
{
    /**
     * @param ResponseFactory $responses
     */
    public function __construct(
        protected ResponseFactory $responses
    ) {}
}