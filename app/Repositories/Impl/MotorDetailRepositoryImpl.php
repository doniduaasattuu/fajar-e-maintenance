<?php

namespace App\Repositories\Impl;

use App\Models\MotorDetails;
use App\Repositories\MotorDetailRepository;
use Carbon\Carbon;

class MotorDetailRepositoryImpl implements MotorDetailRepository
{

    private function adjustment($motor_detail, $validated)
    {
        foreach ($validated as $key => $value) {
            $motor_detail->$key = $value;
        }
    }

    public function insert(array $validated): bool
    {
        $motor_detail = new MotorDetails();
        $this->adjustment($motor_detail, $validated);
        $motor_detail->created_at = Carbon::now()->toDateTimeString();
        $motor_detail->updated_at = Carbon::now()->toDateTimeString();
        return $motor_detail->save();
    }

    public function update(array $validated): bool
    {
        $motor_detail = MotorDetails::query()->where('motor_detail', '=', $validated['motor_detail'])->first();
        if (!is_null($motor_detail)) {
            $this->adjustment($motor_detail, $validated);
            return $motor_detail->update();
        } else {
            return $this->insert($validated);
        }
    }
}
