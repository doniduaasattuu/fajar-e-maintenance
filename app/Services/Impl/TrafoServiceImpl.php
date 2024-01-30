<?php

namespace App\Services\Impl;

use App\Models\Trafo;
use App\Services\TrafoService;
use App\Traits\Utility;
use Illuminate\Database\Eloquent\Collection;

class TrafoServiceImpl implements TrafoService
{
    use Utility;
    public array $powerUnitEnum = ['VA', 'kVA', 'MVA'];

    public function getAll(): Collection
    {
        $trafos = Trafo::query()->get();
        return $trafos;
    }
}
