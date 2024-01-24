<script>
    function preventmax(id, max) {
        let temp = document.getElementById(id);
        if (Number(temp.value) > max) {
            temp.value = '';
        }
    }
</script>