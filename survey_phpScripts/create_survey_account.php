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
   $userTag   = isset($_GET['userTag']) ? $_GET['userTag']  : "";
   $password = isset($_GET['password']) ? $_GET['password']  : "";
   $salt;

   // These constants may be changed without breaking existing hashes.
define("PBKDF2_HASH_ALGORITHM", "sha256");
define("PBKDF2_ITERATIONS", 1000);
define("PBKDF2_SALT_BYTES", 24);
define("PBKDF2_HASH_BYTES", 24);

define("HASH_SECTIONS", 4);
define("HASH_ALGORITHM_INDEX", 0);
define("HASH_ITERATION_INDEX", 1);
define("HASH_SALT_INDEX", 2);
define("HASH_PBKDF2_INDEX", 3);

   function create_hash($password)
{
    // format: algorithm:iterations:salt:hash
    $salt = base64_encode(mcrypt_create_iv(PBKDF2_SALT_BYTES, MCRYPT_DEV_URANDOM));
    return PBKDF2_HASH_ALGORITHM . ":" . PBKDF2_ITERATIONS . ":" .  $salt . ":" . 
        base64_encode(pbkdf2(
            PBKDF2_HASH_ALGORITHM,
            $password,
            $salt,
            PBKDF2_ITERATIONS,
            PBKDF2_HASH_BYTES,
            true
        ));
}

   $tbl_name = 'Survey_Accounts';

   // Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");
   
 //Execute the query to create the account
   // Insert data into mysql
   $checkEmail = mysql_query("SELECT Email FROM Survey_Accounts WHERE Email = '$email'");
   $checkTag = mysql_query("SELECT User_tag FROM Survey_Accounts WHERE User_tag = '$userTag'");

   if (!$checkEmail) {
      die('Query failed');
   }

   if (mysql_num_rows($checkEmail) > 0) {
      echo "Email already exists.";
   }
   else if (mysql_num_rows($checkTag) > 0) {

      echo "User tag already exists.";
   }
   else {
   
   $securePassword = create_hash($password);
   echo $securePassword;

   $sql = "INSERT INTO $tbl_name (Email, User_tag, Password, Salt) 
   VALUES ('$email', '$userTag' , '$securePassword', '$salt')";

   $result = mysql_query($sql);

// if data is successfully inserted into database, displays message "Successful". 
   if($result){
      echo "Successful";
   }
   else {
      echo "Error";
      }
   }
}

      // close connection 
   mysql_close();

?>