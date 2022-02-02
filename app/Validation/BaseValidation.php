<?php

declare(strict_types=1);

namespace App\Validation;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

abstract class BaseValidation
{
    /** @var Validator  */
    protected ValidatorContract $validator;

    /** @var array */
    protected array $input = [];

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->input = $data;
        $this->validator = ValidatorFacade::make($data, $this->rules());
    }

    /**
     * @return array
     */
    abstract public function rules(): array;

    /**
     * Get default values to optional fields.
     *
     * @return array
     */
    public function defaults(): array
    {
        return [];
    }

    /**
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->validator->fails();
    }

    /**
     * Get data that passed validation.
     *
     * @return array
     */
    public function getValidated(): array
    {
        try {
            $validated = $this->validator->validated();
            $this->setDefaults($validated);
        } catch (ValidationException) {
            $validated = [];
        }

        return $validated;
    }

    /**
     * Set default values for optional fields.
     *
     * @param array $validated
     *
     * @return array
     */
    protected function setDefaults(array &$validated): array
    {
        foreach ($this->defaults() as $key => $value) {
            if (! isset($validated[$key])) {
                $validated[$key] = $value;
            }
        }

        return $validated;
    }

    /**
     * @return MessageBag
     */
    public function getErrorMessages(): MessageBag
    {
        return $this->validator->errors();
    }
}
