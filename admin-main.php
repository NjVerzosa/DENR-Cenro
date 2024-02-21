<?php
include 'admin-sessions.php';
include 'config.php';


if (isset($_POST['userInput'])) {
    $userInput = mysqli_real_escape_string($con, $_POST['userInput']);
    // Modify the query to include the search condition
    $sql = "SELECT * FROM docs WHERE 
            type LIKE '%$userInput%' OR
            `from` LIKE '%$userInput%' OR
            `to` LIKE '%$userInput%' OR
            subject LIKE '%$userInput%' OR
            date LIKE '%$userInput%' OR
            no_of_year LIKE '%$userInput%' OR
            remarks LIKE '%$userInput%'";

    $result = $con->query($sql);
} else {
    // Export all data if no search term is provided
    $sql = "SELECT * FROM docs ORDER BY id DESC LIMIT 10;";
    $result = $con->query($sql);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Main</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="main.css">
</head>
<style>
    .modal-body img {
        display: block;
        margin: 0 auto;
        transition: transform 0.3s ease-in-out;
    }

    .modal-body img:hover {
        transform: scale(1.2);
    }

    .overlay-btns {
        position: absolute;
        bottom: 10px;
        right: 10px;
        z-index: 999;
    }
</style>

<body>
    <div class="header">
        <img src="image/logo.png" alt="Logo" class="header-logo">
        <p class="header-text"><b>DENR CENRO WESTERN PANGASINAN</b></p>
        <a href="logout.php" class="btn-success"
            style="color: white; padding: 5px; background-color: red; margin-left: 750px;">
            Logout</a>
            <a href="#" data-toggle="modal" data-target="#gearModal"><img src="image/gear.png" class="header-logo"
                style="width: 50px; margin-left: 5px;"></a>

    </div>

    <div class="search-div">
        <form action="" method="POST">
            <input type="text" placeholder="Search..." name="userInput" class="search-bar">
            <input type="submit" class="btn-success" name="goSearch" value="Search">
        </form>
    </div>

    <div class="menu">
        <ul>
            <li><a href="admin-main.php" class="bg-white"
                    style="background-color: white; color: black;margin-top:25px;">Main List</a></li>
            <li><a href="admin-archived.php" class="btn-success" style="margin-top:20px;">Archive List</a></li>
        </ul>
    </div>


    <div class="table-container">
        <form action="officer-main-end.php" method="POST" enctype="multipart/form-data">
            <button class="btn btn-success" name="archiveBtn"
                onclick="return confirm('Are you sure you want to archive selected items?')">Archive</button>
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll" name="selectedItems"> All</th>
                        <th>Submit At</th>
                        <th>Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Number of Years</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    if (mysqli_num_rows($result) > 0) {
                        foreach ($result as $data) {
                            ?>
                            <tr>
                                <td><input type="checkbox" class="checkbox" name="selectedRecords[]"
                                        value="<?= $data['id']; ?>"></td>
                                <td>
                                    <?= $data['inserted_at']; ?>
                                </td>
                                <td>
                                    <?= $data['type']; ?>
                                </td>
                                <td>
                                    <?= $data['from']; ?>
                                </td>
                                <td>
                                    <?= $data['to']; ?>
                                </td>
                                <td>
                                    <?= $data['subject']; ?>
                                </td>
                                <td>
                                    <?= $data['date']; ?>
                                </td>
                                <td>
                                    <?= $data['no_of_year']; ?>
                                </td>
                                <td>
                                    <?= $data['remarks']; ?>
                                </td>
                                <td>
                                    <img src="Scanned/<?= $data['image']; ?>" alt="" style="width: 50px; height: 60px;">
                                </td>
                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#imageModal"
                                        data-id="<?= $data['id']; ?>" data-image="<?= $data['image']; ?>">View</button></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='10'>No records found</td></tr>";
                    }
                    ?>
                    <div class="form-group"><br>
                        <label for="importFile" style="width: 20%;margin-left: 79%;">Import Excel File:</label>
                        <input type="file" class="form-control" id="importFile" name="importFile" accept=".xlsx,.xls"
                            style="width: 20%;margin-left: 79%;">
                    </div>
                </tbody>
            </table>
            <div class="button-container">
                <a href="officer-form.php"><button type="button" class="import-btn">Insert</button></a>
                <button type="submit" class="export-btn" name="export">Export to Excel</button>
                <button type="submit" class="import-btn" name="import">Import from Excel</button>
            </div>
    </div>
    </form>
    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">View Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" class="img-fluid" id="modalImage" alt="No Image">
                    <div class="overlay-btns">
                        <button type="button" class="btn btn-success">Export</button>
                        <button type="button" class="btn btn-info">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add admin form -->
    <div class="modal fade" id="gearModal" tabindex="-1" role="dialog" aria-labelledby="gearModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gearModalLabel">Add Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="admin-main-end.php" method="POST">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Email address</label>
                            <input type="email" class="form-control" name="email" id="exampleFormControlInput1"
                                placeholder="name@example.com">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Password</label>
                            <input type="password" class="form-control" name="password" id="exampleFormControlInput1"
                                placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Example select</label>
                            <select class="form-control" name="role" id="exampleFormControlSelect1">
                                <!-- <option value="Admin">Admin</option> -->
                                <option value="Admin">Admin of DENR Alaminos</option>
                            </select>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="add">Save changes</button>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<script src="js/select.js"></script>
<script src="js/import.js"></script>
<script>
    $(document).ready(function () {
        $('#imageModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var image = button.data('image');

            var modal = $(this);
            modal.find('#id').val(id);
            modal.find('#modalImage').attr('src', 'Scanned/' + image);
        });
    });
</script>

</html>