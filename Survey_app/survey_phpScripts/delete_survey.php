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
 	$surveyID   = isset($_GET['surveyID']) ? $_GET['surveyID']  : "";
   $surveyAuthKey   = isset($_GET['surveyAuthKey']) ? $_GET['surveyAuthKey']  : "";

	// Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");
   
   //Execute the query to delete survey
     $rs = mysql_query("DELETE FROM Surveys WHERE Survey_id = '$surveyID'");
   
   if ($rs) {

         $rs = mysql_query("DELETE FROM Survey_Results WHERE Survey_authKey = '$surveyAuthKey'");


      echo 'Successful';
   }
   else {
      echo 'Failure';
   }


   // close connection 
   mysql_close();
?>