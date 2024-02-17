<?php
include 'config.php';

if (isset($_POST['archiveBtn'])) {
    // Check if any checkboxes are selected
    if (!empty($_POST['selectedRecords'])) {
        $selectedRecords = $_POST['selectedRecords'];

        // Loop through the selected items and move them to the archive database
        foreach ($selectedRecords as $itemId) {
            $itemId = mysqli_real_escape_string($con, $itemId);

            // Insert into docs
            $archiveQuery = "INSERT INTO docs SELECT * FROM archive_docs WHERE id = '$itemId'";
            $archiveResult = mysqli_query($con, $archiveQuery);

            if (!$archiveResult) {
                die("Archive Query failed: " . mysqli_error($con));
            }

            // Optional: You may want to delete the archived items from the original database
            $deleteQuery = "DELETE FROM archive_docs WHERE id = '$itemId'";
            $deleteResult = mysqli_query($con, $deleteQuery);

            if (!$deleteResult) {
                die("Delete Query failed: " . mysqli_error($con));
            }
        }

        echo '<script>
                    alert("Data restored successfully.");
                    window.location.href = "officer-archived.php";
              </script>';
    } else {
        echo '<script>
                    alert("Please select items for restoring.");
                    window.location.href = "officer-archived.php";
              </script>';
    }
}
?>