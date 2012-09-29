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
   $className = isset($_GET['className']) ? $_GET['className']  : "";
   $school = isset($_GET['school']) ? $_GET['school']  : "";
   $classSize = isset($_GET['classSize']) ? $_GET['classSize']  : "";

   // Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");

   $query;

      $query = mysql_query("UPDATE Classes SET Full_class_name = $className, School = $school, Class_size = $classSize WHERE Email = $email");
   

   if ($query) {
      echo 'Successful';
   }
   else {
      echo 'Error';
   }


   // close connection 
   mysql_close();
?>