<script>
    // FUNCTION ONLY NUMBER ALLOWED
    function onlynumbercoma(evt) {
        let ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57) && ASCIICode != 46)
            return false;
        return true;
    }
</script>