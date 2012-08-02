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
 	$surveyAuthKey   = isset($_GET['surveyAuthKey']) ? $_GET['surveyAuthKey']  : "";
	
	// Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");
   
   // Create an array to hold our results
   $arrayOfOptionsValues = array();
   
   $result = mysql_query("SELECT Option_value FROM Survey_Results WHERE Survey_authKey = '$surveyAuthKey'");

   // Add the rows to the array 
   while($holdObj = mysql_fetch_array($result)) {
   $arrayOfOptionsValues[] = $holdObj['Option_value'];
   }

   $total = array_sum($arrayOfOptionsValues);

   $arrayOfPercents = array_map(function($a) use($total){
    return round(($a*100) / $total, 1) . '%';
   }, $arrayOfOptionsValues);

   $container = array();
   array_push($container,$arrayOfOptionsValues,$arrayOfPercents);
   
   // return the json result.
   echo '{"Results":'.json_encode($container).'}';

   // close connection 
   mysql_close();
?>