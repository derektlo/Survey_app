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
   $surveyType   = isset($_GET['surveyType']) ? $_GET['surveyType']  : "";
	
	// Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");
   
   // Create an array to hold our results
   $arrayOfOptionsValues = array();
   
   if (($surveyType == "Letters") || ($surveyType == "Numbers") || ($surveyType == "Custom")) {

      // GATHER ALL RESULTS FROM THE SURVEY
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

   if ($surveyType == 'Custom') {
      
      // GATHER ALL OPTIONS FROM THE SURVEY BECAUSE THEY ARE CUSTOM
      $options = mysql_query("SELECT Option_name FROM Survey_Results WHERE Survey_authKey = '$surveyAuthKey'");
      $arrayOfOptions = array();

      while($holdObj = mysql_fetch_array($options)) {
      $arrayOfOptions[] = $holdObj['Option_name'];
      }
          // GENERATE FINAL ARRAY TO BE SENT BACK TO APP
         array_push($container,$arrayOfOptionsValues,$arrayOfPercents, $arrayOfOptions);
   }
   else {
   
   // GENERATE FINAL ARRAY TO BE SENT BACK TO APP
   array_push($container,$arrayOfOptionsValues,$arrayOfPercents);
   }
   
   // return the json result.
   echo '{"Results":'.json_encode($container).'}';
   }

   // close connection 
   mysql_close();
?>