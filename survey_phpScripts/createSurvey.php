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
   $userAuthKey = isset($_GET['userAuthKey']) ? $_GET['userAuthKey']  : "";
   $numberOfOptions   = isset($_GET['numberOfOptions']) ? $_GET['numberOfOptions']  : "";
   $numbersOrLetters   = isset($_GET['numbersOrLetters']) ? $_GET['numbersOrLetters']  : "";
   $onOff = isset($_GET['onOff']) ? $_GET['onOff']  : "";
   $surveyDescription = isset($_GET['surveyDescription']) ? $_GET['surveyDescription']  : "";
   $email = isset($_GET['email']) ? $_GET['email']  : "";

   $surveyType = isset($_GET['surveyType']) ? $_GET['surveyType']  : "";

   if ($surveyType == 'Custom') {
   $customOptions = $_POST['customOptionsArray'];
   }
   else if ($surveyType == 'Specific') {
      $specificResponse = isset($_GET['surveyType']) ? $_GET['surveyType']  : "";
   }


   /*
   echo $userAuthKey;
   echo $numberOfOptions;
   echo $numbersOrLetters;
   echo $onOff;
   echo $surveyDescription;
   */

   if ($onOff == 'On') {
      $onOff = 0;
   }
   else {
      $onOff = 1;
   }

   $tbl_name = 'Surveys';

   // Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");


    $findMaxSQL = mysql_query("SELECT MAX(Survey_id) FROM Surveys");
    $row = mysql_fetch_array($findMaxSQL);
    $maxValue = $row[0] + 1;
    $surveyAuthKey = $userAuthKey . '-' . $maxValue;


   $sql = "INSERT INTO $tbl_name (Survey_authKey, Number_of_options, Survey_type, On_Off, Survey_description, email) 
   VALUES ('$surveyAuthKey', '$numberOfOptions' , '$surveyType', '$onOff', '$surveyDescription', '$email')";

   $result = mysql_query($sql);

// if data is successfully inserted into database, displays message "Successful". 
   if($result){
      
      $letters = range('a','z');
      $varZero = 0;

    for ($i = 0; $i < $numberOfOptions; $i++) {
      $insertOptions;

      if ($surveyType == 'Numbers') {

               $optionNumber = $i + 1;
               $insertOptions = "INSERT INTO Survey_Results (Survey_authKey, Option_name, Option_value) 
                           VALUES ('$surveyAuthKey','$optionNumber','$varZero')";
         }
      else if ($surveyType == 'Letters'){
               $currentValue = $letters[$i];

               $insertOptions = "INSERT INTO Survey_Results (Survey_authKey, Option_name, Option_value) 
                           VALUES ('$surveyAuthKey','$currentValue','$varZero')";
         }
      else if ($surveyType == 'Custom') {
               $currentValue = $customOptions[$i];

               $insertOptions = "INSERT INTO Survey_Results (Survey_authKey, Option_name, Option_value) 
                           VALUES ('$surveyAuthKey','$currentValue','$varZero')";
      }
      else if ($surveyType == 'Specific') {

      }

                  mysql_query($insertOptions);
      }
      
      
         
      echo "$surveyAuthKey";
   }
   else {
      echo "Error";
   }

      // close connection 
   mysql_close();

?>