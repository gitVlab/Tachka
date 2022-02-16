<?php

declare(strict_types=1);

namespace App\Http\Filters\Transport;

use App\Http\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class TransportFilter extends QueryFilter
{
    /**
     * @param string $type
     */
    public function type(string $type)
    {
        $this->builder->where('type', strtolower($type));
    }

    /**
     * @param string $mark
     */
    public function mark(string $mark)
    {
        $this->builder->where('mark', strtolower($mark));
    }

    /**
     * @param string $model
     */
    public function model(string $model)
    {
        $this->builder->where('model', strtolower($model));
    }

    /**
     * @param string $transmission
     */
    public function transmission(string $transmission)
    {
        $this->builder->where('transmission', strtolower($transmission));
    }

    /**
     * @param string $driveType
     */
    public function driveType(string $driveType)
    {
        $this->builder->where('drive_type', strtolower($driveType));
    }

    /**
     * @param string $engineType
     */
    public function engineType(string $engineType)
    {
        $this->builder->where('engine_type', strtolower($engineType));
    }

    /**
     * @param string $age
     */
    public function age(string $age)
    {
        $this->builder->where('age', strtolower($age));
    }

    /**
     * @param string $costFrom
     */
    public function costFrom(string $costFrom)
    {
        $this->builder->where('cost','>=', $costFrom);
    }

    /**
     * @param string $costTo
     */
    public function costTo(string $costTo)
    {
        $this->builder->where('cost','<=', $costTo);
    }


    protected function ageFrom(string $ageFrom): void
    {
        $this->builder->where('age', '>=', $ageFrom);
    }

    protected function ageTo(string $ageTo): void
    {
        $this->builder->where('age', '<=', $ageTo);
    }

//    /**
//     * @param string $mark
//     */
//    public function mark(string $mark)
//    {
//        $words = array_filter(explode(' ', $mark));
//
//        $this->builder->where(function (Builder $query) use ($words) {
//            foreach ($words as $word) {
//                $query->where('mark', 'like', "%$word%");
//            }
//        });
//    }
}