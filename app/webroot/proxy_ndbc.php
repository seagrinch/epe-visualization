<?php

	// hack to get required data for month comparator EV tool
	
	// this file has been updated to parse the eventtime from the query string and build multiple requests
	
	// if the time span is less than 30 days, only one request will be made the the csv will be returned
	
	// if the time span is greater than 30 days
	// 1. calculate the number of days between the start and end date
	// 2. divide 1 by 30 and increment 1 ->  the number of requests required to fulfill the data
	// 3. calculate time intervals starting with start date and incrementing by 28 days
	// 4. create new url request strings using the new time intervals and append to array
	// 5. iterate through array, making requests for each interval, removing the csv header line from all but first request

  $mustMatch = true;
  
  $allowed_urls = array(
    array( 'url' => 'http://sdf.ndbc.noaa.gov/', 'matchAll' => true ),
    array( 'url' => 'http://mmisw.org', 'matchAll' => true),
    array( 'url' => 'http://ooi-dev.dev/', 'matchAll' => true),
	array( 'url' => 'http://ooidev-macbook/', 'matchAll' => true)

  );
  /***************************************************************************/
  
  function is_url_allowed($allowedServers, $url) {
    $isOk = false;
    $url = trim($url, "\/");
    for ($i = 0, $len = count($allowedServers); $i < $len; $i++) {
      $value = $allowedServers[$i];
      $allowedUrl = trim($value['url'], "\/");
      if ($value['matchAll']) {
        if (stripos($url, $allowedUrl) === 0) {
          $isOk = $i; // array index that matched
          break;
        }
      }
      else {
        if ((strcasecmp($url, $allowedUrl) == 0)) {
          $isOk = $i; // array index that matched
          break;
        }
      }
    }
    return $isOk;
  }
  
  // check if the curl extension is loaded
  if (!extension_loaded("curl")) {
    header('Status: 500', true, 500);
    echo 'cURL extension not loaded! <br/> Add the following lines to your php.ini file: <br/> extension_dir = &quot;&lt;your-php-install-location&gt;/ext&quot; <br/> extension = php_curl.dll';
    return;
  }
  
  $targetUrl = $_SERVER['QUERY_STRING'];
  if (!$targetUrl) {
    header('Status: 400', true, 400); // Bad Request
    echo 'Target URL is not specified! <br/> Usage: <br/> http://&lt;this-proxy-url&gt;?&lt;target-url&gt;';
    return;
  }
  
  $parts = preg_split("/\?/", $targetUrl);
  $targetPath = $parts[0];
  
//http://sdf.ndbc.noaa.gov/sos/server.php?request=GetObservation&service=SOS&offering=urn:ioos:station:wmo:44025&observedproperty=sea_water_temperature&responseformat=text/csv&eventtime=2012-01-01T00:00Z/2012-01-11T00:00Z

$eventTime = explode("eventtime=",$targetUrl);

$req_base = $eventTime[0] . "eventtime=";

$times = explode("/",$eventTime[1]);

$startTime = $times[0];
$endTime = $times[1];
//echo "Event Time Full: " . $startTime . " - ". $endTime . "\n";

$startDay = explode("T",$times[0]);
$startDay2 = $startDay[0];

$endDay = explode("T",$times[1]);
$endDay2 = $endDay[0];

//echo "Event Day: " .  $startDay2 . " - ". $endDay2 . "\n";

//$r1_startTime =  date_parse_from_format( "Y-m-dTH:iZ" , $startTime );
//$r2_endTime = date_parse_from_format("Y-m-dTH:iZ" , $endTime );

$r_startDay =  @date_create($startDay2);
$r_endDay = @date_create($endDay2);

// calculate date difference.. is it longer then 30?
$date_diff = date_diff($r_startDay, $r_endDay)->format("%a");

$expires = 60*60*24*1;
header("Pragma: public");
header("Cache-Control: maxage=".$expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
header("Content-Type: text/csv");

if($date_diff > 30){

 $min_requests = floor(($date_diff / 30)) +1;
 
 //echo $min_requests ." requests are necessary";

 $tmp_CurrentDay = $r_startDay;
 
 for($x=0;$x<$min_requests;$x++){
   $request = $req_base . $tmp_CurrentDay->format("Y-m-d") . "T00:00Z/"; 

   if($x==$min_requests-1){
 	 $request .=  $r_endDay->format("Y-m-d") . "T00:00Z";
   }
   else{
  	$tmp_CurrentDay = $tmp_CurrentDay->add(new DateInterval("P28D"));
    $request.= $tmp_CurrentDay->format("Y-m-d") . "T00:00Z";

   }
   $requests[$x] = $request;

 }
 
//var_dump($requests);

//exit;

// now split the request into two requests and concatenate.. trim headers from second request
  $reqCount=0;
 // on the first request, do not worry about stripping header of csv, but strip it on all subsequest requests

$request_appened = "";

  foreach($requests as $request){
	if($reqCount!=0){
		
		$requestTemp .= make_request($request);
		
		// strip out headers of subsequent requests
		$content = preg_replace("/^(.*\n){1}/", "", $requestTemp);
		$request_appened.= $content;	
	}
	else{
		$request_appened .= make_request($request);
		$reqCount++;
	}
  }

	echo $request_appened;

}
else{
	//only one request is necessary
	echo make_request($targetUrl);
	
}
  
function make_request($targetUrl){

  // check if the request URL matches any of the allowed URLs
  if ($mustMatch) {
    $pos = is_url_allowed($allowed_urls, $targetPath);
    if ($pos === false) {
      header('Status: 403', true, 403); // Forbidden
      echo 'Target URL is not allowed! <br/> Consult the documentation for this proxy to add the target URL to its Whitelist.';
      return;
    }
  }
  
  // open the curl session
  $session = curl_init();
  
  // set the appropriate options for this request
  $options = array(
    CURLOPT_URL => $targetUrl,
    CURLOPT_HEADER => false,
    CURLOPT_HTTPHEADER => array(
      'Content-Type: ' . $_SERVER['CONTENT_TYPE'],
      'Referer: ' . $_SERVER['HTTP_REFERER']
    ),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true
  );
  
  // put the POST data in the request body
  $postData = file_get_contents("php://input");
  if (strlen($postData) > 0) {
    $options[CURLOPT_POST] = true;
    $options[CURLOPT_POSTFIELDS] = $postData;
  }
  curl_setopt_array($session, $options);
  
  // make the call
  $response = curl_exec($session);
  $code = curl_getinfo($session, CURLINFO_HTTP_CODE);
  $type = curl_getinfo($session, CURLINFO_CONTENT_TYPE);
  curl_close($session);
  
  // set the proper Content-Type
 // header("Status: ".$code, true, $code);
 // header("Content-Type: ".$type);
  
  return $response;
}

?>
