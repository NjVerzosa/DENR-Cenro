<?php
session_start();
$message = ""; // Initialize the message variable

if(isset($_POST["iForgot"])){

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
    $email = validate($_POST['email']);

    $email = mysqli_real_escape_string($con, $email);


    if($email){
        require "Mail/phpmailer/PHPMailerAutoload.php";
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host='smtp.gmail.com';
        $mail->Port=587;
        $mail->SMTPAuth=true;
        $mail->SMTPSecure='tls';

        $mail->Username='gsovehiclereservation@gmail.com';
        $mail->Password='okxb ddwf ceyk zntr';
        

        $mail->setFrom('gsovehiclereservation@gmail.com', 'DENR CENRO - Alaminos');
        $mail->addAddress($_POST["email"]);

        $mail->isHTML(true);
        $mail->Subject="Your Recovery PIN Code";
        $mail->Body="<p>Authorized, </p> <h3>Your pin OTP code is 12345 <br></h3>";

                if(!$mail->send()){
                    $message = "Something wrong, Please check your email inbox";   
                }else{
                    
                    $_SESSION['error'] = false;
                    $_SESSION['message'] = "We sent a code for verification";
                    header("location: index.php");
                    exit();
                        
                }
    }
}

?>