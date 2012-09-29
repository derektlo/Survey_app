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
   $schoolName = isset($_GET['schoolName']) ? $_GET['schoolName']  : "";

   // Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");

   $query;

      $query = mysql_query("UPDATE Survey_Accounts SET School = '$schoolName' WHERE Email = '$email'");
   

   if ($query) {
      echo 'Successful';
   }
   else {
      echo 'Error';
   }


   // close connection 
   mysql_close();
?>