<?php
include 'officer-sessions.php';
include 'config.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Better Life Medical Clinic</title>
    <link rel="stylesheet" href="css/result.css">
    <link rel="stylesheet" type="text/css" href="css/print.css" media="print">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>
    <div class="whole_con">
        <div class="invoice_container">
            <div class="menu" id="print-btn">
                <div class="toggle" id="toggle" onclick="expand()">
                    <i class="material-icons" id="toggle1">
                        add
                    </i>
                </div>
                <div class="items" id="items">
                    <a href="#" id="item1" onclick="window.print();">
                        <i class="material-icons">
                            print
                        </i>
                    </a>
                    <?php
                    if (isset($_GET['id'])) {
                        $id = mysqli_real_escape_string($con, $_GET['id']);
                        $query = "SELECT * FROM docs WHERE id='$id' ";
                        $query_run = mysqli_query($con, $query);
                        if (mysqli_num_rows($query_run) > 0) {
                            $row = mysqli_fetch_array($query_run);
                            ?>

                            <a href="officer-main.php" id="item2">
                                <i class="material-icons">
                                    home
                                </i>
                            </a>
                        </div>
                    </div>
                    <script>
                        var state = false;
                        function expand() {
                            if (state == false) {
                                document.getElementById('items').style.transform = 'scaleX(1)';
                                document.getElementById('toggle1').style.transform = 'rotate(45deg)';

                                state = true;
                            }
                            else {
                                document.getElementById('items').style.transform = 'scaleX(0)';
                                document.getElementById('toggle1').style.transform = 'rotate(0deg)';
                                state = false;
                            }
                        }
                    </script>
                    <h2><b>BETTER LIFE MEDICAL CLINIC</b></h2>
                    <p><i>"Making Lives Healthy And Better"</i></p>
                    <br>
                    <div class="patient_container">
                        <img src="Scanned/<?= $row['image']; ?>" class="img-fluid" id="modalImage" alt="No Image"
                            style="width: 100%; height: 100%;">
                    </div>






                    <div class="signed">
                        <div class="signedBy">
                            <p>
                                </h3><b>Geraldine M. Agpes</b></h3><br>Pathologist</p>
                        </div>
                        <div class="signedBy">
                            <p>
                                </h3><b>Kelvin Albert A. Danao, RMT</b></h3><br>Medical Technologist</p>

                        </div>
                    </div><br><br>


                    <div class="address">
                        <p>
                            </h1><b>BETTER LIFE MEDICAL CLINIC</b></h1><br>F.REINOSO ST. POBLACION ALAMINOS CITY<br>Beside Suki,
                            Alaminos</p>
                    </div>
        </body>

        </html>
        <?php
                        }
                    } else {
                        echo "<h5> No Record Found </h5>";
                    }
                    ?>