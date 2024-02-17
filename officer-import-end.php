<?php
include 'config.php';

if (isset($_POST['import'])) {
    // Check if a file is selected
    if ($_FILES['importFile']['name'] != "") {
        $file = $_FILES['importFile']['tmp_name'];

        // Include the necessary classes
        require_once 'vendor/autoload.php';

        // Load the spreadsheet
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // Remove headers
        array_shift($sheetData);

        // Insert data into the database
        foreach ($sheetData as $row) {
            $type = $row['A'];
            $from = $row['B'];
            $to = $row['C'];
            $subject = $row['D'];
            $date = $row['E'];
            $no_of_year = $row['F'];
            $remarks = $row['G'];

            $insertQuery = "INSERT INTO docs (`type`, `from`, `to`, `subject`, `date`, `no_of_year`, `remarks`) 
            VALUES ('$type', '$from', '$to', '$subject', '$date', '$no_of_year', '$remarks')";

            mysqli_query($con, $insertQuery);
        }

        echo '<script>
                    alert("Data has been successfully imported.");
                    window.location.href = "officer-import.php";
              </script>';
    } else {
        echo '<script>
                    alert("Please select a file to import.");
                    window.location.href = "officer-import.php";
              </script>';
    }
}

?>