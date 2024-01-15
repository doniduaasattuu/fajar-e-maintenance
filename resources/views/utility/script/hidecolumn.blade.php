<script>
    function hideColumnOnPhone(visibility, column) {
        let columns = document.getElementsByClassName(column);
        for (let i = 0; i < columns.length; i++) {
            if (visibility == 'add') {
                columns[i].classList.add('d-none');
            } else if (visibility == 'remove') {
                columns[i].classList.remove('d-none');
            }
        }
    }
</script>