<?php

declare(strict_types=1);

namespace App\Validation\Transport;

use App\Models\Transport;
use App\Validation\BaseValidation;
use Illuminate\Validation\Rule;

class CreateTransportValidation extends BaseValidation
{
    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'max:30'],
            'mark'    => ['required', 'string', 'max:30', Rule::in(Transport::MARKS),],
            'model'   => ['required', 'string', 'max:30'],
            'cost'     => ['required', 'integer',],
        ];
    }
}