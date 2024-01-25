<script>
    function changeVibrationDescriptionColor(id) {
        let input = document.getElementById(id);
        let select = document.getElementById(id.replace('value', 'desc'));
        let power_rate = Number(<?php 45 ?>)

        if (Number(input.value) > 45) {
            input.value = '';
        }

        if (power_rate <= 15) {
            smallMachines(input, select)
        } else if (power_rate > 15 && power_rate <= 300) {
            mediumMachines(input, select)
        } else if (power_rate > 300 && power_rate <= 600) {
            largeRigidFoundation(input, select)
        } else {
            largeSoftFoundation(input, select)
        }
    }
</script>

<script>
    function resetColor(select) {
        select.classList.remove('bg-success');
        select.classList.remove('bg-info');
        select.classList.remove('bg-warning');
        select.classList.remove('bg-danger');
        select.classList.remove('text-dark');
        select.classList.remove('text-white');
    }

    function good(select) {
        resetColor(select);
        select.classList.add('text-white');
        select.classList.add('bg-success');
        select.value = 'Good';
    }

    function satisfactory(select) {
        resetColor(select);
        select.classList.add('text-dark');
        select.classList.add('bg-info');
        select.value = 'Satisfactory';
    }

    function unsatisfactory(select) {
        resetColor(select);
        select.classList.add('text-dark');
        select.classList.add('bg-warning');
        select.value = 'Unsatisfactory';
    }

    function unacceptable(select) {
        resetColor(select);
        select.classList.add('text-white');
        select.classList.add('bg-danger');
        select.value = 'Unacceptable';
    }
</script>

<script>
    function smallMachines(input, select) {
        if (Number(input.value) <= 0.71) {
            good(select)
        } else if (Number(input.value) > 0.71 && Number(input.value) <= 1.80) {
            satisfactory(select)
        } else if (Number(input.value) > 1.80 && Number(input.value) <= 4.50) {
            unsatisfactory(select)
        } else {
            unacceptable(select);
        }
    }

    function mediumMachines(input, select) {
        if (Number(input.value) <= 1.12) {
            good(select)
        } else if (Number(input.value) > 1.12 && Number(input.value) <= 2.80) {
            satisfactory(select)
        } else if (Number(input.value) > 2.80 && Number(input.value) <= 7.10) {
            unsatisfactory(select)
        } else {
            unacceptable(select);
        }
    }

    function largeRigidFoundation(input, select) {
        if (Number(input.value) <= 1.80) {
            good(select)
        } else if (Number(input.value) > 1.80 && Number(input.value) <= 4.50) {
            satisfactory(select)
        } else if (Number(input.value) > 4.50 && Number(input.value) <= 11.2) {
            unsatisfactory(select)
        } else {
            unacceptable(select);
        }
    }

    function largeSoftFoundation(input, select) {
        if (Number(input.value) <= 2.80) {
            good(select)
        } else if (Number(input.value) > 2.80 && Number(input.value) <= 7.10) {
            satisfactory(select)
        } else if (Number(input.value) > 7.10 && Number(input.value) <= 18.0) {
            unsatisfactory(select)
        } else {
            unacceptable(select);
        }
    }
</script>