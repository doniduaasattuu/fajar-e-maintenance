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

export function sayHello(name) {
    return `Hello ${name}`;
}

// CHANGE VIBRATION START
export function changeVibrationDescriptionColor(id) {
    let input = document.getElementById(id);
    let select = document.getElementById(id.replace("value", "desc"));
    let power_rate = Number(45);

    if (Number(input.value) > 45) {
        input.value = "";
    }

    if (power_rate <= 15) {
        smallMachines(input, select);
    } else if (power_rate > 15 && power_rate <= 300) {
        mediumMachines(input, select);
    } else if (power_rate > 300 && power_rate <= 600) {
        largeRigidFoundation(input, select);
    } else {
        largeSoftFoundation(input, select);
    }
}

export function resetColor(select) {
    select.classList.remove("bg-success");
    select.classList.remove("bg-info");
    select.classList.remove("bg-warning");
    select.classList.remove("bg-danger");
    select.classList.remove("text-dark");
    select.classList.remove("text-white");
}

// --------------------------------------------------

export function good(select) {
    resetColor(select);
    select.classList.add("text-white");
    select.classList.add("bg-success");
    select.value = "Good";
}

export function satisfactory(select) {
    resetColor(select);
    select.classList.add("text-dark");
    select.classList.add("bg-info");
    select.value = "Satisfactory";
}

export function unsatisfactory(select) {
    resetColor(select);
    select.classList.add("text-dark");
    select.classList.add("bg-warning");
    select.value = "Unsatisfactory";
}

export function unacceptable(select) {
    resetColor(select);
    select.classList.add("text-white");
    select.classList.add("bg-danger");
    select.value = "Unacceptable";
}

// --------------------------------------------------

export function smallMachines(input, select) {
    if (Number(input.value) <= 0.71) {
        good(select);
    } else if (Number(input.value) > 0.71 && Number(input.value) <= 1.8) {
        satisfactory(select);
    } else if (Number(input.value) > 1.8 && Number(input.value) <= 4.5) {
        unsatisfactory(select);
    } else {
        unacceptable(select);
    }
}

export function mediumMachines(input, select) {
    if (Number(input.value) <= 1.12) {
        good(select);
    } else if (Number(input.value) > 1.12 && Number(input.value) <= 2.8) {
        satisfactory(select);
    } else if (Number(input.value) > 2.8 && Number(input.value) <= 7.1) {
        unsatisfactory(select);
    } else {
        unacceptable(select);
    }
}

export function largeRigidFoundation(input, select) {
    if (Number(input.value) <= 1.8) {
        good(select);
    } else if (Number(input.value) > 1.8 && Number(input.value) <= 4.5) {
        satisfactory(select);
    } else if (Number(input.value) > 4.5 && Number(input.value) <= 11.2) {
        unsatisfactory(select);
    } else {
        unacceptable(select);
    }
}

export function largeSoftFoundation(input, select) {
    if (Number(input.value) <= 2.8) {
        good(select);
    } else if (Number(input.value) > 2.8 && Number(input.value) <= 7.1) {
        satisfactory(select);
    } else if (Number(input.value) > 7.1 && Number(input.value) <= 18.0) {
        unsatisfactory(select);
    } else {
        unacceptable(select);
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

export function getValueFromUrlSearchParams(id) {
    let params = new URLSearchParams(document.location.search);
    let value_from_params = params.get(id);

    return value_from_params;
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
