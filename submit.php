<?php

if(isset($_POST['email'])) {
    require "sendto.php"; //Included the sending addresses there
    //The above file must define the following two variables with valid emails:
    //$fixx_email and $registrar_email

    function died($error) {
        //error code
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }

    // validation expected data exists
    if(!isset($_POST['name'])  || !isset($_POST['RIN'])         ||
       !isset($_POST['email']) || !isset($_POST['building'])    ||
       !isset($_POST['room'])  || !isset($_POST['description']) ||
       !isset($_POST['secured'])) {
        died('The required fields were not completed.');       
 
    }

    $name           = $_POST['name'];
    $RIN            = $_POST['RIN'];
    $email_from     = $_POST['email'];
    $building       = $_POST['building'];
    $room           = $_POST['room'];
    $description    = $_POST['description'];
    $secured        = $_POST['secured'];

    $error_message  = "";

    //Regular Expressions for validity checking
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    $string_exp = "/^[A-Za-z .'-]+$/";
    $RIN_exp = "/^[0-9]*/";

    if(!preg_match($email_exp,$email_from)) {
        $error_message .= 'The Email Address you entered does not appear to be valid. Please make sure you\'re using your RPI email.<br />';
    }
    if(!preg_match($string_exp,$name)) {
        $error_message .= 'The Name you entered does not appear to be valid.<br />';
    }
    if(!preg_match($RIN_exp,$RIN)) {
        $error_message .= 'The RIN you entered does not appear to be valid.<br />';
    }
    if(strcmp($room, "Building")) {
        $error_message .= 'You didn\'t select a building.<br />';
    }
    if(strlen($description) < 2) {
        $error_message .= 'The Description you entered do not appear to be valid.<br />';
    }
    if(strlen($error_message) > 0) {
        died($error_message);
    }

    $email_message = "Assessment details below.\n\n";
 
    function clean_string($string) {
        $bad = array("content-type","bcc:","to:","cc:","href");
        return str_replace($bad,"",$string);
    }

    $email_subject  = "Classroom Assessment: " . $building;

    $email_message .= "Object is " . ucfirst($secured) . "\n";
    $email_message .= "Name: "     . clean_string($name) . "\n";
    $email_message .= "RIN: "      . clean_string($RIN) . "\n";
    $email_message .= "Email: "    . clean_string($email_from) . "\n";
    $email_message .= "Location: " . clean_string($building) . ", " . clean_string($room) . "\n";
    $email_message .= "Description: " . clean_string($description) . "\n";
 
    // create email headers
    $headers = 'From: '.$email_from."\r\n".'Reply-To: '.$email_from."\r\n".'X-Mailer: PHP/'.phpversion();


    @mail($registrar_email, $email_subject, $email_message, $headers);

    if(strcmp($secured, "bolted")) {
        @mail($fixx_email, $email_subject, $email_message, $headers);
    }
?>
 
<!DOCTYPE html>
<html>
<head>
    <title>Classroom Assessment Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <div class="logo"></div>
                <p>Thank you for notifying us about the problem! The information has been passed on to the appropriate administrative bodies.</p>
                <br>
                <p class="footer">Created jointly by the Web Technologies Group &amp; the Facilities and Services Committee.<br />Rensselaer Union 45th Student Senate</p>
        </div>
    </div>
</body>
</html>

<?php } ?>