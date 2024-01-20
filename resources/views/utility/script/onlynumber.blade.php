<script>
    // FUNCTION ONLY NUMBER ALLOWED
    function onlynumber(evt, min, max) {
        let ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < min || ASCIICode > max))
            return false;
        return true;
    }
</script>