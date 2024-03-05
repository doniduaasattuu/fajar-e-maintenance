<script>
    function changeVibrationDescriptionColor(id, power_rate) {
        let input = document.getElementById(id);
        let desc = document.getElementById(id.replace('value', 'desc'));

        if (Number(input.value) > 45) {
            input.value = '';
        }

        if (Number(power_rate) <= 15) {
            smallMachines(input, desc)
        } else if (power_rate > 15 && power_rate <= 300) {
            mediumMachines(input, desc)
        } else if (power_rate > 300 && power_rate <= 600) {
            largeRigidFoundation(input, desc)
        } else {
            largeSoftFoundation(input, desc)
        }
    }
</script>

<script>
    function resetColor(desc) {
        desc.classList.remove('bg-success');
        desc.classList.remove('bg-info');
        desc.classList.remove('bg-warning');
        desc.classList.remove('bg-danger');
        desc.classList.remove('text-dark');
        desc.classList.remove('text-white');
    }

    function good(desc) {
        resetColor(desc);
        desc.classList.add('text-white');
        desc.classList.add('bg-success');
        desc.value = 'Good';
    }

    function satisfactory(desc) {
        resetColor(desc);
        desc.classList.add('text-dark');
        desc.classList.add('bg-info');
        desc.value = 'Satisfactory';
    }

    function unsatisfactory(desc) {
        resetColor(desc);
        desc.classList.add('text-dark');
        desc.classList.add('bg-warning');
        desc.value = 'Unsatisfactory';
    }

    function unacceptable(desc) {
        resetColor(desc);
        desc.classList.add('text-white');
        desc.classList.add('bg-danger');
        desc.value = 'Unacceptable';
    }
</script>

<script>
    function smallMachines(input, desc) {
        if (Number(input.value) <= 0.71) {
            good(desc)
        } else if (Number(input.value) > 0.71 && Number(input.value) <= 1.80) {
            satisfactory(desc)
        } else if (Number(input.value) > 1.80 && Number(input.value) <= 4.50) {
            unsatisfactory(desc)
        } else {
            unacceptable(desc);
        }
    }

    function mediumMachines(input, desc) {
        if (Number(input.value) <= 1.12) {
            good(desc)
        } else if (Number(input.value) > 1.12 && Number(input.value) <= 2.80) {
            satisfactory(desc)
        } else if (Number(input.value) > 2.80 && Number(input.value) <= 7.10) {
            unsatisfactory(desc)
        } else {
            unacceptable(desc);
        }
    }

    function largeRigidFoundation(input, desc) {
        if (Number(input.value) <= 1.80) {
            good(desc)
        } else if (Number(input.value) > 1.80 && Number(input.value) <= 4.50) {
            satisfactory(desc)
        } else if (Number(input.value) > 4.50 && Number(input.value) <= 11.2) {
            unsatisfactory(desc)
        } else {
            unacceptable(desc);
        }
    }

    function largeSoftFoundation(input, desc) {
        if (Number(input.value) <= 2.80) {
            good(desc)
        } else if (Number(input.value) > 2.80 && Number(input.value) <= 7.10) {
            satisfactory(desc)
        } else if (Number(input.value) > 7.10 && Number(input.value) <= 18.0) {
            unsatisfactory(desc)
        } else {
            unacceptable(desc);
        }
    }
</script>