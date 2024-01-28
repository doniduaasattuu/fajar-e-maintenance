<script>
    function preventSubmitForm(myform) {
        myform.onkeypress = (event) => {
            let key = event.keyCode || event.charChode || 0;
            if (key == 13) {
                return false;
            }
        }
    }
</script>