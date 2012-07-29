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
	
	// Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");
   
   // Create an array to hold our results
   $arr = array();
   
   //Execute the query
  // $rs = mysql_query("SELECT email FROM customer_information");
   $rs = mysql_query("SELECT Average,Standard_deviation FROM Surveys_Analytics WHERE Survey_id = '$surveyID'");
   
   // Add the rows to the array 
   while($obj = mysql_fetch_object($rs)) {
   $arr[] = $obj;
   }
   
   // return the json result.
   echo '{"Results":'.json_encode($arr).'}';


   // close connection 
   mysql_close();
?>