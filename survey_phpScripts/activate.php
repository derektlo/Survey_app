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
   $hash   = isset($_GET['key']) ? $_GET['key']  : "";

   $tbl_name = 'Survey_Accounts';

   // Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");
   
 //Execute the query to create the account
   // Insert data into mysql
   $getHash = mysql_query("SELECT Activate_hash FROM Survey_Accounts WHERE Email = '$email'");


   if (!$getHash) {
      die('Query failed');
   }

  while($obj = mysql_fetch_object($getHash)) {
     $activate_hash_l = $obj; // save the row
  }

 $activate_hash_l->Activate_hash;  // you can access it here too

  if ($hash == $activate_hash_l) {

      mysql_query("UPDATE Survey_Accounts SET Active = 0 WHERE Email = '$email'");

      header( 'Location: http://www.classtempo.org/successfulActivation.html' ) ;
  }
  else {
    header( 'Location: http://www.classtempo.org/errorActivation.html' ) ;
  }

  // close connection 
   mysql_close();
}

?>