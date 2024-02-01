<?php

namespace App\Services\Impl;

use App\Models\Trafo;
use App\Repositories\TrafoRepository;
use App\Services\TrafoService;
use App\Traits\Utility;
use Illuminate\Database\Eloquent\Collection;

class TrafoServiceImpl implements TrafoService
{
    use Utility;
    public array $powerUnitEnum = ['VA', 'kVA', 'MVA'];
    public array $typeEnum = ['Step down', 'Step up'];
    public array $trafoStatusEnum = ['Online', 'Offline'];
    public array $cleanlinessEnum = ['Clean', 'Dirty'];
    public array $noiseEnum = ['Normal', 'Abnormal'];
    public array $silicaGelEnum = ['Dark blue', 'Light blue', 'Pink', 'Brown'];
    public array $earthingConnectionEnum = ['No loose', 'Loose'];
    public array $oilLeakageEnum = ['No leaks', 'Leaks'];
    public array $blowerConditionEnum = ['Good', 'Not good'];

    private TrafoRepository $trafoRepository;

    public function __construct(TrafoRepository $trafoRepository)
    {
        $this->trafoRepository = $trafoRepository;
    }

    public function getAll(): Collection
    {
        $trafos = Trafo::query()->get();
        return $trafos;
    }

    public function register(array $validated): bool
    {
        return $this->trafoRepository->insert($validated);
    }

    public function updateTrafo(array $validated): bool
    {
        return $this->trafoRepository->update($validated);
    }

    public function registeredTrafos(): array
    {
        $trafos_id = Trafo::query()->pluck('id');
        return $trafos_id->toArray();
    }

    public function registeredUniqueIds(): array
    {
        $uniqueIds = Trafo::query()->pluck('unique_id');
        return $uniqueIds->toArray();
    }

    public function registeredQrCodeLinks(): array
    {
        $qrCodeLinks = Trafo::query()->pluck('qr_code_link');
        return $qrCodeLinks->toArray();
    }

    public function installDismantle(string $dismantle, string $install): void
    {
        $trafo_dismantle = Trafo::query()->find($dismantle);
        $trafo_install = Trafo::query()->find($install);

        if ($trafo_dismantle->status == 'Installed' && $trafo_install->status == 'Available') {
            $trafo_install->status = $trafo_dismantle->status;
            $trafo_install->funcloc = $trafo_dismantle->funcloc;
            $trafo_install->sort_field = $trafo_dismantle->sort_field;
            $trafo_install->update();

            $trafo_dismantle->status = 'Repaired';
            $trafo_dismantle->funcloc = null;
            $trafo_dismantle->sort_field = null;
            $trafo_dismantle->update();
        }
    }
}
