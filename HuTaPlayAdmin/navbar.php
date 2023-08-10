<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand">Admin</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_gifts.php">Manage Stages</a></li>
            <li><a href="manage_giftcodes.php">Manage Gifts</a></li>
            <li><a href="manage_stages.php">Manage Giftcodes</a></li>
            <li><a href="manage_memory_game.php">Manage Memory Game Images</a></li>
        </ul>
    </div>
</nav>

<script>
    // Get the current page URL
    const currentPage = window.location.href;

    // Get all the `a` elements within the navbar
    const links = document.querySelectorAll('.navbar-nav a');

    // Loop through the links
    for (const link of links) {
        // Check if the link href matches the current page URL
        if (link.href === currentPage) {
            // If it does, add the `active` class to the parent `li` element
            link.parentElement.classList.add('active');
        }
    }
</script>