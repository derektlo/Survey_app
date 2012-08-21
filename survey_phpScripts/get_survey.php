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
 //  $arr = array();
   $arr;
   //Execute the query
  // $rs = mysql_query("SELECT email FROM customer_information");
   $getSurveyType = mysql_query("SELECT Survey_type FROM Surveys WHERE Survey_authKey = '$surveyAuthKey'");


   $rs = mysql_query("SELECT Survey_id,Number_of_options,Survey_type FROM Surveys WHERE Survey_authKey = '$surveyAuthKey'");
   
   while($obj = mysql_fetch_object($rs)) {
       $arr = $obj; // save the row
       $surveyType = $obj->Survey_type; // you are fetching an object, not an array
   }

   echo $arr->Survey_type;

   if ($surveyType == 'Custom')
         echo 'custom';
   
   // return the json result.
   echo '{"Results":'.json_encode($arr).'}';


   // close connection 
   mysql_close();
?>