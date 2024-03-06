@props(['equipment_name' => '', 'canvas_id' => ''])

<section class="mb-4">
    <h6 class="text-center text-secondary">{{ $canvas_id }} of {{ $equipment_name }}</h6>
    <div class="chart-container" style="position: relative; height: 300px">
        <canvas id="{{ strtolower(implode('_', explode(' ' ,$canvas_id))) }}"></canvas>
    </div>
</section>