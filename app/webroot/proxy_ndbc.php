<?php
// Ocean Observatories Initiative 
// Education & Public Engagement Implementing Organization
//
// Proxy to retrieve and cache data from NDBC's IOOS Sensor Observation Service (SOS)
// Written by Mike Mills, Rutgers University
// Revised 6/5/12
//
// This proxy parses the eventtime from the query string and constructs multiple multiple requests if needed
// If the time span is less than 30 days, only one request will be made the the csv will be returned
// If the time span is greater than 30 days...
// 1. calculate the number of days between the start and end date
// 2. divide 1 by 30 and increment 1 ->  the number of requests required to fulfill the data
// 3. calculate time intervals starting with start date and incrementing by 28 days
// 4. create new url request strings using the new time intervals and append to array
// 5. iterate through array, making requests for each interval, removing the csv header line from all but first request
//
// The script also caches the returned concatenated dataset, and then on further requests, 
//  checks to see if a cache file already exists.
	
/** 
 * Make a request for data from the SOS server
 * @param targetUrl
 */
function make_request($targetUrl,$mustMatch=true){
  // check if the request URL matches any of the allowed URLs

  $allowed_urls = array(
    array( 'url' => 'http://sdf.ndbc.noaa.gov/', 'matchAll' => true ),
    array( 'url' => 'http://mmisw.org', 'matchAll' => true),
  );
  
  if ($mustMatch) {
    $pos = is_url_allowed($allowed_urls, $targetUrl);
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
    //  'Content-Type: ' . $_SERVER['CONTENT_TYPE'],
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

/** 
 * Construct a cache filename from a query URL
 * @param url
 */
function get_cache_file_name($url){

  //	$url = 'http://sdf.ndbc.noaa.gov/sos/server.php?request=GetObservation&service=SOS&offering=urn:ioos:station:wmo:44025&observedproperty=sea_water_temperature&responseformat=text/csv&eventtime=2012-01-01T00:00Z/2012-01-11T00:00Z';

	// parse our info
	$step1 = explode("station:wmo:",$url);
	$step2 = explode("&",$step1[1]);
	$parameter_prep = explode("=",$step2[1]);
	$date_prep = explode("=",$step2[3]);

	// set station, parameter, and eventtime
	$station = $step2[0];
	$parameter = $parameter_prep[1];
	$eventtime = $date_prep[1];

	// process the file name and replace the forward slash with --
	$fileName = "NBDC_" . $station . "_" . $parameter. "_" . $eventtime . ".csv";
	$fileName = str_replace("/","--",$fileName);

	return $fileName;
}
  
/** 
 * Check if the requested URL is allowed
 * @param allowedServers
 * @param url
 */
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
    } else {
      if ((strcasecmp($url, $allowedUrl) == 0)) {
        $isOk = $i; // array index that matched
        break;
      }
    }
  }
  return $isOk;
}
  
/*************************************************
 * MAIN SCRIPT 
 */

// first check if file exists, if not continue on
  $targetUrl = $_SERVER['QUERY_STRING'];

// create a usable file name
  $cacheDir = 'files/cache/';
  $fileName = get_cache_file_name($targetUrl);
  $cacheFile = $cacheDir . $fileName;
  $errorFile = $cacheDir . 'error_log.txt';
  if (!is_dir($cacheDir)) {
    mkdir($cacheDir);
  }

// Serve from the cache if it is younger than $cachetime
  $cachetime = 60 * 60 * 24 * 30; // 30 day cache, we can disable time checks since the data will never change.
  if (file_exists($cacheFile) && (time() - $cachetime < filemtime($cacheFile))) {
    include($cacheFile);
    //echo "<!-- Cached ".date('jS F Y H:i', filemtime($cacheFile))." -->";
    exit;
  }
  ob_start(); // start the output buffer

// now continue as usual

// check if the curl extension is loaded
  if (!extension_loaded("curl")) {
    header('Status: 500', true, 500);
    echo 'cURL extension not loaded! <br/> Add the following lines to your php.ini file: <br/> extension_dir = &quot;&lt;your-php-install-location&gt;/ext&quot; <br/> extension = php_curl.dll';
    return;
  }
  
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
  $startDay = explode("T",$times[0]);
  $startDay2 = $startDay[0];
  $endDay = explode("T",$times[1]);
  $endDay2 = $endDay[0];
  //echo "Event Day: " .  $startDay2 . " - ". $endDay2 . "\n";

  //$r1_startTime =  date_parse_from_format( "Y-m-dTH:iZ" , $startTime );
  //$r2_endTime = date_parse_from_format("Y-m-dTH:iZ" , $endTime );
  $r_startDay =  @date_create($startDay2);
  $r_endDay = @date_create($endDay2);

// Output headers
  $expires = 60*60*24*1;
  header("Pragma: public");
  header("Cache-Control: maxage=".$expires);
  header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
  header("Content-Type: text/csv");

// calculate date difference, if longer than 30, break requests into chunks
  $date_diff = date_diff($r_startDay, $r_endDay)->format("%a");
  if($date_diff >= 30) {
    $min_requests = floor(($date_diff / 29)) +1;
    // TODO: balance request lengths to be about the same time frame?
    $tmp_CurrentDay = $r_startDay;
    $days_per_request = floor($date_diff / $min_requests) + 1;
    for($x=0;$x<$min_requests;$x++) {
      $request = $req_base . $tmp_CurrentDay->format("Y-m-d") . "T00:00Z/"; 
      if($x==$min_requests-1) {
        $request .=  $r_endDay->format("Y-m-d") . "T00:00Z";
      } else {
        $tmp_CurrentDay = $tmp_CurrentDay->add(new DateInterval("P".$days_per_request."D"));
        $request.= $tmp_CurrentDay->format("Y-m-d") . "T00:00Z";
      }
      $requests[$x] = $request;
    }
    
    if("log" == "do not log") {
      $out = "\nTotal Days: " . $date_diff . "\n";
      $out .= "Days Per Request: " . $days_per_request . "\n";
      $out .= "Number of Data Requests: ". $min_requests . "\n";
      foreach($requests as $a => $b) {
        $out .= $b . "\n";
      }
      $file = fopen($errorFile,'w+');
      fwrite($file, $out);
      fclose($file);
      exit;
    }

    // now split the request into two requests and concatenate.. trim headers from second request
    $reqCount=0;
    
    // on the first request, do not worry about stripping header of csv, but strip it on all subsequest requests
    $requests_all = "";
    $request_append = "";
    $csv_header = "";
    for($x=0;$x<$min_requests;$x++) {
      if($reqCount > 0) {
        $response = make_request($requests[$x]);
        if (preg_match("/xml version/i", $response)) {
          $file = fopen($errorFile,'w+');
          fwrite($file, "\n\nREQUEST: ". $requests[$x] . "\n".$response);
          fclose($file);
        } else {
          $request_append.= $response;
        }
      } else {
        $response = make_request($requests[$x]);
        if (preg_match("/xml version/i", $response)) {
          $file = fopen($errorFile,'w+');
          fwrite($file, "\n\nREQUEST: ". $requests[$x] . "\n".$response);
          fclose($file);
        } else {
          preg_match('/^station_id?.+/i',	$response, $matches);
          $header = $matches[0];
          $request_append.= $response;
        }
        $reqCount++;
      }	
    }
    
    // now remove header and blank lines
    $request_append = preg_replace('/station_id+.+[\r\n]/',"", $request_append);
    $request_append = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/","",$request_append);
    
    //header("Content-Type: text/csv");
    echo $header. "\n";
    echo $request_append;
  } else {
  	//only one request is necessary
  	//header("Content-Type: text/csv");
  	echo make_request($targetUrl);
  }

// Now write the contents of the requests to the file
  $fp = fopen($cacheFile, 'w'); // open the cache file for writing
  fwrite($fp, ob_get_contents()); // save the contents of output buffer to the file
  fclose($fp); // close the file
  ob_end_flush(); // Send the output to the browser

?>
