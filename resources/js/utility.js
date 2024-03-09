export function toupper(evt) {
    evt.value = evt.value.toUpperCase();
}

export function onlynumber(evt, min = 48, max = 57) {
    let ASCIICode = evt.which ? evt.which : evt.keyCode;
    if (ASCIICode > 31 && (ASCIICode < min || ASCIICode > max)) return false;
    return true;
}

export function onlynumbercoma(evt) {
    let ASCIICode = evt.which ? evt.which : evt.keyCode;
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57) && ASCIICode != 46)
        return false;
    return true;
}

export function preventmaxtemperature(id, max = 255) {
    let input = document.getElementById(id);
    if (Number(input.value) > max) {
        input.value = "";
    }
}

export function preventmaxvibration(id, max = 45) {
    let input = document.getElementById(id);
    if (Number(input.value) > max) {
        input.value = "";
    }
}

export function preventSubmitForm(event) {
    let key = event.keyCode || event.charChode || 0;
    if (key == 13) {
        return false;
    }
}

// CHANGE VIBRATION START
export function changeVibrationDescriptionColor(id) {
    let input = document.getElementById(id);
    let power_rate = input.getAttribute("power_rate");
    let desc = document.getElementById(id.replace("value", "desc"));

    if (power_rate <= 15) {
        smallMachines(input, desc);
    } else if (power_rate > 15 && power_rate <= 300) {
        mediumMachines(input, desc);
    } else if (power_rate > 300 && power_rate <= 600) {
        largeRigidFoundation(input, desc);
    } else {
        largeSoftFoundation(input, desc);
    }
}

function resetColor(desc) {
    desc.classList.remove("bg-success");
    desc.classList.remove("bg-info");
    desc.classList.remove("bg-warning");
    desc.classList.remove("bg-danger");
    desc.classList.remove("text-dark");
    desc.classList.remove("text-white");
}

// --------------------------------------------------

function good(desc) {
    resetColor(desc);
    desc.classList.add("text-white");
    desc.classList.add("bg-success");
    desc.value = "Good";
}

function satisfactory(desc) {
    resetColor(desc);
    desc.classList.add("text-dark");
    desc.classList.add("bg-info");
    desc.value = "Satisfactory";
}

function unsatisfactory(desc) {
    resetColor(desc);
    desc.classList.add("text-dark");
    desc.classList.add("bg-warning");
    desc.value = "Unsatisfactory";
}

function unacceptable(desc) {
    resetColor(desc);
    desc.classList.add("text-white");
    desc.classList.add("bg-danger");
    desc.value = "Unacceptable";
}

// --------------------------------------------------

function smallMachines(input, desc) {
    if (Number(input.value) <= 0.71) {
        good(desc);
    } else if (Number(input.value) > 0.71 && Number(input.value) <= 1.8) {
        satisfactory(desc);
    } else if (Number(input.value) > 1.8 && Number(input.value) <= 4.5) {
        unsatisfactory(desc);
    } else {
        unacceptable(desc);
    }
}

function mediumMachines(input, desc) {
    if (Number(input.value) <= 1.12) {
        good(desc);
    } else if (Number(input.value) > 1.12 && Number(input.value) <= 2.8) {
        satisfactory(desc);
    } else if (Number(input.value) > 2.8 && Number(input.value) <= 7.1) {
        unsatisfactory(desc);
    } else {
        unacceptable(desc);
    }
}

function largeRigidFoundation(input, desc) {
    if (Number(input.value) <= 1.8) {
        good(desc);
    } else if (Number(input.value) > 1.8 && Number(input.value) <= 4.5) {
        satisfactory(desc);
    } else if (Number(input.value) > 4.5 && Number(input.value) <= 11.2) {
        unsatisfactory(desc);
    } else {
        unacceptable(desc);
    }
}

function largeSoftFoundation(input, desc) {
    if (Number(input.value) <= 2.8) {
        good(desc);
    } else if (Number(input.value) > 2.8 && Number(input.value) <= 7.1) {
        satisfactory(desc);
    } else if (Number(input.value) > 7.1 && Number(input.value) <= 18.0) {
        unsatisfactory(desc);
    } else {
        unacceptable(desc);
    }
}

// SHOW MODAL CONFIRM
export function modalConfirm(url) {
    let modal_url = document.getElementById("modal_url");
    modal_url.setAttribute("href", url);

    modal_button_cancel = document.getElementById("modal_button_cancel");
    modal_button_cancel.onclick = () => {
        modal_url.removeAttribute("href");
    };
}

// FILTERING DATA TABLE
export function fillInputFilterFromUrlSearchParams(...input_filter) {
    let params = new URLSearchParams(document.location.search);
    if (params.size >= 1) {
        for (const input of input_filter) {
            let input_from_param = params.get(input.getAttribute("id"));
            input.value = input_from_param;
        }
    }
}

export function filter(...input_filter) {
    let params = new URLSearchParams(document.location.search);
    params.delete("page");

    for (const input of input_filter) {
        params.delete(input.getAttribute("id"));
        if (input.value != "") {
            params.append(input.getAttribute("id"), input.value);
        }
    }

    if (params.size >= 1) {
        window.location = location.pathname + "?" + params.toString();
    } else {
        window.location = location.pathname;
    }
}

// DEBOUNCE
export const debounce = (mainFunction, delay) => {
    // Declare a variable called 'timer' to store the timer ID
    let timer;

    // Return an anonymous function that takes in any number of arguments
    return function (...args) {
        // Clear the previous timer to prevent the execution of 'mainFunction'
        clearTimeout(timer);

        // Set a new timer that will execute 'mainFunction' after the specified delay
        timer = setTimeout(() => {
            mainFunction(...args);
        }, delay);
    };
};

// INSTALL DISMANTLE

function requestEquipment(token, input, table) {
    let request = new Request(`/equipment-${table}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            "X-CSRF-TOKEN": token,
        },
        body: JSON.stringify({
            equipment: input.value,
            status: input.getAttribute("status"),
        }),
    });

    return request;
}

export function fetchEquipment(token, input, field, table) {
    if (input.value.length == 9) {
        let response = fetch(requestEquipment(token, input, table));
        response
            .then((value) => value.json())
            .then((equipment) => {
                if (equipment.id !== undefined) {
                    for (const [key, value] of Object.entries(equipment)) {
                        //  RENDER DATA
                        if (key == `${table}_detail` && value != null) {
                            for (const [
                                detail_key,
                                detail_value,
                            ] of Object.entries(value)) {
                                // CREATE ELEMENT MOTOR DETAIL
                                if (
                                    detail_key == "id" ||
                                    detail_key == `${table}_detail` ||
                                    detail_key == "created_at" ||
                                    detail_key == "updated_at"
                                ) {
                                    continue;
                                } else {
                                    createElement(
                                        field,
                                        detail_key,
                                        detail_value
                                    );
                                }
                            }
                        } else {
                            // CREATE ELEMENT MOTOR
                            if (key == `${table}_detail` && value == null) {
                                continue;
                            } else if (
                                key == "created_at" ||
                                key == "updated_at"
                            ) {
                                continue;
                            } else if (key == "qr_code_link") {
                                createElement(field, key, value.split("=")[1]);
                            } else {
                                createElement(field, key, value);
                            }
                        }
                    }
                } else {
                    // CREATE ALERT
                    createAlert(field, "Not found.", "alert-info");
                }
            });
    }
}

export function doFetchEquipment(token, table) {
    for (const action of ["install", "dismantle"]) {
        const button = document.getElementById(`${action}_button`);
        const input = document.getElementById(`${action}_input`);
        const field = document.getElementById(`${action}_field`);

        button.onclick = () => {
            JS.removeAllChildren(field);
            JS.fetchEquipment(token, input, field, table);
        };
    }
}

function enableButtonSwap() {
    let button = document.getElementById("button_swap");
    let dismantled_equipment =
        document.getElementById("dismantle_field")?.firstElementChild
            ?.lastElementChild ?? null;
    let installed_equipment =
        document.getElementById("install_field")?.firstElementChild
            ?.lastElementChild ?? null;

    if (
        dismantled_equipment != null &&
        installed_equipment != null &&
        dismantled_equipment.value.length == 9 &&
        installed_equipment.value.length == 9
    ) {
        button.classList.remove("d-none");
    } else {
        button.classList.add("d-none");
    }
}

export function callEnableButtonSwap() {
    setInterval(() => {
        enableButtonSwap();
    }, 1000);
}

// -------------------

function myucfirst(words) {
    const firstString = words.charAt(0);
    const firstStringCap = firstString.toUpperCase();
    const remainingLetters = words.slice(1);
    const result = firstStringCap + remainingLetters;
    return result;
}

function createElement(form, key, value) {
    let div = document.createElement("div");
    div.setAttribute("class", "mb-3");

    let label = document.createElement("label");
    label.setAttribute("class", "fw-semibold form-label");
    label.textContent = myucfirst(key).split("_").join(" ");

    let input = document.createElement("input");
    input.setAttribute("class", "form-control");
    input.setAttribute("value", value ?? "");
    input.setAttribute("readonly", true);
    if (key == "id") {
        switch (form.id) {
            case "dismantle_field":
                input.setAttribute("name", key + "_dismantle");
                break;
            case "install_field":
                input.setAttribute("name", key + "_install");
                break;
        }
    }

    div.appendChild(label);
    div.appendChild(input);
    form.appendChild(div);
}

export function removeAllChildren(parent) {
    while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
    }
}

function createAlert(form, message, variant, buttonClose = null) {
    let alert = document.createElement("div");
    alert.setAttribute("class", "alert alert-dismissible px-3" + ` ${variant}`);
    alert.setAttribute("role", "alert");
    alert.textContent = message;
    if (buttonClose == true) {
        closeButton = document.createElement("button");
        closeButton.setAttribute("type", "button");
        closeButton.setAttribute("class", "btn-close");
        closeButton.setAttribute("data-bs-dismiss", "alert");
        closeButton.setAttribute("aria-label", "Close");
        alert.appendChild(closeButton);
    }
    form.appendChild(alert);
}
