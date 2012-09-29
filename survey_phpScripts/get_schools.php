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
	
	// Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");
   
   // Create an iVar to hold our results
   $schoolsArray = array();
   //Execute the query
   $rs = mysql_query("SELECT School FROM Survey_Accounts WHERE Email = '$email'");
   
   while($obj = mysql_fetch_object($rs)) {
       $schoolsArray[] = $obj;
   }
   
   // return the json result.
   echo '{"Results":'.json_encode($schoolsArray).'}';


   // close connection 
   mysql_close();
?>