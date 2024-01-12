<script>
    // FOCUS TO SEARCH
    const search_data = document.getElementById("search_data");
    const to_search = document.getElementById("to_search");
    const navbarSupportedContent = document.getElementById("navbarSupportedContent");

    to_search.onclick = () => {
        navbarSupportedContent.classList.toggle("show");
        search_data.focus();
    }
</script>