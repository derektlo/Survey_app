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
 	$surveyAuthKey   = isset($_GET['surveyAuthKey']) ? $_GET['surveyAuthKey']  : "";
   $optionName = isset($_GET['optionName']) ? $_GET['optionName']  : "";
	
   echo $surveyAuthKey;
   echo $optionName;

	// Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");
   
   // Create an array to hold our results
   $arr = array();
   
   //Execute the query
     $rs = mysql_query("UPDATE Options SET Option_value = Option_value+1 
      WHERE Survey_authKey = '$surveyAuthKey' AND Option_name = '$optionName'");
   
   if ($rs) {
      echo 'Successful';
   }
   else {
      echo 'Failure';
   }


   // close connection 
   mysql_close();
?>