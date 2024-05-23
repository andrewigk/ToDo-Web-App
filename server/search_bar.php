<form class="searchBarForm" method="GET" action="search.php" onsubmit="return validateSearch()">
    <input type="text" name="searchQuery" id="searchQuery" placeholder="Search by tag, Ex:'Work' ">
    <button type="submit">Search</button>
    <div id="error-message" style="color: red;"></div> <!-- Error message container -->
</form>
<script>
    function validateSearch() {
        var searchQuery = document.getElementById('searchQuery').value.trim();
        var errorMessage = document.getElementById('error-message');
        if (searchQuery === '') {
            errorMessage.textContent = 'Please enter a search query.';
            return false; // Prevent form submission
        } else {
            errorMessage.textContent = ''; // Clear the error message if it was previously set
            return true; // Allow form submission
        }
    }
</script>