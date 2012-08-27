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
   $_subject   = isset($_GET['subject']) ? $_GET['subject']  : "";
   $message   = isset($_GET['message']) ? $_GET['message']  : "";
   $from = isset($_GET['from']) ? $_GET['from']  : "";

   $arrayOfUsers = array();

   foreach ($arrayOfUsers as $value) {

      $to = $value;
      $subject = $_subject;
      $txt = "Welcome to Class Tempo! \n Activate your account by clicking the following link: http://www.classtempo.org/Survey_app/survey_phpScripts/activate.php?email=" . $email . "&key=" . $activateHash . " If the link's broken,
      please paste it into your browser!";
      $headers = "From: no-reply@classtempo.org";

      mail($to,$subject,$txt,$headers);

   }


      // close connection 
   mysql_close();
?>