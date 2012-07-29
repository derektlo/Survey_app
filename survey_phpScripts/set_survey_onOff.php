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
   $onOff      = isset($_GET['onOff']) ? $_GET['onOff']  : "";

	// Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");
   
   // Create an array to hold our results
   $arr = array();
   
   //Execute the query to turn survey on or off
   if ($onOff > 0) {
      // create query to turn survey OFF
      $rs = mysql_query("UPDATE Surveys SET On_off = 1
      WHERE Survey_id = '$surveyID'");
   }
   else {
      // create query to turn survey ON
      $rs = mysql_query("UPDATE Surveys SET On_off = 0
      WHERE Survey_id = '$surveyID'");
   }
   
   if ($rs) {
      echo 'Successful';
   }
   else {
      echo 'Failure';
   }


   // close connection 
   mysql_close();
?>