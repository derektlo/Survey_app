<?php
   
   // Set Database information
   
   // Database host
   $host = '205.178.146.112'; 
   // Database name
   $db = 'survey_app_db'; 
   // MySQL username
   $uid = 'derek_survey';
   // MySQL password
   $pwd = 'G0f1shn0w';
 
	// set restaurantID to get categories for selected restaurant
 	$email   = isset($_GET['email']) ? $_GET['email']  : "";
	
	// Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");
   
   // Create an array to hold our results
   $arr = array();
   
   //Execute the query
  // $rs = mysql_query("SELECT email FROM customer_information");
   $rs = mysql_query("SELECT Survey_id,Survey_authKey,Number_of_options,Numbers_or_letters,On_off, Survey_description, DATE_FORMAT(Date,\"%Y-%m-%d\") AS Date FROM Surveys WHERE Email = '$email'");
   
   // Add the rows to the array 
   while($obj = mysql_fetch_object($rs)) {
   $arr[] = $obj;
   }
   
   // return the json result.
   echo '{"Results":'.json_encode($arr).'}';


   // close connection 
   mysql_close();
?>