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
                    window.location.href = "officer-main.php";
              </script>';
    } else {
        echo '<script>
                    alert("Please select a file to import.");
                    window.location.href = "officer-main.php";
              </script>';
    }
}


if (isset($_POST['archiveBtn'])) {
    // Check if any checkboxes are selected
    if (!empty($_POST['selectedRecords'])) {
        $selectedRecords = $_POST['selectedRecords'];

        // Loop through the selected items and move them to the archive database
        foreach ($selectedRecords as $itemId) {
            $itemId = mysqli_real_escape_string($con, $itemId);
            $archiveQuery = "INSERT INTO archive_docs SELECT * FROM docs WHERE id = '$itemId'";
            mysqli_query($con, $archiveQuery);

            // Optional: You may want to delete the archived items from the original database
            $deleteQuery = "DELETE FROM docs WHERE id = '$itemId'";
            mysqli_query($con, $deleteQuery);
        }
        echo '<script>
                    alert("Data archived successfully.");
                    window.location.href = "officer-main.php";
              </script>';
    } else {
        echo '<script>
                    alert("Please select items for archiving.");
                    window.location.href = "officer-main.php";
              </script>';
    }
}


if (isset($_POST['export'])) {
    // Check if selected data is present
    if (isset($_POST['selectedRecords'])) {
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

        $selectedRecords = $_POST['selectedRecords'];

        // Fetch and export only selected data
        $dataRow = 2;
        foreach ($selectedRecords as $selectedId) {
            $query = "SELECT * FROM docs WHERE id = $selectedId";
            $row = $con->query($query)->fetch_assoc();
            if ($row) {
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
                window.location.href = "officer-main.php";
            </script>';
    } else {
        echo '<script>
                alert("Please select data.");
                window.location.href = "officer-main.php";
            </script>';
    }
}


// if(isset($_POST['imageSrc'])) {
//     $imageSrc = $_POST['imageSrc'];

//     // Use a library like TCPDF or FPDF to create a PDF
//     // Here, we'll just save the base64 image directly as a PDF file
//     $pdfData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageSrc));
//     file_put_contents('PDFs', $pdfData);

//     echo json_encode(['success' => true, 'message' => 'PDF created successfully']);
// } else {
//     echo json_encode(['success' => false, 'message' => 'Image source not provided']);
// }


if (isset($_POST["add"])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $role = validate($_POST['role']);

    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);
    $role = mysqli_real_escape_string($con, $role);

    if (empty($email) || empty($password) || empty($role)) {
        $message = "Please fill out all fields";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format";
    } elseif (strlen($password) < 8) {
        $message = "Password must be at least 8 characters long";
    } else {
        $check_query = mysqli_query($con, "SELECT * FROM authorized WHERE email='$email'");

        $rowCount = mysqli_num_rows($check_query);

        if ($rowCount > 0) {
            $message = "Email already exists";
        } else {
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $result = mysqli_query($con, "INSERT INTO authorized (email, password, role) VALUES ('$email', '$password_hashed', '$role')");

            if ($result) {
                require "Mail/phpmailer/PHPMailerAutoload.php";
                $mail = new PHPMailer;

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';

                // $mail->Username = 'njverzosa24@gmail.com';
                // $mail->Password = 'lhfi snfv vqcb oelt';

                $mail->Username = 'thisdomain24@gmail.com';
                $mail->Password = 'rhtq qcaj mdqp sdkv';


                $mail->setFrom('thisdomain24@gmail.com', 'DENR-Cenro Western Alaminos');
                $mail->addAddress('thisdomain24@gmail.com');//Add Notif Receiver

                $mail->isHTML(true);
                $mail->Subject = "New Officer Added";
                $mail->Body = "<p>A new authorized user has been added with the email address: <strong>$email</strong>.</p><p>This message is for notification purposes only.</p>";
                
                if (!$mail->send()) {
                    $message = "Email notification could not be sent due to technical issues.";
                } else {
                    $message = "Officer successfully added";
                }
            }

            echo '<script>
            alert("' . $message . '");
            window.location.href = "officer-main.php";
          </script>';
        }
    }
}