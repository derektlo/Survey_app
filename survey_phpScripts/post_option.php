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
   $optionName = isset($_GET['optionName']) ? $_GET['optionName']  : "";
   $surveyType = isset($_GET['surveyType']) ? $_GET['surveyType']  : "";

	// Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");

   $query;

   if ($surveyType != 'Specific') {
   //Execute the query
     $query = mysql_query("UPDATE Survey_Results SET Option_value = Option_value+1 
      WHERE Survey_authKey = '$surveyAuthKey' AND Option_name = '$optionName'");
   }
   else {

      $checkValue = mysql_query("SELECT Match_value FROM Survey_Specific_Response WHERE Match_value = '$optionName'");

      if (mysql_num_rows($checkValue) > 0) {
            $query = mysql_query("UPDATE Survey_Specific_Response SET Hits = Hits+1 
                                 WHERE Survey_authKey = '$surveyAuthKey' AND Matching_value = '$optionName'");
      }
      else {

         $varZero = 0;
         $keyValue = -1;

         $query = mysql_query("INSERT INTO Survey_Specific_Response (Survey_authKey, Matching_value, Key_value, Hits) 
                              VALUES ('$surveyAuthKey','$optionName','$keyValue','$varZero')");
      }
   }
   
   if ($query) {
      echo 'Successful';
   }
   else {
      echo 'Failure';
   }


   // close connection 
   mysql_close();
?>