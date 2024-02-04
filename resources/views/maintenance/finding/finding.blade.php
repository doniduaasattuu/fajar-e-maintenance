@include('utility.prefix')

<div class="py-4">

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

        @foreach ($findings as $finding)
        <div class="col">
            <div class="card shadow shadow-lg">
                <div>
                    <a href="{{ null != $finding->image ? '/storage/findings/' . $finding->image : '/storage/assets/images/finding-default.png' }}">
                        <img class="card-img-top p-1 rounded" style="height: 300px; object-fit: cover;" src="{{ null != $finding->image ? '/storage/findings/' . $finding->image : '/storage/assets/images/finding-default.png' }}" alt="...">
                    </a>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="card-title">{{ $finding->area ?? '' }}</h5>
                        <p class="card-text">{{ $finding->description ?? '' }}</p>
                    </div>
                    <div>

                        @foreach ($findingService->getColumns('findings', ['id', 'area', 'description', 'image', 'updated_at']) as $column)
                        @switch($column)
                        @case('status')
                        <div class="row mb-2">
                            <div class="col-6 mb-0 fw-semibold">{{ ucfirst($column) }}</div>
                            <div class="col-6 mb-0">
                                <select class="form-control" name="{{ $column }}" id="{{ $column }}">
                                    <option value="Open">Open</option>
                                    <option value="Close">Close</option>
                                </select>
                            </div>
                        </div>
                        @break

                        @default
                        <div class="row mb-2">
                            <div class="col-6 mb-0 fw-semibold">{{ ucfirst($column == 'created_at' ? 'Date' : $column) }}</div>
                            <div class="col-6 mb-0">{{ $column == 'created_at' ? $findingService->formatDDMMYY($finding->$column) : $finding->$column }}</div>
                        </div>
                        @endswitch
                        @endforeach

                    </div>

                    <div class="row">
                        <div class="w-100">
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                        <div class="w-100">
                            <a href="#" class="btn btn-danger">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>

</div>

@include('utility.suffix')