<?php
 
if(isset($_POST['email'])) {
    $fixx_email = "you@yourdomain.com";
    $registrar_email = "you@yourdomain.com";

    function died($error) {
        //error code
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }

    // validation expected data exists
    if(!isset($_POST['name']) ||
        !isset($_POST['RIN']) ||
        !isset($_POST['email'])     ||
        !isset($_POST['telephone']) ||
        !isset($_POST['description'])) {
 
        died('The required fields were not completed.');       
 
    }

    $name = $_POST['name']; // required
    $RIN = $_POST['RIN']; // required
    $email_from = $_POST['email']; // required
    $description = $_POST['description']; // required 

    $email_subject = "Classroom Assessment";
 
    $error_message = "";
 
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    $string_exp = "/^[A-Za-z .'-]+$/";
    $RIN_exp = "/^[0-9]*/";

    if(!preg_match($email_exp,$email_from)) {
        $error_message .= 'The Email Address you entered does not appear to be valid. Please make sure you\'re using an RPI email.<br />';
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

    $email_message = "Form details below.\n\n";
 
    function clean_string($string) {
        $bad = array("content-type","bcc:","to:","cc:","href");
        return str_replace($bad,"",$string);
    }

    $email_message .= "First Name: ".clean_string($first_name)."\n";
    $email_message .= "Last Name: ".clean_string($last_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Telephone: ".clean_string($telephone)."\n";
    $email_message .= "Description: ".clean_string($description)."\n";
 
    // create email headers
     
    $headers = 'From: '.$email_from."\r\n".'Reply-To: '.$email_from."\r\n".'X-Mailer: PHP/'.phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);
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