<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<body>

    @include("utility.navbar")

    <div class="container">


        <div class="form-group row">
            <label class="col-form-label text-right col-lg-3 col-sm-12">Valid State</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
                <div class="input-group date" id="kt_datetimepicker_12" data-target-input="nearest">
                    <input type="text" class="form-control is-valid datetimepicker-input" placeholder="Select date & time" data-target="#kt_datetimepicker_12" />
                    <div class="input-group-append" data-target="#kt_datetimepicker_12" data-toggle="datetimepicker">
                        <span class="input-group-text">
                            <i class="ki ki-calendar"></i>
                        </span>
                    </div>
                    <div class="valid-feedback">
                        Success! You"ve done it.
                    </div>
                </div>
                <span class="form-text text-muted">Example help text that remains unchanged.</span>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label text-right col-lg-3 col-sm-12">Invalid State</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
                <div class="input-group date" id="kt_datetimepicker_13" data-target-input="nearest">
                    <input type="text" class="form-control is-invalid datetimepicker-input" placeholder="Select date & time" data-target="#kt_datetimepicker_13" />
                    <div class="input-group-append" data-target="#kt_datetimepicker_12" data-toggle="datetimepicker">
                        <span class="input-group-text">
                            <i class="ki ki-calendar"></i>
                        </span>
                    </div>
                    <div class="invalid-feedback">
                        Sorry, the date is taken. Try another date?
                    </div>
                </div>
                <span class="form-text text-muted">Example help text that remains unchanged.</span>
            </div>
        </div>


    </div>

</body>

</html>