<?php
include 'config.php'; // Make sure to include your database connection

session_start();

if (isset($_POST['login'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    if (empty($email)) {
        $error_message = "Email is required";
    } elseif (empty($password)) {
        $error_message = "Password is required";
    } else {
        $email = mysqli_real_escape_string($con, $email);

        $result = mysqli_query($con, "SELECT * FROM authorized WHERE email = '$email'");

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $hashed_password = $row['password'];

                if (password_verify($password, $hashed_password)) {
                    $user_role = $row['role'];

                    switch ($user_role) {
                        case "Admin":
                            $_SESSION["email"] = $row["email"];
                            $_SESSION["role"] = "Admin";
                            header("Location: admin-main.php");
                            exit();

                        case "Officer":
                            $_SESSION["email"] = $row["email"];
                            $_SESSION["role"] = "Officer";
                            header("Location: officer-main.php");
                            exit();

                        default:
                            $error_message = "Invalid user role";
                            break;
                    }
                } else {
                    $error_message = "Incorrect password";
                }
            } else {
                $error_message = "Email not found";
            }
        } else {
            $error_message = "Error in the database query";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      height: 100vh;
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.2)), url('image/hundred-islands-1.jpg') center/cover no-repeat fixed;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      /* Center content vertically */
    }

    .header {
      width: 100%;
      padding: 10px 0;
      display: flex;
      align-items: center;
      background-color: rgba(255, 255, 255, 0.2);
      /* Light transparent background */
      position: absolute;
      top: 0;
      z-index: 1;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
    }

    .header-logo {
      width: 60px;
      /* Adjust logo width */
      padding-left: 8px;
    }

    .header-text {
      font-size: 18px;
      font-weight: bold;
      color: white;
      text-shadow: 0px 0px 10px rgba(0, 0, 0, 0.9);
      margin-left: 20px;
      /* Add margin to the left */
      padding-top: 10px;
    }

    .login-form-container {
      background-color: rgba(255, 255, 255, 0.4);
      /* Adjust transparency as needed */
      border-radius: 8px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.8);
      padding: 40px;
      width: 400px;
      z-index: 1;
      margin-top: 80px;
      /* Add margin to the top */
    }

    .login-form {
      text-align: center;
    }

    .login-text {
      font-size: 30px;
      font-weight: bold;
      color: white;
      text-shadow: 0px 0px 10px rgba(0, 0, 0, 0.9);


    }

    .login-form h2 {
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <div class="header">
    <img src="image/logo.png" alt="Logo" class="header-logo">
    <p class="header-text"><b>DENR CENRO WESTERN PANGASINAN</b></p>
    <!-- Add logo on the right side -->
  </div>
  <div class="login-form-container">
    <div class="login-form">
      <h1 class="login-text">Login</h1>
      <?php if (isset($error_message)) { ?>
        <p style="color:black;text-shadow: 0px 0px 10px rgba(255, 0, 0, 0.9);">
          <?php echo $error_message; ?>
        </p>
      <?php } ?>
      <form action="" method="POST">
        <div class="form-group">
          <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" id="password" name="password" placeholder="PIN Code" required>
        </div>
        <button type="submit" name="login" class="btn btn-success btn-block">Login</button>
      </form>
    </div>
  </div>
</body>
<script src="js/inspect.js"></script>

</html>