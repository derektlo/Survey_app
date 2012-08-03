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
 
	// get the email and password for a user
   $email   = isset($_GET['email']) ? $_GET['email']  : "";
   $password   = isset($_GET['password']) ? $_GET['password']  : "";
   $hashedPassword = sha1($password);
   $callbackValue = isset($_GET['callback']) ? $_GET['callback']  : "";
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
     // echo '{"Results":'.json_encode($arr).'}';
          echo $callbackValue . '(' . json_encode($arr) . ')';
      }
      else echo '{"Results":' .json_encode("Invalid Password or Email.").'}';

   }
   else{ // email does not exist
         echo '{"Results":' .json_encode("Invalid Password or Email.").'}';
   }

   // close connection 
   mysql_close();

?>