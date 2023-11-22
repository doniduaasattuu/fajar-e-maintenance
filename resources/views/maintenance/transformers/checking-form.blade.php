<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<style>
    #copy_text:hover {
        cursor: pointer;
    }
</style>

<body>
    @include("utility.navbar")

    <div class="container mt-4 my-5">

        <!-- FAILED POST ALERT START -->
        <div class="alert alert-danger shadow" style="display: none" id="alert_response" role="alert">
            Error occurred! ⚠️
        </div>
        <!-- FAILED POST ALERT END -->

        <!-- SUCCESS POST ALERT START -->
        <div class="alert alert-success shadow" style="display: none" id="message_response" role="alert">
            Success! ✅
        </div>
        <!-- SUCCESS POST ALERT END -->

        <!-- TEMPERATURE ALERT START -->
        <div class="modal fade" id="temperature_alert" tabindex="-1" aria-labelledby="temperature_alertLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="bg-light modal-header">
                        <h1 class=" modal-title fs-5" id="temperature_alertLabel">Invalid input ⚠️</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Temperature should not exceed 200&deg;C!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- TEMPERATURE ALERT END -->

        <!-- VIBRATION ALERT START -->
        <div class="modal fade" id="vibration_alert" tabindex="-1" aria-labelledby="vibration_alertLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="bg-light modal-header">
                        <h1 class=" modal-title fs-5" id="vibration_alertLabel">Invalid input ⚠️</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Vibration should not exceed 45 mm/s!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- VIBRATION ALERT END -->

        <!-- TRANSFORMER ID AND TRENDS START  -->
        <div>
            <h5 id="equipment_description" class="text-break mb-0">{{ $transformer->equipment_description }}</h5>
            <p id="sort_field_information" class="lh-sm mb-0 text-secondary">{{ $transformer->sort_field }}</p>
            <p id="funcloc_information" class="lh-sm mb-0 text-secondary">{{ $transformer->funcloc }}</p>
            <p id="transformer_information" class="lh-sm mb-3 text-secondary">{{ $transformer->id }}</p>
        </div>

        <form action="/sortfield-trends" method="post">
            @csrf
            <input type="hidden" id="sort_field" name="sort_field" value="{{ $transformer->sort_field }}">
            <input type="hidden" id="funcloc" name="funcloc" value="{{ $transformer->funcloc }}">
            <button class="btn btn-success fw-bold mb-2 text-white">
                <svg class="mb-1 me-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z" />
                </svg>
                TRENDS
            </button>

        </form>
        <!-- TRANSFORMER ID AND TRENDS END -->

        <!-- TRANSFORMER DETAILS START -->
        <div class="accordion mb-4" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="bg-primary text-white accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-view-list" viewBox="0 0 16 16">
                            <path d="M3 4.5h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1H3zM1 2a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 2zm0 12a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 14z" />
                        </svg>
                        <strong class="ms-2">TRANSFORMER DETAILS</strong>
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <table class="table table-hover">
                            <tbody>
                                <!-- FUNCLOC -->
                                <tr class="d-none" id="transformer_function_location">
                                    <th>Function Location</th>
                                    <td>{{ $transformer->funcloc }}</td>
                                </tr>
                                <!-- SORT FIELD -->
                                <tr class="d-none" id="transformer_sort_field">
                                    <th>Sort field</th>
                                    <td>{{ $transformer->sort_field }}</td>
                                </tr>
                                <!-- STATUS -->
                                <tr>
                                    <th>Status</th>
                                    <td id="status">{{ $transformer->status }}</td>
                                </tr>
                                <!-- UPDATED AT -->
                                <tr>
                                    <th>Updated at</th>
                                    <td>{{ $transformer->updated_at }}</td>
                                </tr>
                                <!-- EQUIPMENT DESCRIPTION -->
                                <tr>
                                    <th>Equipment Description</th>
                                    <td class="text-break">{{ $transformer->equipment_description }}</td>
                                </tr>
                                <!-- MATERIAL NUMBER -->
                                <tr>
                                    <th>Material number</th>
                                    <td>{{ $transformer->material_number }}</td>
                                </tr>
                                @foreach ($transformerDetail as $key => $value)
                                <tr>
                                    <th scope="row">{{ str_replace("_", " ", ucwords($key)) }}</th>
                                    <td id="{{ $key }}">{{ $value  }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- TRANSFORMER DETAILS END -->

    </div>

</body>

</html>