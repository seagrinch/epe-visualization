<?php
// Provisional Glider Web Service
//
// Written by Sage Lichtenwalner, Rutgers University
// Ocean Observatories Initiative 
// Education & Public Engagement Implementing Organization
//
// Revised 10/22/12
// Version 0.2
//
// This script was adapted (slightly) from the IOOS Sensor Observation Service software
//   http://sdf.ndbc.noaa.gov/sos/software/
// However, this service does (yet) not follow SOS conventions, as it currently favors 
//   cast-based querying for glider data, rather than time or location-based queries.
//
// This service provides the following capabilities which can be accessed as follows
//  proxy_glider.php?request=getDeployments
//  proxy_glider.php?request=getTrack&deploymentid=246
//  proxy_glider.php?request=getCast&castid=3

/**
 * Exception Codes 
 */ 
define('EXCEPT_OPERATION_NOT_SUPPORTED','OperationNotSupported');
define('EXCEPT_MISSING_PARAMETER_VALUE','MissingParameterValue');
define('EXCEPT_INVALID_PARAMETER_VALUE','InvalidParameterValue');
define('EXCEPT_VERSION_NEGOTIATION_FAILED','VersionNegotiationFailed');
define('EXCEPT_INVALID_UPDATE_SEQUENCE','InvalidUpdateSequence');
define('EXCEPT_OPTION_NOT_SUPPORTED','OptionNotSupported');
define('EXCEPT_NO_APPLICABLE_CODE','NoApplicableCode');

/**
 * Get Parameters 
 */ 
function getParams() {
  global $exceptions;
	$params = array('service' => null, 'request' => null, 'eventtime' => null, 'responseformat' => null);
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$_GET = array_change_key_case($_GET, CASE_LOWER);
		if (array_key_exists('request',$_GET)) {
			$params['request'] = strtolower($_GET['request']);
		} else {
			$exceptions[] = array(EXCEPT_MISSING_PARAMETER_VALUE,'request',null);
		}
		if ( ($params['request'] == 'gettrack') ) {
  		if (array_key_exists('deploymentid',$_GET)) {
    		if (is_numeric($_GET['deploymentid'])) {
    			$params['deploymentid'] = $_GET['deploymentid'];
    		} else {
    			$exceptions[] = array(EXCEPT_INVALID_PARAMETER_VALUE,'deploymentid','deploymentid must be numeric');
    		}
  		} else {
  			$exceptions[] = array(EXCEPT_MISSING_PARAMETER_VALUE,'deploymentid',null);
  		}
    }
		if ($params['request'] == 'getcast') {
  		if (array_key_exists('castid',$_GET)) {
    		if (is_numeric($_GET['castid'])) {
    			$params['castid'] = strtolower($_GET['castid']);
    		} else {
    			$exceptions[] = array(EXCEPT_INVALID_PARAMETER_VALUE,'castid','castid must be numeric');
    		}
  		} else {
  			$exceptions[] = array(EXCEPT_MISSING_PARAMETER_VALUE,'castid',null);
  		}
    }
  }
  return $params;
}

/**
 * getDeployments 
 */ 
function getDeployments(){
  global $mysqli;
  $data['header'] = array('id','start_time','end_time','glider_id','name');
  $sql = "SELECT deployment_id,date_format(start_date,'%Y-%m-%dT%TZ') as start_time,date_format(end_date,'%Y-%m-%dT%TZ') as end_time,glider_id,name 
    FROM epe_deployments 
    ORDER by start_time";
  if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_assoc()) {
      $data['obs'][] = array('id'=>$row['deployment_id'], 'start_time'=>$row['start_time'], 'end_time'=>$row['end_time'], 'glider_id'=>$row['glider_id'], 'name'=>$row['name'] );
    }
    $result->free();
  }
	header('Content-type: text/csv; header=present');
	header('Content-Disposition: attachment; filename="gliderdata.csv"');
	$csv = @fopen('php://output','w');
	if ($csv) {
		fputcsv($csv,$data['header']);
		foreach($data['obs'] as $ob) {
		  fputcsv($csv,array($ob['id'],$ob['start_time'],$ob['end_time'],$ob['glider_id'],$ob['name']));
		}
    fclose($csv);
  }
}


/**
 * getTrack 
 */ 
function getTrack($deployment_id){
  global $mysqli;
  $data['header'] = array('obsdate','latitude','longitude','profile_id','direction');
  $sql = "SELECT * 
    FROM epe_deployments 
    WHERE deployment_id='$deployment_id'";
  if ($result = $mysqli->query($sql)) {
    $deployment = $result->fetch_assoc();
    $result->free();
  }
  $sql = "SELECT profile_id, date_format(profile_time,'%Y-%m-%dT%TZ') as obsdate, profile_lat, profile_lon, profile_direction 
    FROM epe_profiles 
    WHERE glider_id = " . $deployment['glider_id'] . " AND profile_time >= '" . $deployment['start_date'] . "' AND profile_time <= '" . $deployment['end_date'] . "'";
  if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_assoc()) {
      $data['obs'][] = array('obsdate'=>$row['obsdate'], 'latitude'=>$row['profile_lat'], 'longitude'=>$row['profile_lon'], 'profile_id'=>$row['profile_id'], 'direction'=>$row['profile_direction']);
    }
    $result->free();
  }

	header('Content-type: text/csv; header=present');
	header('Content-Disposition: attachment; filename="gliderdata.csv"');
	$csv = @fopen('php://output','w');
	if ($csv) {
		fputcsv($csv,$data['header']);
		if (isset($data['obs'])>0) {
		  foreach($data['obs'] as $ob) {
		    fputcsv($csv,array($ob['obsdate'],$ob['latitude'],$ob['longitude'],$ob['profile_id'],$ob['direction']));
		  }
		}
    fclose($csv);
  }
}

/**
 * getCast
 */ 
function getCast($profile_id){
  global $mysqli;
  $data['header'] = array('data_id', 'profile_id', 'obsdate', 'latitude', 'longitude', 'depth', 
    'tempwat', 'condwat', 'pracsal', 'density', 'optparw', 'flubsct', 'cdomflo', 'chlaflo', 'doconcs');
    
  $sql = "SELECT data_id, profile_id, date_format(observation_time,'%Y-%m-%dT%TZ') as obsdate, latitude,longitude, preswat,
    tempwat, condwat, pracsal, density, optparw, flubsct, cdomflo, chlaflo, doconcs 
    FROM epe_profile_data 
    WHERE profile_id='$profile_id'
    ORDER BY preswat";

  if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_assoc()) {
      $data['obs'][] = array('data_id'=>$row['data_id'], 'profile_id'=>$row['profile_id'], 'obsdate'=>$row['obsdate'],  
        'latitude'=>$row['latitude'], 'longitude'=>$row['longitude'], 'preswat'=>$row['preswat'],
        'tempwat'=>$row['tempwat'], 'condwat'=>$row['condwat'], 'pracsal'=>$row['pracsal'], 'density'=>$row['density'], 
        'optparw'=>$row['optparw'], 'flubsct'=>$row['flubsct'], 
        'cdomflo'=>$row['cdomflo'], 'chlaflo'=>$row['chlaflo'], 'doconcs'=>$row['doconcs']);
    }
    $result->free();
  }

	header('Content-type: text/csv; header=present');
	header('Content-Disposition: attachment; filename="gliderdata.csv"');
	$csv = @fopen('php://output','w');
	if ($csv) {
		fputcsv($csv,$data['header']);
		if (isset($data['obs'])>0) {
  		foreach($data['obs'] as $ob) {
  		  fputcsv($csv,array($ob['data_id'],$ob['profile_id'],$ob['obsdate'],$ob['latitude'],$ob['longitude'],$ob['preswat'],$ob['tempwat'],$ob['condwat'],$ob['pracsal'],$ob['density'],$ob['optparw'],$ob['flubsct'],$ob['cdomflo'],$ob['chlaflo'],$ob['doconcs']));
      }
		}
    fclose($csv);
  }
}  

/**
 * Error Report 
 */ 
function makeExceptionReport($exceptions) {
	$dom = new DOMDocument('1.0', 'UTF-8');
	$dom->preserveWhiteSpace = false;
	$dom->formatOutput   = true;
	$root = $dom->createElement('ExceptionReport');
	$root->setAttribute('xmlns','http://www.opengis.net/ows/1.1');
	$root->setAttribute('xmlns:xsi','http://www.w3.org/2001/XMLSchema-instance');
	$root->setAttribute('xsi:schemaLocation','http://www.opengis.net/ows/1.1 owsExceptionReport.xsd');
	$root->setAttribute('version','1.0.0');
	$root->setAttribute('xml:lang','en');
	$dom->appendChild($root);
	foreach ($exceptions as $e) {
		$dom->lastChild->appendChild($dom->createElement('Exception'));
		$dom->lastChild->lastChild->setAttribute('exceptionCode',$e[0]);
		if ($e[1] !== null) {
			$dom->lastChild->lastChild->setAttribute('locator',$e[1]);
		}
		if ($e[2] !== null) {
			$dom->lastChild->lastChild->appendChild($dom->createElement('ExceptionText',$e[2]));
		}
	}
	return $dom;
}


// -----------------------------------------------
// Begin Main Script
// -----------------------------------------------
header("Access-Control-Allow-Origin: *"); //Allow access from any server

require_once('../Config/database.php');  //Database connection info is stored as an array following CakePHP convention
$db = new DATABASE_CONFIG();
$mysqli = new mysqli($db->glider['host'], $db->glider['login'], $db->glider['password'], $db->glider['database']);
if (mysqli_connect_errno()) {
  $exceptions[] = array(EXCEPT_NO_APPLICABLE_CODE,mysqli_connect_error(),'Database Connection Failed');
}

$params = getParams();

if (count($exceptions) == 0) {
  switch($params['request']) {
    case 'getdeployments': $data = getDeployments(); break;
    case 'gettrack': $data = getTrack($params['deploymentid']); break;
    case 'getcast': $data = getCast($params['castid']); break;
    default: $exceptions[] = array(EXCEPT_OPERATION_NOT_SUPPORTED,$params['request'],null); break;
  }
}

if (count($exceptions) > 0) {
	$sos = makeExceptionReport($exceptions);
	echo $sos->saveXML();
}

$mysqli->close();

?>