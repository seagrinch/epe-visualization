<?php
// Provisional Glider Web Service
//
// Written by Sage Lichtenwalner, Rutgers University 6/28/12
// Ocean Observatories Initiative 
// Education & Public Engagement Implementing Organization
//
// Revised 7/6/12
//
// This script was adapted (slightly) from the IOOS Sensor Observation Service software
//   http://sdf.ndbc.noaa.gov/sos/software/
// However, this service does (yet) not follow SOS conventions, as it currently favors 
//   glider cast-based querying, rather than time or location-based queries.
//
// This service provides the following capabilities which can be accessed as follows
//  proxy_glider.php?request=getdeployments
//  proxy_glider.php?request=gettrack&deploymentid=246
//  proxy_glider.php?request=getcast&deploymentid=246&castid=3

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
		if ( ($params['request'] == 'gettrack') || ($params['request'] == 'getcast') ) {
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
  $data['header'] = array('id','name','start_time','end_time','casts');
  $sql = "SELECT id,name,date_format(start_time,'%Y-%m-%dT%TZ') as start_time,date_format(end_time,'%Y-%m-%dT%TZ') as end_time,casts FROM deployments ORDER by start_time";
  if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_assoc()) {
      $data['obs'][] = array('id'=>$row['id'], 'name'=>$row['name'], 'start_time'=>$row['start_time'], 'end_time'=>$row['end_time'], 'casts'=>$row['casts']);
    }
    $result->free();
  }
	header('Content-type: text/csv; header=present');
	header('Content-Disposition: attachment; filename="gliderdata.csv"');
	$csv = @fopen('php://output','w');
	if ($csv) {
		fputcsv($csv,$data['header']);
		foreach($data['obs'] as $ob) {
		  fputcsv($csv,array($ob['id'],$ob['name'],$ob['start_time'],$ob['end_time'],$ob['casts']));
		}
    fclose($csv);
  }
}


/**
 * getTrack 
 */ 
function getTrack($deployment_id){
  global $mysqli;
  $data['header'] = array('deployment_id','obsdate','latitude','longitude','profile_id','direction');
  $sql = "SELECT deployment_id,date_format(observation_time,'%Y-%m-%dT%TZ') as obsdate,latitude,longitude,profile_id,direction 
    FROM cast_data 
    WHERE deployment_id='$deployment_id' 
    GROUP BY profile_id";
  if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_assoc()) {
      $data['obs'][] = array('deployment_id'=>$row['deployment_id'], 'obsdate'=>$row['obsdate'], 'latitude'=>$row['latitude'], 'longitude'=>$row['longitude'], 'profile_id'=>$row['profile_id'], 'direction'=>$row['direction']);
    }
    $result->free();
  }
	header('Content-type: text/csv; header=present');
	header('Content-Disposition: attachment; filename="gliderdata.csv"');
	$csv = @fopen('php://output','w');
	if ($csv) {
		fputcsv($csv,$data['header']);
		foreach($data['obs'] as $ob) {
		  fputcsv($csv,array($ob['deployment_id'],$ob['obsdate'],$ob['latitude'],$ob['longitude'],$ob['profile_id'],$ob['direction']));
		}
    fclose($csv);
  }
}

/**
 * getCast
 */ 
function getCast($deployment_id,$profile_id){
  global $mysqli;
  $data['header'] = array('deployment_id','obsdate','depth','latitude','longitude',
    'sea_water_temperature','sea_water_salinity','sea_water_density','sci_bb3slo_b470_scaled',
    'sci_bb3slo_b532_scaled','sci_bb3slo_b660_scaled','sci_bbfl2s_cdom_scaled','sci_bbfl2s_chlor_scaled','profile_id','direction');
  $sql = "SELECT deployment_id,date_format(observation_time,'%Y-%m-%dT%TZ') as obsdate,depth,latitude,longitude,
    sea_water_temperature,sea_water_salinity,sea_water_density,sci_bb3slo_b470_scaled,
    sci_bb3slo_b532_scaled,sci_bb3slo_b660_scaled,sci_bbfl2s_cdom_scaled,sci_bbfl2s_chlor_scaled,profile_id,direction 
    FROM cast_data 
    WHERE deployment_id='$deployment_id' AND profile_id='$profile_id'";
  if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_assoc()) {
      $data['obs'][] = array('deployment_id'=>$row['deployment_id'], 'obsdate'=>$row['obsdate'], 'depth'=>$row['depth'], 
        'latitude'=>$row['latitude'], 'longitude'=>$row['longitude'], 
        'sea_water_temperature'=>$row['sea_water_temperature'], 'sea_water_salinity'=>$row['sea_water_salinity'], 
        'sea_water_density'=>$row['sea_water_density'], 'sci_bb3slo_b470_scaled'=>$row['sci_bb3slo_b470_scaled'], 
        'sci_bb3slo_b532_scaled'=>$row['sci_bb3slo_b532_scaled'], 'sci_bb3slo_b660_scaled'=>$row['sci_bb3slo_b660_scaled'], 
        'sci_bbfl2s_cdom_scaled'=>$row['sci_bbfl2s_cdom_scaled'], 'sci_bbfl2s_chlor_scaled'=>$row['sci_bbfl2s_chlor_scaled'], 
        'profile_id'=>$row['profile_id'], 'direction'=>$row['direction']);
    }
    $result->free();
  }
	header('Content-type: text/csv; header=present');
	header('Content-Disposition: attachment; filename="gliderdata.csv"');
	$csv = @fopen('php://output','w');
	if ($csv) {
		fputcsv($csv,$data['header']);
		foreach($data['obs'] as $ob) {
		  fputcsv($csv,array($ob['deployment_id'],$ob['obsdate'],$ob['depth'],$ob['latitude'],$ob['longitude'],$ob['sea_water_temperature'],$ob['sea_water_salinity'],$ob['sea_water_density'],$ob['sci_bb3slo_b470_scaled'],$ob['sci_bb3slo_b532_scaled'],$ob['sci_bb3slo_b660_scaled'],$ob['sci_bbfl2s_cdom_scaled'],$ob['sci_bbfl2s_chlor_scaled'],$ob['profile_id'],$ob['direction']));
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
    case 'getcast': $data = getCast($params['deploymentid'],$params['castid']); break;
    default: $exceptions[] = array(EXCEPT_OPERATION_NOT_SUPPORTED,$params['request'],null); break;
  }
}

if (count($exceptions) > 0) {
	$sos = makeExceptionReport($exceptions);
	echo $sos->saveXML();
}

$mysqli->close();

?>