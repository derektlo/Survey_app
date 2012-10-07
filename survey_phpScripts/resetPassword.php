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
   $email   = isset($_GET['email']) ? $_GET['email']  : "";
   $l_reset_key   = isset($_GET['resetKey']) ? $_GET['resetKey']  : "";

   $tbl_name = 'Password_reset';

   // Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");
   
    //Execute the query to create the account
   // Insert data into mysql
   $getHash = mysql_query("SELECT Reset_key FROM Password_Reset WHERE Email = '$email'");

  while($obj = mysql_fetch_object($getHash)) {

     $key_l = $obj->Reset_key; // you are fetching an object, not an array
  }

  if ($l_reset_key == $key_l) {

    $getTimeStamp = mysql_query("SELECT Creation_date FROM Password_Reset WHERE Email = '$email'");

    while($obj = mysql_fetch_object($getTimeStamp)) {

     $resetRequestTimestamp = $obj->Creation_date; // you are fetching an object, not an array
  }

  if (time() > (strtotime($resetRequestTimestamp) + 10800)){
    // reset has expired
    header('Location: http://www.classtempo.org/passwordResetError.html?expired=true');
  }
  else {
    // otherwise, re-direct the user to the proper password reset page
    header('Location: http://www.classtempo.org/passwordReset.html?email=' . $email);
    }

  }
  else {

    header('Location: http://www.classtempo.org/passwordResetError.html');
  }

  // close connection 
   mysql_close();

?>