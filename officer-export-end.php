<?php
include 'config.php';

// Exporting file
if (isset($_POST['export'])) {
    // Include the necessary classes
    require_once 'vendor/autoload.php';

    // Specify the directory path for storing the files
    $exportDirectory = 'Exported Files/';

    // Check if the directory exists, if not, create it
    if (!is_dir($exportDirectory)) {
        mkdir($exportDirectory, 0755, true);
    }

    // Create a new Spreadsheet object
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set headers
    $headers = array("Type", "From", "To", "Subject", "Date", "No. of Years", "Remarks");
    $sheet->fromArray($headers, NULL, 'A1');

    // Check if selected data is present
    if (isset($_POST['selected_data'])) {
        $selectedData = $_POST['selected_data'];

        // Fetch and export only selected data
        $dataRow = 2;
        foreach ($selectedData as $selectedId) {
            $query = "SELECT * FROM docs WHERE id = $selectedId";
            $result = $con->query($query);

            if ($result && $row = mysqli_fetch_assoc($result)) {
                $data = array(
                    $row["type"],
                    $row["from"],
                    $row["to"],
                    $row["subject"],
                    $row["date"],
                    $row["no_of_year"],
                    $row["remarks"]
                );
                $sheet->fromArray($data, NULL, 'A' . $dataRow);
                $dataRow++;
            }
        }
    } else {
        // Export all data if no specific selection is made
        $sql = "SELECT * FROM docs";
        $result = $con->query($sql);

        // Set data
        $dataRow = 2;
        while ($row = mysqli_fetch_assoc($result)) {
            $data = array(
                $row["type"],
                $row["from"],
                $row["to"],
                $row["subject"],
                $row["date"],
                $row["no_of_year"],
                $row["remarks"]
            );
            $sheet->fromArray($data, NULL, 'A' . $dataRow);
            $dataRow++;
        }
    }

    // Resize column widths based on content
    foreach (range('A', 'G') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    // Save the spreadsheet as an Excel file in the specified directory
    $currentDate = date('Y-M-D'); // Y-m-d H:i:s format
    $filename = 'Excel-' . $currentDate . '.xlsx';

    $filePath = $exportDirectory . $filename;
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save($filePath);

    echo '<script>
            alert("File exported successfully.");
            window.location.href = "officer-export.php";
        </script>';
}

?>