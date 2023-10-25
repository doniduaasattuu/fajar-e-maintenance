<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<body>

    @include("utility.navbar")

    <div class="container">

        <div class="my-5">

            <h4 class="mb-4">Summary of all checking data from each Paper Machine</h4>
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            PM1
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            PM2
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            PM3
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <h5>Top Five Temperature DE PM3</h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Funcloc</th>
                                        <th scope="col">Emo</th>
                                        <th scope="col">Temp</th>
                                        <th scope="col">Checked</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $temperature_a as $record )
                                    <tr>
                                        @foreach ($record as $key => $value)

                                        <!-- get id of funcloc -->
                                        @if ($key == "funcloc")
                                        @php
                                        $values = explode("-", $value)
                                        @endphp
                                        <td title="{{ $value }}">{{ $values[count($values) - 2] . '-' . $values[count($values) - 1] }}</td>
                                        @continue
                                        @endif

                                        <!-- add degree celcius -->
                                        @if ($key == "temperature_a")
                                        <td>{{ $value }}&deg;C</td>
                                        @continue
                                        @endif

                                        <!-- get date created_at -->
                                        @if ($key == "created_at")
                                        <td>{{ substr($value, 0, 10) }}</td>
                                        @continue
                                        @endif

                                        <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="accordion-body">
                            <h5>Top Five Temperature NDE PM3</h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Funcloc</th>
                                        <th scope="col">Emo</th>
                                        <th scope="col">Temp</th>
                                        <th scope="col">Checked</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $temperature_d as $record )
                                    <tr>
                                        @foreach ($record as $key => $value)

                                        <!-- get id of funcloc -->
                                        @if ($key == "funcloc")
                                        @php
                                        $values = explode("-", $value)
                                        @endphp
                                        <td title="{{ $value }}">{{ $values[count($values) - 2] . '-' . $values[count($values) - 1] }}</td>
                                        @continue
                                        @endif

                                        <!-- add degree celcius -->
                                        @if ($key == "temperature_d")
                                        <td>{{ $value }}&deg;C</td>
                                        @continue
                                        @endif

                                        <!-- get date created_at -->
                                        @if ($key == "created_at")
                                        <td>{{ substr($value, 0, 10) }}</td>
                                        @continue
                                        @endif

                                        <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="accordion-body">
                            <h5>Top Five Vibration DE PM3</h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Funcloc</th>
                                        <th scope="col">Emo</th>
                                        <th scope="col">Vibration</th>
                                        <th scope="col">Checked</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $vibration_value_de as $record )
                                    <tr>
                                        @foreach ($record as $key => $value)

                                        <!-- get id of funcloc -->
                                        @if ($key == "funcloc")
                                        @php
                                        $values = explode("-", $value)
                                        @endphp
                                        <td title="{{ $value }}">{{ $values[count($values) - 2] . '-' . $values[count($values) - 1] }}</td>
                                        @continue
                                        @endif

                                        <!-- add degree celcius -->
                                        @if ($key == "vibration_value_de")
                                        <td>{{ $value }} mm/s</td>
                                        @continue
                                        @endif

                                        <!-- get date created_at -->
                                        @if ($key == "created_at")
                                        <td>{{ substr($value, 0, 10) }}</td>
                                        @continue
                                        @endif

                                        <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="accordion-body">
                            <h5>Top Five Vibration NDE PM3</h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Funcloc</th>
                                        <th scope="col">Emo</th>
                                        <th scope="col">Vibration</th>
                                        <th scope="col">Checked</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $vibration_value_nde as $record )
                                    <tr>
                                        @foreach ($record as $key => $value)

                                        <!-- get id of funcloc -->
                                        @if ($key == "funcloc")
                                        @php
                                        $values = explode("-", $value)
                                        @endphp
                                        <td title="{{ $value }}">{{ $values[count($values) - 2] . '-' . $values[count($values) - 1] }}</td>
                                        @continue
                                        @endif

                                        <!-- add degree celcius -->
                                        @if ($key == "vibration_value_nde")
                                        <td>{{ $value }} mm/s</td>
                                        @continue
                                        @endif

                                        <!-- get date created_at -->
                                        @if ($key == "created_at")
                                        <td>{{ substr($value, 0, 10) }}</td>
                                        @continue
                                        @endif

                                        <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            PM5
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                            PM7
                        </button>
                    </h2>
                    <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                            PM8
                        </button>
                    </h2>
                    <div id="collapseEight" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>

</html>