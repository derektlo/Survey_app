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
   $callbackValue = isset($_GET['callback']) ? $_GET['callback']  : "";
	
	// Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");
   
   // Create an array to hold our results
   $arr = array();
   $hi = "march";
   //Execute the query
  // $rs = mysql_query("SELECT email FROM customer_information");
   $rs = mysql_query("SELECT Survey_id,Survey_authKey,Number_of_options,Numbers_or_letters,On_off, Survey_description, DATE_FORMAT(Date,\"%b %e %Y\") AS Date FROM Surveys WHERE Email = '$email'");
   
   // Add the rows to the array 
   while($obj = mysql_fetch_object($rs)) {
   $arr[] = $obj;
   }
   
   // return the json result.
   //echo '{"Results":'.json_encode($arr).'}';
   echo $callbackValue . '(' . json_encode($arr) . ')';

   // close connection 
   mysql_close();
?>