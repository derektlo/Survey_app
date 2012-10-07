<?php
   
   // Set Database information
   
   // Database host
   $host = '50.112.249.251'; 
   // Database name
   $db = 'survey_app_db'; 
   // MySQL username
   $uid = 'external_user';
   // MySQL password
   $pwd = 'jTJW7xTn8MrjDyRd';
 
   // set restaurantID to get categories for selected restaurant
   $email   = isset($_GET['email']) ? $_GET['email']  : "";

   $tbl_name = 'Survey_Accounts';

   // Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");
   
  $checkEmail = mysql_query("SELECT Email FROM Survey_Accounts WHERE Email = '$email'");

   if (!$checkEmail) {
      die('Query failed');
   }

   if (mysql_num_rows($checkEmail) > 0) {
     // send reset email to this address

    $resetHash = md5(uniqid(mt_rand(),true));

    mysql_query("INSERT INTO Password_Reset (Email, Key) VALUES ('$email','$resetHash')");

    $emailSubject = "Class Tempo - Password Reset";

    $to = $email;
    $subject .= "".$emailSubject."";
    $headers .= "From: no-reply@classtempo.org\r\n" .
       "X-Mailer: php";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $message = "<html><body>";
    $message .= "Greetings from Class Tempo! \n To reset your password simply click the following link: http://www.classtempo.org/Survey_app/survey_phpScripts/resetPassword.php?email=". $email . "key=" . $resetHash . " \n If the link\'s broken, please paste it into your browser!";

    mail($to, $subject, $message, $headers);
   }
   else {
    // email address does not exist...
      echo 'Error';
   }

  // close connection 
   mysql_close();

?>