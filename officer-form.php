<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <title>DENR Form</title>

  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      height: 100vh;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.2)), url('image/hundred-islands-1.jpg') center/cover no-repeat fixed;
    }

    .header {
      width: 100%;
      padding: 10px 0;
      display: flex;
      align-items: center;
      background-color: rgba(255, 255, 255, 0.2);
      position: absolute;
      top: 0;
      z-index: 1;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
    }

    .header-logo {
      width: 60px;
      padding-left: 8px;
    }

    .header-text {
      font-size: 18px;
      font-weight: bold;
      color: white;
      text-shadow: 0px 0px 10px rgba(0, 0, 0, 0.9);
      margin-left: 20px;
      padding-top: 10px;
    }

    .login-form-container {
      background-color: rgba(255, 255, 255, 1);
      border-radius: 8px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.8);
      padding: 40px;
      margin: 80px auto 0;
      /* Add top margin to prevent overlap */
      z-index: 1;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      font-size: 16px;
      color: black;
      font-weight: bold;
      margin-bottom: 8px;
    }

    .form-control {
      background-color: rgba(211, 211, 211, 1);
    }

    h2 {
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="header">
    <img src="image/logo.png" alt="Logo" class="header-logo">
    <p class="header-text"><b>DENR CENRO WESTERN PANGASINAN</b></p>
    <a href="logout.php" class="btn-success"
            style="color: white; padding: 5px; background-color: red; margin-left: 710px;">
            LOGOUT</a>

  </div>

  <div class="container">
    <div class="login-form-container">
      <div class="login-form">
        <h2 class="mb-4" style="font-weight: bold; font-size: 30px; color: black;">Add Form</h2>
        <form action="officer-form-end.php" method="POST" enctype="multipart/form-data"onsubmit="return validateForm()">
          <div class="form-row">
            <div class="col-6 form-group">
              <label for="type">Type</label>
              <input type="text" class="form-control" name="type" required>
            </div>
            <div class="col-6 form-group">
              <label for="from">From</label>
              <input type="text" class="form-control" name="from" required>
            </div>
            <div class="col-6 form-group">
              <label for="to">To</label>
              <input type="text" class="form-control" name="to" required>
            </div>
            <div class="col-6 form-group">
              <label for="subject">Subject</label>
              <input type="text" class="form-control" name="subject" required>
            </div>
            <div class="col-6 form-group">
              <label for="date">Date</label>
              <input type="date" class="form-control" name="date" required>
            </div>
            <div class="col-6 form-group">
              <label for="years">No. of Years</label>
              <input type="number" class="form-control" name="no_of_year" required>
            </div>
            <div class="col-6 form-group mx-auto text-center">
              <label for="file">Documents</label>
              <input type="file" class="p-1 form-control" name="image" >
            </div>
          </div>
          <div class="text-center">
            <a href="officer-main.php"><button type="button" class="btn btn-success"
              style="width: 10%; padding: 5px;">Go to Main</button></a>
            <button type="submit" class="btn btn-primary" name="insert"
              style="width: 25%; padding: 10px;">SUBMIT</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
<script>
        function validateForm() {
            // Add client-side validation logic here
            var type = document.getElementsByName('type')[0].value;
            var from = document.getElementsByName('from')[0].value;
            var to = document.getElementsByName('to')[0].value;
            var subject = document.getElementsByName('subject')[0].value;
            var date = document.getElementsByName('date')[0].value;
            var no_of_year = document.getElementsByName('no_of_year')[0].value;

            if (type.trim() === '' || from.trim() === '' || to.trim() === '' || subject.trim() === '' || date.trim() === '' || no_of_year.trim() === '') {
                alert('Please fill out all fields');
                return false;
            }

            // Additional validation logic can be added here

            return true;
        }
    </script>
</html>