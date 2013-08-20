<?php

/*
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
    define("saltValue",$salt);
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

   function create_hash_with_salt($password,$salt)
{
    // format: algorithm:iterations:salt:hash
    define("saltValue",$salt);
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

// Compares two strings $a and $b in length-constant time.
function slow_equals($a, $b)
{
    $diff = strlen($a) ^ strlen($b);
    for($i = 0; $i < strlen($a) && $i < strlen($b); $i++)
    {
        $diff |= ord($a[$i]) ^ ord($b[$i]);
    }
    return $diff === 0; 
}

/*
 * PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
 * $algorithm - The hash algorithm to use. Recommended: SHA256
 * $password - The password.
 * $salt - A salt that is unique to the password.
 * $count - Iteration count. Higher is better, but slower. Recommended: At least 1000.
 * $key_length - The length of the derived key in bytes.
 * $raw_output - If true, the key is returned in raw binary format. Hex encoded otherwise.
 * Returns: A $key_length-byte key derived from the password and salt.
 *
 * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
 *
 * This implementation of PBKDF2 was originally created by https://defuse.ca
 * With improvements by http://www.variations-of-shadow.com
 */
/*
function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false)
{
    $algorithm = strtolower($algorithm);
    if(!in_array($algorithm, hash_algos(), true))
        die('PBKDF2 ERROR: Invalid hash algorithm.');
    if($count <= 0 || $key_length <= 0)
        die('PBKDF2 ERROR: Invalid parameters.');

    $hash_length = strlen(hash($algorithm, "", true));
    $block_count = ceil($key_length / $hash_length);

    $output = "";
    for($i = 1; $i <= $block_count; $i++) {
        // $i encoded as 4 bytes, big endian.
        $last = $salt . pack("N", $i);
        // first iteration
        $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
        // perform the other $count - 1 iterations
        for ($j = 1; $j < $count; $j++) {
            $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
        }
        $output .= $xorsum;
    }

    if($raw_output)
        return substr($output, 0, $key_length);
    else
        return bin2hex(substr($output, 0, $key_length));
}
*/


















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
   //echo $email;

	/// Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");
   
   $tbl_name = 'Survey_Accounts';

   //Execute the query to create the account
   $checkEmail = mysql_query("SELECT Email FROM Survey_Accounts WHERE Email = '$email'");


   if (!$checkEmail) {
      die('Query failed');
   }

   if (mysql_num_rows($checkEmail) > 0) { // if email exists

// good...
   // $hashQuery = mysql_query("SELECT Password FROM Survey_Accounts WHERE Email = '$email'");
   // $saltQuery = mysql_query("SELECT Salt FROM Survey_Accounts WHERE Email = '$email'");
    
   // $hash = mysql_result($hashQuery, 0);
   // $salt = mysql_result($saltQuery, 0);

    //  $currentHash = create_hash_with_salt($password,$salt);

    echo $oldPassword;

    echo 'here';

    echo $password;

    echo 'blabhbab';

    $oldPassword = mysql_query("SELECT Password FROM Survey_Accounts WHERE Email = '$email'");

      // if password matches
      if($oldPassword === $password){

           $checkActiveAccount = mysql_query("SELECT Active FROM Survey_Accounts WHERE Email = '$email'");

            $activeNum = mysql_result($checkActiveAccount, 0);

            if ($activeNum == 0){           


              $incrementLoginTimes = mysql_query("UPDATE Survey_Accounts SET Login_times = Login_times + 1 WHERE Email = '$email'");

               $getUserTag = mysql_query("SELECT User_tag FROM Survey_Accounts WHERE Email = '$email'");
              // Add the rows to the array 
              while($obj = mysql_fetch_object($getUserTag)) {
                $usertag[] = $obj;
              }

              $getUserClasses = mysql_query("SELECT Full_class_name, School FROM Classes WHERE Email = '$email'");
       
              // Add the rows to the array 
              while($obj = mysql_fetch_object($getUserClasses)) {
                $userClasses[] = $obj;
              }

              $container = array();

              array_push($container,$usertag,$userClasses);


       // return the json result.
          echo '{"Results":'.json_encode($container).'}';
        }
        else {
          echo '{"Results":'.json_encode('Not Active').'}';
        }
      }
      else {echo '{"Results":' .json_encode("Invalid Password or Email.").'}';}

   }
   else{ // email does not exist
         echo '{"Results":' .json_encode("Invalid Password or Email.").'}';
   }

   // close connection 
   mysql_close();

?>