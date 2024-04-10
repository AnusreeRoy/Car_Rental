
    document.addEventListener("DOMContentLoaded", function() {
        const bookNowForm = document.getElementById("book-now-form");

        bookNowForm.addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent default form submission

            // Get the value of the id attribute
            const userId = <?php echo $_SESSION['id']; ?>;

            // Redirect to renter_profile.php?id={userId}
            window.location.href = `renter_profile.php?id=${userId}`;
        });
    });
