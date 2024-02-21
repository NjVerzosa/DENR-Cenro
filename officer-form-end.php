<?php
include 'config.php';

$message = "";

if (isset($_POST["insert"])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $type = validate($_POST['type']);
    $from = validate($_POST['from']);
    $to = validate($_POST['to']);
    $subject = validate($_POST['subject']);
    $date = validate($_POST['date']);
    $no_of_year = validate($_POST['no_of_year']);

    $type = mysqli_real_escape_string($con, $type);
    $from = mysqli_real_escape_string($con, $from);
    $to = mysqli_real_escape_string($con, $to);
    $subject = mysqli_real_escape_string($con, $subject);
    $date = mysqli_real_escape_string($con, $date);
    $no_of_year = mysqli_real_escape_string($con, $no_of_year);

    if (empty($type) || empty($from) || empty($to) || empty($subject) || empty($date) || empty($no_of_year)) {
        $message = "Please fill out all fields";
    } else {

        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];
        $validImageExtension = ['jpg', 'jpeg', 'png'];

        // Check if an image is uploaded
        if (!empty($fileName)) {
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));
            if (!in_array($imageExtension, $validImageExtension)) {
                $message = "Invalid image";
            } else {
                $newImageName = uniqid();
                $newImageName .= '.' . $imageExtension;

                move_uploaded_file($tmpName, 'Scanned/' . $newImageName);
            }
        } else {
            // Set a default image name or leave it empty based on your database schema
            $newImageName = 'noimage.png'; // Set to an appropriate default or leave empty
        }

        // $check_query = mysqli_query($con, "SELECT * FROM docs WHERE type ='$type' AND `from`='$from' AND `to`='$to' AND subject='$subject' AND date='$date' AND no_of_year='$no_of_year'");
        $check_query = mysqli_query($con, "SELECT * FROM docs WHERE subject='$subject'");

        $rowCount = mysqli_num_rows($check_query);

        if ($rowCount > 0) {
            $message = "Data already exists";
        } else {
            $inserted_at = date('Y-m-d');
            $result = mysqli_query($con, "INSERT INTO docs (inserted_at, type, `from`, `to`, subject, date, image, no_of_year, remarks) VALUES ('$inserted_at', '$type', '$from', '$to', '$subject', '$date', '$newImageName', '$no_of_year', 'No Remarks')");

            if ($result) {
                $message = "Data has been successfully inserted";
            } else {
                $message = "Failed to insert data";
            }
        }

        // Close the connection
        mysqli_close($con);

        echo '<script>
            alert("' . $message . '");
            window.location.href = "officer-form.php";
          </script>';
    }
}
?>
