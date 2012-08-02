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

   /*
   echo $userAuthKey;
   echo $numberOfOptions;
   echo $numbersOrLetters;
   echo $onOff;
   echo $surveyDescription;
   */

   if ($numbersOrLetters == 'Numbers') {
      $numbersOrLetters = 0;
   }
   else {
      $numbersOrLetters = 1;
   }

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
    $userAuthKey = $userAuthKey . '-' . $maxValue;


   $sql = "INSERT INTO $tbl_name (Survey_authKey, Number_of_options, Numbers_or_letters, On_Off, Survey_description, email) 
   VALUES ('$userAuthKey', '$numberOfOptions' , '$numbersOrLetters', '$onOff', '$surveyDescription', '$email')";

   $result = mysql_query($sql);

// if data is successfully inserted into database, displays message "Successful". 
   if($result){
      /*
      echo "made it";
      $letters = range('a','z');

    for ($i = 0; $i < $numberOfOptions; $i++) {
      var $insertOptions;

      if ($numbersOrLetters == 0) {

               $optionNumber = $i + 1;
               $insertOptions = "INSERT INTO Survey_results (Survey_authKey, Option_name, Option_value) 
                           VALUES ('$userAuthKey','$optionNumber', 0");
         }
      else {

               $insertOptions = "INSERT INTO Survey_results (Survey_authKey, Option_name, Option_value) 
                           VALUES ('$userAuthKey',letters[$i], 0");
         }

                  mysql_query($insertOptions);
      }
      */
      
         
      echo "Successful";
   }
   else {
      echo "Error";
   }

      // close connection 
   mysql_close();

?>