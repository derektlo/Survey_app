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

   $dsn = 'mysql:host=50.112.249.251;dbname=survey_app_db';
 
	// set restaurantID to get categories for selected restaurant
 	$surveyAuthKey   = isset($_GET['surveyAuthKey']) ? $_GET['surveyAuthKey']  : "";
   $surveyType   = isset($_GET['surveyType']) ? $_GET['surveyType']  : "";
	
	// Connect to the Database server   
    $link = mysql_connect($host, $uid, $pwd) or die("Could not connect");
   
   //select the Database
   mysql_select_db($db) or die("Could not select database");
   
   // Create an array to hold our results
   $arrayOfOptionsValues = array();
   
   if (($surveyType == "Letters") || ($surveyType == "Numbers") || ($surveyType == "Custom")) {

      // GATHER ALL RESULTS FROM THE SURVEY
   $result = mysql_query("SELECT Option_value FROM Survey_Results WHERE Survey_authKey = '$surveyAuthKey'");

   // Add the rows to the array 
   while($holdObj = mysql_fetch_array($result)) {
   $arrayOfOptionsValues[] = $holdObj['Option_value'];
   }

   $total = array_sum($arrayOfOptionsValues);

   $arrayOfPercents = array_map(function($a) use($total){
    return round(($a*100) / $total, 1) . '%';
   }, $arrayOfOptionsValues);

  $container = array();

   if ($surveyType == 'Custom') {
      
      // GATHER ALL OPTIONS FROM THE SURVEY BECAUSE THEY ARE CUSTOM
      $options = mysql_query("SELECT Option_name FROM Survey_Results WHERE Survey_authKey = '$surveyAuthKey'");
      $arrayOfOptions = array();

      while($holdObj = mysql_fetch_array($options)) {
      $arrayOfOptions[] = $holdObj['Option_name'];
      }

      // Do some analytics, such as finding percentages for each options
      // As well as detecting whether the survey is matching
      // If it is, we perform more analytics

          // GENERATE FINAL ARRAY TO BE SENT BACK TO APP
         array_push($container,$arrayOfOptionsValues,$arrayOfPercents, $arrayOfOptions);
   }
   else {
   
   // GENERATE FINAL ARRAY TO BE SENT BACK TO APP
   array_push($container,$arrayOfOptionsValues,$arrayOfPercents);
   }
   
   // return the json result.
   echo '{"Results":'.json_encode($container).'}';
   }
   else if ($surveyType == 'Specific'){

$fetchSpecificResults = mysql_query("SELECT Response,Key_value,Hits FROM Survey_Specific_Response WHERE Survey_authKey = '$surveyAuthKey'");

// Variable to calculate and sort analytics
$totalHits;
$matching = -1;
$matchingResponse;
$matchingHits;
$allResponses = array();
$hitsForEachResponse = array();

while ($row = mysql_fetch_object($fetchSpecificResults)) {
    if(($row->Key_value) == 0) {
         $matching = 0;
         $matchingResponse = $row->Response;
         $matchingHits = $row->Hits;
    }
    // save all responses and hits for each response
    $allResponses[] = $row->Response;
    $hitsForEachResponse[] = $row->Hits;
    // keep a running count of the total number of hits
    $totalHits = $totalHits + $row->Hits;
}

$percentCorrect;
$percentWrong;
$percentContainer = array();

$correct;
$wrong;
$correctWrongContainer = array();

if ($matching == 0) {

   $correct = $matchingHits;
   $wrong = $totalHits - $matchingHits;
   array_push($correctWrongContainer,$correct,$wrong);

   $percentCorrect = round((($matchingHits / $totalHits) * 100),1) . '%';
   $percentWrong = round(((($totalHits - $matchingHits) / $totalHits) * 100),1) .'%';

   array_push($percentContainer,$percentCorrect, $percentWrong);
}
   $container = array();

array_multisort($allResponses, SORT_DESC, $hitsForEachResponse);

if ($matching == 0)
 array_push($container,$matching,$matchingResponse,$allResponses,$hitsForEachResponse,$correctWrongContainer,$percentContainer);
else
 array_push($container,$matching,$allResponses,$hitsForEachResponse);

// return the json result.
   echo '{"Results":'.json_encode($container).'}';
}
else if ($surveyType == 'Tempo') {

  $fetchTempoResults = mysql_query("SELECT Class_size,Percent,Hits FROM Survey_Tempo WHERE Survey_authKey = '$surveyAuthKey'");

     while($obj = mysql_fetch_object($fetchTempoResults)) {
       $tempoResultsArray[] = $obj;
   }

  $fetchTempoLog = mysql_query("SELECT Log_time FROM Track_Results ORDER BY Log_time ASC WHERE Survey_authkey = '$surveyAuthKey'");
   
  while($obj = mysql_fetch_object($fetchTempoLog)) {
       $logResultsArray[] = $obj;
   }

   $container = array();

   array_push($container,$tempoResultsArray,$logResultsArray);

   // return the json result.
   echo '{"Results":'.json_encode($container).'}';

}

   // close connection 
   mysql_close();
?>