<?php
if (isset($_POST["submit"])) {
    // Checking For Blank Fields..
    if ($_POST["vname"]==""||$_POST["vemail"]==""||$_POST["msg"]=="") {
        echo "Please Fill All Fields";
    } else {
        // Check if the "Sender's Email" input field is filled out
        $email=$_POST['vemail'];
        // Sanitize E-mail Address
        $email =filter_var($email, FILTER_SANITIZE_EMAIL);
        // Validate E-mail Address
        $email= filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$email) {
            echo "Invalid Email Address<br>";
        } else {
            $name = $_POST['vname'];
            $message = $_POST['msg'];
            $headers = 'From:'. $email . "\r\n". // Sender's Email
                        'Cc:'. $email . "\r\n". // Carbon copy to Sender
                        'Reply-To: '. $email ."\r\n" .
                        'X-Mailer: PHP/' . phpversion();
            // Message lines should not exceed 70 characters (PHP rule), so wrap it
            $message = wordwrap($message, 70);
            // Send Mail By PHP Mail Function
            mail("richardrandell2@outlook.com", $name, $message, $headers);
            echo "Your mail has been sent successfuly!" . "<br>Please allow 24 to 48 hours for a reply<br>";
        }
    }
}
