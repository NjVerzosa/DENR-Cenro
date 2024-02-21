<?php
include 'config.php';

if (isset($_POST["add"])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['email']); // Assuming email is the input field name
    $password = validate($_POST['password']); // Assuming password is the input field name
    $role = validate($_POST['role']); // Assuming role is the input field name

    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);
    $role = mysqli_real_escape_string($con, $role);

    if (empty($email) || empty($password) || empty($role)) {
        $message = "Please fill out all fields";
    } else {
        $check_query = mysqli_query($con, "SELECT * FROM authorized WHERE email='$email'");

        $rowCount = mysqli_num_rows($check_query);

        if ($rowCount > 0) {
            $message = "Email already exists";
        } else {
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $result = mysqli_query($con, "INSERT INTO authorized (email, password, role) VALUES ('$email', '$password_hashed', '$role')");

            if ($result) {
                $message = "New Admin has been successfully inserted";
            } else {
                $message = "Failed to insert new admin";
            }
        }

        echo '<script>
            alert("' . $message . '");
            window.location.href = "officer-main.php";
          </script>';
    }
}

?>