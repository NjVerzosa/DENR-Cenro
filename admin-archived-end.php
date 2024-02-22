<?php

include 'config.php';
 
if (isset($_POST['archiveBtn'])) {
    // Check if any checkboxes are selected
    if (!empty($_POST['selectedRecords'])) {
        $selectedRecords = $_POST['selectedRecords'];

        // Loop through the selected items and move them to the archive database
        foreach ($selectedRecords as $itemId) {
            $itemId = mysqli_real_escape_string($con, $itemId);
            $archiveQuery = "INSERT INTO docs SELECT * FROM archive_docs WHERE id = '$itemId'";
            mysqli_query($con, $archiveQuery);

            // Optional: You may want to delete the archived items from the original database
            $deleteQuery = "DELETE FROM archive_docs WHERE id = '$itemId'";
            mysqli_query($con, $deleteQuery);
        }
        echo '<script>
                    alert("Data archived successfully.");
                    window.location.href = "admin-main.php";
              </script>';
    } else {
        echo '<script>
                    alert("Please select items for archiving.");
                    window.location.href = "admin-main.php";
              </script>';
    }
}
