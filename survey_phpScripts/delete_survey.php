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
 	$surveyID   = isset($_GET['surveyID']) ? $_GET['surveyID']  : "";

	// Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");
   
   // Create an array to hold our results
   $arr = array();
   
   //Execute the query to delete survey
     $rs = mysql_query("DELETE FROM Surveys WHERE Survey_id = '$surveyID'");
   
   if ($rs) {
      echo 'Successful';
   }
   else {
      echo 'Failure';
   }


   // close connection 
   mysql_close();
?>