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
   
   // Create an iVar to hold our results
   $surveyInformation;
   //Execute the query
   $rs = mysql_query("SELECT Survey_id,Number_of_options,Survey_type,Survey_description FROM Surveys WHERE Survey_authKey = '$surveyAuthKey'");
   
   while($obj = mysql_fetch_object($rs)) {
       $surveyInformation = $obj; // save the row
       $surveyType = $obj->Survey_type; // you are fetching an object, not an array
   }

  $container = array();

   if ($surveyType == 'Custom') {
      
      // GATHER ALL OPTIONS FROM THE SURVEY BECAUSE THEY ARE CUSTOM
      $options = mysql_query("SELECT Option_name FROM Survey_Results WHERE Survey_authKey = '$surveyAuthKey'");
      $arrayOfOptions = array();

      while($holdObj = mysql_fetch_array($options)) {
      $arrayOfOptions[] = $holdObj['Option_name'];
      }
          // GENERATE FINAL ARRAY TO BE SENT BACK TO APP
         array_push($container,$surveyInformation, $arrayOfOptions);
   }
   else {
   
   // GENERATE FINAL ARRAY TO BE SENT BACK TO APP
   array_push($container,$surveyInformation);
   }
   
   // return the json result.
   echo '{"Results":'.json_encode($container).'}';


   // close connection 
   mysql_close();
?>