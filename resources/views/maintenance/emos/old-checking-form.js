const nipple_grease = document.getElementById("nipple_grease");
const number_of_greasing = document.getElementById("number_of_greasing");
const temperatures_input = document.getElementsByClassName("temperature_input");
const noises = document.getElementsByClassName("noises");
const alert_response = document.getElementById("alert_response");
const message_response = document.getElementById("message_response");
const myform = document.getElementById("myform");
const ajax = new XMLHttpRequest();

// AJAX START
let buttonSubmit = document.getElementById("buttonsubmit");
buttonSubmit.onclick = () => {
    let myArray = {
        funcloc: "{{ $emo->funcloc }}",
        emo: "{{ $emo->id }}",
        sort_field: "{{ $emo->sort_field }}",
        equipment_id: "{{ $equipment_id }}",
    };
    // console.info(myform);
    for (let input of myform) {
        // console.info(`${key}: ${value}`);
        if (`${input.name}` == "_token") {
            continue;
        } else if (`${input.value}` == "Submit") {
            continue;
        } else {
            // console.info(`${input.name}: ${input.value}`);
            // myArray.push(`${input.name}: ${input.value}`);
            myArray[`${input.name}`] = `${input.value}`;
        }
    }
    console.table(myArray);

    ajax.open("POST", "/checking-form/{{ $equipment_id }}");
    ajax.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
    // ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.setRequestHeader("Content-Type", "application/json");
    ajax.onload = () => {
        if (ajax.readyState == 4) {
            // console.info(ajax.responseText);

            // response from server is format json
            let response_object = JSON.parse(ajax.responseText);
            // console.info(response_object);

            if (response_object.error?.errorInfo == undefined) {
                // if have object have error will display error message
                if (response_object.hasOwnProperty("error")) {
                    alert_response.textContent = response_object.error;
                    message_response.style.display = "none";
                    alert_response.style.display = "block";
                    document.documentElement.scrollTop = 0;
                } else {
                    // will display response message success
                    message_response.textContent = response_object.message;
                    alert_response.style.display = "none";
                    message_response.style.display = "block";
                    document.documentElement.scrollTop = 0;
                }
            } else {
                alert_response.textContent =
                    response_object.error.connectionName +
                    "Error: " +
                    response_object.error.errorInfo[2];
                message_response.style.display = "none";
                alert_response.style.display = "block";
                document.documentElement.scrollTop = 0;
            }
        }
    };

    ajax.send(JSON.stringify(myArray));
};
// AJAX END

let jsonku = {
    nama: "Doni",
    kelas: "19.3B.24",
};

// VIBRATION VALUE ALERT VALIDATION AND STATUS START
const vibration_values = document.getElementsByClassName("vibration_value");
const vibrations = document.getElementsByClassName("vibration");
const motor_class = document.getElementById("motor_class");
const vibrations_label = document.getElementsByClassName("vibrations_label");
const figcaption_vibration = document.getElementById("figcaption_vibration");
const comment = document.getElementById("comment");

// GOOD
function vibrationGood(element) {
    element.value = "Good";
    element.classList.remove("text-dark");
    element.classList.remove("bg-info");
    element.classList.remove("bg-warning");
    element.classList.remove("bg-danger");
    element.classList.add("bg-success");
    element.classList.add("text-white");
}

// SATISACTORY
function vibrationSatisfactory(element) {
    element.value = "Satisfactory";
    element.classList.remove("text-white");
    element.classList.remove("bg-success");
    element.classList.remove("bg-warning");
    element.classList.remove("bg-danger");
    element.classList.add("bg-info");
    element.classList.add("text-dark");
}

// UNSATISFACTORY
function vibrationUnsatisfactory(element) {
    element.value = "Unsatisfactory";
    element.classList.remove("text-white");
    element.classList.remove("bg-success");
    element.classList.remove("bg-info");
    element.classList.remove("bg-danger");
    element.classList.add("bg-warning");
    element.classList.add("text-dark");
}

// UNACCEPTABLE
function vibrationUnacceptable(element) {
    element.value = "Unacceptable";
    element.classList.remove("text-dark");
    element.classList.remove("bg-success");
    element.classList.remove("bg-warning");
    element.classList.remove("bg-info");
    element.classList.add("bg-danger");
    element.classList.add("text-white");
}

// NORMALIZE COLOR
function normalizeInput(element) {
    element.value = "";
    element.classList.remove("text-white");
    element.classList.remove("bg-success");
    element.classList.remove("bg-warning");
    element.classList.remove("bg-info");
    element.classList.remove("bg-danger");
}

for (let i = 0; i < vibration_values.length; i++) {
    vibration_values[i].onchange = () => {
        if (vibration_values[i].value > 45 || vibration_values[i].value < 0) {
            let vibrationModal = new bootstrap.Modal(
                document.getElementById("vibration_alert"),
                {}
            );
            vibrationModal.show();
            vibration_values[i].value = "0.01";
        }

        if (vibration_values[i].value == "") {
            normalizeInput(vibrations[i]);
        }

        motor_power_rate = power_rate.textContent.split(" ")[0].split("/")[0]; // MOTOR WHO HAVE 2 WINDINGS
        motor_power_unit = power_unit.textContent == "kW" ? "kW" : "HP";

        if (motor_power_unit == "HP") {
            motor_power_rate = Math.floor(motor_power_rate * 0.7457);
        }

        if (motor_power_rate <= 15) {
            // MOTOR CLASS 1 == UNDER 15kW
            figcaption_vibration.textContent =
                "Vibration standard " + `(${motor_power_rate}kW` + "/Class 1)";

            if (
                vibration_values[i].value >= 0.01 &&
                vibration_values[i].value <= 0.71
            ) {
                // GOOD
                vibrationGood(vibrations[i]);
            } else if (
                vibration_values[i].value > 0.71 &&
                vibration_values[i].value <= 1.8
            ) {
                // SATISFACTORY
                vibrationSatisfactory(vibrations[i]);
            } else if (
                vibration_values[i].value > 1.8 &&
                vibration_values[i].value <= 4.5
            ) {
                // UNSATISFACTORY
                vibrationUnsatisfactory(vibrations[i]);
            } else if (
                vibration_values[i].value > 4.5 &&
                vibration_values[i].value <= 45
            ) {
                // UNACCEPTABLE
                vibrationUnacceptable(vibrations[i]);
            }
        } else if (motor_power_rate < 300) {
            // MOTOR CLASS 2 == MORE THAN 15kW UNDER 300k
            figcaption_vibration.textContent =
                "Vibration standard " + `(${motor_power_rate}kW` + "/Class 2)";

            if (
                vibration_values[i].value >= 0.01 &&
                vibration_values[i].value <= 1.12
            ) {
                // GOOD
                vibrationGood(vibrations[i]);
            } else if (
                vibration_values[i].value > 1.12 &&
                vibration_values[i].value <= 2.8
            ) {
                // SATISFACTORY
                vibrationSatisfactory(vibrations[i]);
            } else if (
                vibration_values[i].value > 2.8 &&
                vibration_values[i].value <= 7.1
            ) {
                // UNSATISFACTORY
                vibrationUnsatisfactory(vibrations[i]);
            } else if (
                vibration_values[i].value > 7.1 &&
                vibration_values[i].value <= 45
            ) {
                // UNACCEPTABLE
                vibrationUnacceptable(vibrations[i]);
            }
        } else {
            // MOTOR CLASS 3 == MORE THAN 300kW
            figcaption_vibration.textContent =
                "Vibration standard " +
                `(${motor_power_rate}kW` +
                "/>=Class 3)";

            if (
                vibration_values[i].value >= 0.01 &&
                vibration_values[i].value <= 1.8
            ) {
                // GOOD
                vibrationGood(vibrations[i]);
            } else if (
                vibration_values[i].value > 1.8 &&
                vibration_values[i].value <= 4.5
            ) {
                // SATISFACTORY
                vibrationSatisfactory(vibrations[i]);
            } else if (
                vibration_values[i].value > 4.5 &&
                vibration_values[i].value <= 11.2
            ) {
                // UNSATISFACTORY
                vibrationUnsatisfactory(vibrations[i]);
            } else if (
                vibration_values[i].value > 11.2 &&
                vibration_values[i].value <= 45
            ) {
                // UNACCEPTABLE
                vibrationUnacceptable(vibrations[i]);
            }
        }
    };
}

// ENABLED INPUT NUMBER OF GREASING
nipple_grease.onchange = () => {
    if (nipple_grease.value == "Available") {
        number_of_greasing.removeAttribute("disabled");
    } else {
        number_of_greasing.value = "";
        number_of_greasing.setAttribute("disabled", true);
    }
};

// ENABLED TEMPERATURE AND VIBRATION VALUE AND NOISES
motor_status.onchange = () => {
    // MOTOR STATUS IS RUNNING
    if (motor_status.value == "Running") {
        for (let i = 0; i < temperatures_input.length; i++) {
            temperatures_input[i].removeAttribute("disabled");
        }
        for (let j = 0; j < vibration_values.length; j++) {
            vibration_values[j].removeAttribute("disabled");
        }
        for (let k = 0; k < noises.length; k++) {
            noises[k].removeAttribute("disabled");
        }
    } else {
        // MOTOR STATUS NOT SELECTED
        for (let i = 0; i < temperatures_input.length; i++) {
            temperatures_input[i].setAttribute("disabled", true);
            temperatures_input[i].value = "";
        }
        for (let j = 0; j < vibration_values.length; j++) {
            vibration_values[j].setAttribute("disabled", true);
            vibration_values[j].value = "";
        }
        for (let k = 0; k < vibrations.length; k++) {
            normalizeInput(vibrations[k]);
        }
        for (let l = 0; l < noises.length; l++) {
            noises[l].value = "Normal";
            noises[l].setAttribute("disabled", true);
        }
    }

    // ENABLE COMMENT
    if (motor_status.value != "") {
        comment.removeAttribute("disabled", true);
        comment.value = "";
    } else {
        comment.setAttribute("disabled", true);
        comment.value = "";
    }
};

// VALIDATE NUMBER OF GREASING NOT EXCEED 255
number_of_greasing.onchange = () => {
    if (Number(number_of_greasing.value) > 255) {
        number_of_greasing.value = 255;
    }
};

// ONLY NUMBER DATA TYPES ALLOWED
function onlynumber(evt) {
    let ASCIICode = evt.which ? evt.which : evt.keyCode;
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) return false;
    return true;
}

// VALIDATE INPUT TEMPERATURE NOT EXCEED 200 DEGREE
for (let i = 0; i < temperatures_input.length; i++) {
    temperatures_input[i].onchange = () => {
        // if (temperatures_input[i].value.length > 3) {
        //     let value_accepted = temperatures_input[i].value.substring(0, 3)
        //     temperatures_input[i].value = value_accepted
        // }

        if (
            Number(temperatures_input[i].value) > 200 ||
            temperatures_input[i].value.length > 3
        ) {
            let temperatureModal = new bootstrap.Modal(
                document.getElementById("temperature_alert"),
                {}
            );
            temperatureModal.show();
            temperatures_input[i].value = "";
        }
    };
}

// ADD UNIT TO MOTOR DETAILS
function changeUnit(id, unit) {
    if (id.textContent.length >= 1) {
        id.textContent = id.textContent + " " + unit;
    } else {
        id.textContent = "";
    }
}

const power_unit = document.getElementById("power_unit");
const power_rate = document.getElementById("power_rate");
changeUnit(power_rate, power_unit.textContent);

power_unit.parentElement.style.display = "none";

const voltage = document.getElementById("voltage");
changeUnit(voltage, "V");

const current_nominal = document.getElementById("current_nominal");
changeUnit(current_nominal, "A");

const frequency = document.getElementById("frequency");
changeUnit(frequency, "Hz");

const pole = document.getElementById("pole");
changeUnit(pole, "P");

const rpm = document.getElementById("rpm");
changeUnit(rpm, "Rpm");

const shaft_diameter = document.getElementById("shaft_diameter");
changeUnit(shaft_diameter, "mm");

const cos_phi = document.getElementById("cos_phi");
changeUnit(cos_phi, "φ");

const efficiency = document.getElementById("efficiency");
changeUnit(efficiency, "%");

const phase_supply = document.getElementById("phase_supply");
changeUnit(phase_supply, "Phase");

const greasing_qty_de = document.getElementById("greasing_qty_de");
changeUnit(greasing_qty_de, "grams");

const greasing_qty_nde = document.getElementById("greasing_qty_nde");
changeUnit(greasing_qty_nde, "grams");

const length = document.getElementById("length");
changeUnit(length, "mm");

const width = document.getElementById("width");
changeUnit(width, "mm");

const height = document.getElementById("height");
changeUnit(height, "mm");

const weight = document.getElementById("weight");
changeUnit(weight, "kg");

// HIDE FUNCLOC WHILE NOT INSTALLED
let function_location = document.getElementById("emo_function_location");
let sort_field = document.getElementById("emo_sort_field");
let status = document.getElementById("status");

if (status.textContent == "Installed") {
    function_location.classList.remove("d-none");
    sort_field.classList.remove("d-none");
}

// DISABLED INPUT WHEN EQUIPMENT IS NOT INSTALLED (AVAILABLE / REPAIRED)
const funcloc_information = document.getElementById("funcloc_information");
const sort_field_header = document.getElementById("sort_field_header");
if (
    funcloc_information.textContent == "" &&
    sort_field_header.textContent == ""
) {
    buttonSubmit.setAttribute("disabled", true);
    motor_status.setAttribute("disabled", true);
    clean_status.setAttribute("disabled", true);
    nipple_grease.setAttribute("disabled", true);
} else {
    buttonSubmit.removeAttribute("disabled");
    motor_status.removeAttribute("disabled");
    clean_status.removeAttribute("disabled");
    nipple_grease.removeAttribute("disabled");
}
