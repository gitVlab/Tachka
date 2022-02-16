<?php

declare(strict_types=1);

namespace App\Http\Resources\Transport;

use Illuminate\Http\Resources\Json\JsonResource;

class TransportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Transport $this */
        return [
            'id' => $this->id,
            'type' => $this->type,
            'mark' => $this->mark,
            'model' => $this->model,
            'cost' => $this->cost,
            'transmission' => $this->transmission,
            'age' => $this->age,
            'engine_type' => $this->engine_type,
            'drive_type' => $this->drive_type,
        ];
    }
}