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
 
	// get the email and password for a user
   $email   = isset($_GET['email']) ? $_GET['email']  : "";
   $password   = isset($_GET['password']) ? $_GET['password']  : "";
   $hashedPassword = sha1($password);
   //echo $email;

	/// Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");
   
   $tbl_name = 'Survey_Accounts';

   //Execute the query to create the account
   // Insert data into mysql
   $checkEmail = mysql_query("SELECT Email FROM Survey_Accounts WHERE Email = '$email'");
   $getUserTag = mysql_query("SELECT User_tag FROM Survey_Accounts WHERE Email = '$email' AND Password = '$hashedPassword'");


   if (!$checkEmail) {
      die('Query failed');
   }

   if (mysql_num_rows($checkEmail) > 0) { // if email exists
    $currentHashedPasswordQuery = mysql_query("SELECT Password FROM Survey_Accounts WHERE Email = '$email'");
      $currentHashedPassword = mysql_result($currentHashedPasswordQuery, 0);

      if($hashedPassword == $currentHashedPassword){
          // Add the rows to the array 
          while($obj = mysql_fetch_object($getUserTag)) {
            $arr[] = $obj;
          }
   
   // return the json result.
      echo '{"Results":'.json_encode($arr).'}';


      }
      else echo "Invalid Password";

   }
   else{ // email does not exist
         echo "Email does not exist.";
   }

   // close connection 
   mysql_close();

?>