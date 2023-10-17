<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <title>Document</title>
</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-4">FORM CHECKING MOTOR</h2>
        @isset($error)
        <div class="alert alert-danger" role="alert">
            {{ $error }}
        </div>
        @endisset
        <form action="/checking-motor" method="post">
            @csrf
            <div class="mb-3 row">
                <div class="col">
                    <select name="motor_status" class="form-select mb-3" aria-label="Default select example">
                        <option value="">--Motor Status--</option>
                        <option value="Running">Running</option>
                        <option value="Not Running">Not Running</option>
                    </select>
                    <select name="clean_status" class="form-select mb-3" aria-label="Default select example">
                        <option value="">--Cleanliness--</option>
                        <option value="Clean">Clean</option>
                        <option value="Dirty">Dirty</option>
                    </select>
                    <select name="nipple_grease" class="form-select mb-3" aria-label="Default select example">
                        <option value="">--Nipple Grease--</option>
                        <option value="Available">Available</option>
                        <option value="Not Available">Not Available</option>
                    </select>
                    <div class="mb-3">
                        <label for="temperature_a" class="form-label">Temperature A</label>
                        <input type="number" class="form-control" name="temperature_a" id="temperature_a">
                    </div>
                    <div class="mb-3">
                        <label for="temperature_b" class="form-label">Temperature B</label>
                        <input type="number" class="form-control" name="temperature_b" id="temperature_b">
                    </div>
                    <div class="mb-3">
                        <label for="temperature_c" class="form-label">Temperature C</label>
                        <input type="number" class="form-control" name="temperature_c" id="temperature_c">
                    </div>
                    <div class="mb-3">
                        <label for="temperature_d" class="form-label">Temperature D</label>
                        <input type="number" class="form-control" name="temperature_d" id="temperature_d">
                    </div>
                    <select name="vibration_de" class="form-select mb-3" aria-label="Default select example">
                        <option value="">--Vibration DE--</option>
                        <option value="Normal">Normal</option>
                        <option value="Abormal">Abormal</option>
                    </select>
                    <select name="vibration_nde" class="form-select mb-3" aria-label="Default select example">
                        <option value="">--Vibration NDE--</option>
                        <option value="Normal">Normal</option>
                        <option value="Abormal">Abormal</option>
                    </select>
                    <div class="mb-3">
                        <label for="current_phase_r" class="form-label">Current Phase R</label>
                        <input type="number" class="form-control" name="current_phase_r" id="current_phase_r">
                    </div>
                    <div class="mb-3">
                        <label for="current_phase_s" class="form-label">Current Phase S</label>
                        <input type="number" class="form-control" name="current_phase_s" id="current_phase_s">
                    </div>
                    <div class="mb-3">
                        <label for="current_phase_t" class="form-label">Current Phase T</label>
                        <input type="number" class="form-control" name="current_phase_t" id="current_phase_t">
                    </div>
                    <div class="mt-3 mb-3">
                        <label for="number_of_greasing" class="form-label">Number of Greasing</label>
                        <input type="number" class="form-control" name="number_of_greasing" id="number_of_greasing">
                    </div>
                    <div class="mb-4">
                        <input class="btn btn-primary" type="submit" value="Submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>