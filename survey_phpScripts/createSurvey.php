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
   $userAuthKey          = isset($_GET['userAuthKey']) ? $_GET['userAuthKey']  : "";
   $numberOfOptions      = isset($_GET['numberOfOptions']) ? $_GET['numberOfOptions']  : "";
   $numbersOrLetters     = isset($_GET['numbersOrLetters']) ? $_GET['numbersOrLetters']  : "";
   $customSurveyTag_bool = isset($_GET['customSurveyTag_bool']) ? $_GET['customSurveyTag_bool']  : "";
   $customSurveyTag      = isset($_GET['customSurveyTag']) ? $_GET['customSurveyTag']  : "";
   $onOff                = isset($_GET['onOff']) ? $_GET['onOff']  : "";
   $surveyDescription = isset($_GET['surveyDescription']) ? $_GET['surveyDescription']  : "";
   $email                = isset($_GET['email']) ? $_GET['email']  : "";
   $matchValue;
   $customOptions;
   $matching;

   $surveyType = isset($_GET['surveyType']) ? $_GET['surveyType']  : "";

   if ($surveyType == 'Custom') {
   $customOptions = $_POST['customOptionsArray'];
   }
   else if ($surveyType == 'Specific') {
      $matching = isset($_GET['matching']) ? $_GET['matching']  : "";

      if ($matching == 'true')
         $matchValue = isset($_GET['matchValue']) ? $_GET['matchValue']  : "";
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


   if ($customSurveyTag_bool == 'true'){
      $checkSurveyTag = mysql_query("SELECT $customSurveyTag FROM Surveys")
      
      if (mysql_num_rows($checkSurveyTag) > 0) {
         exit('Error');
      }
   }
   else{
    $findMaxSQL = mysql_query("SELECT MAX(Survey_id) FROM Surveys");
    $row = mysql_fetch_array($findMaxSQL);
    $maxValue = $row[0] + 1;
    $surveyAuthKey = $userAuthKey . '-' . $maxValue;
   }


   $sql = "INSERT INTO $tbl_name (Survey_authKey, Number_of_options, Survey_type, On_Off, Survey_description, email) 
   VALUES ('$surveyAuthKey', '$numberOfOptions' , '$surveyType', '$onOff', '$surveyDescription', '$email')";

   $result = mysql_query($sql);

// if data is successfully inserted into database, displays message "Successful". 
   if($result){
      
      $letters = range('a','z');
      $varZero = 0;

if ($surveyType != 'Specific') {

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

                  mysql_query($insertOptions);
      }
   }
   else {
      $insertMatchingValue;
      if ($matching == 0) {
         // This is a matching survey.

             $insertMatchingValue = "INSERT INTO Survey_Specific_Response (Survey_authKey, Response, Key_value, Hits) 
                           VALUES ('$surveyAuthKey','$matchValue','$varZero','$varZero')";
          }
      else {
         // This is a free response survey
         // $varNegOne = -1;
         // $varFreeResponse = 'Free Response';

         //  $insertMatchingValue = "INSERT INTO Survey_Specific_Response (Survey_authKey, Matching_value, Key_value, Hits) 
         //                   VALUES ('$surveyAuthKey','$varFreeResponse','$varNegOne','$varZero')";
      }

      mysql_query($insertMatchingValue);
   }
      
      
      echo "$surveyAuthKey";
   }
   else {
      echo "Error";
   }

      // close connection 
   mysql_close();

?>