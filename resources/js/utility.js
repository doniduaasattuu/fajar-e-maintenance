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

// export function hello() {
//     console.log("hello");
// }
