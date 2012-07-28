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
   $email   = isset($_GET['email']) ? $_GET['email']  : "";
   $surveyTag   = isset($_GET['surveyTag']) ? $_GET['surveyTag']  : "";
   $password = isset($_GET['password']) ? $_GET['password']  : "";
   $hashed_password = sha1($password);

   $tbl_name = 'Survey_Accounts';

   // Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");
   
 //Execute the query to create the account
   // Insert data into mysql
   $checkEmail = mysql_query("SELECT Email FROM Survey_Accounts WHERE Email = '$email'");

   if (!$checkEmail) {
      die('Query failed');
   }

   if (mysql_num_rows($checkEmail) > 0) {
      echo "Email already exists.";
   }
   else{

   $sql = "INSERT INTO $tbl_name (Email, User_tag, Password) 
   VALUES ('$email', '$surveyTag' , '$hashed_password')";

   $result = mysql_query($sql);

// if data is successfully inserted into database, displays message "Successful". 
   if($result){
      echo "Successful";
   }
   else {
      echo "Error";
   }
}

      // close connection 
   mysql_close();

?>