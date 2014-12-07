<?php
	
	// Request Library
	//=======================================================================================	
	include(dirname($_SERVER['SCRIPT_FILENAME']).DIRECTORY_SEPARATOR.'../../../lib/Requests/Requests.php');
	Requests::register_autoloader();		
	
	// Utils
	//=======================================================================================	
	function trimFrontAndBackFromString($stringVal){
		$returnVal = $stringVal;
		if(isset($stringVal)){
			if($stringVal){
				$returnVal = ltrim($stringVal);
				$returnVal = rtrim($stringVal);
			}
		}
		return $returnVal;
	}
	function partyTypeLookup($code){
		$desc = $code;
		$code = trimFrontAndBackFromString($code);
		if($code == "AC"){
			$desc = "Account";
		} else if($code == "SH"){
			$desc = "Shipper";			
		} else if($code == "CN"){
			$desc = "Consignee";			
		} else if($code == "N1"){
			$desc = "Notify";			
		} else if($code == "N2"){
			$desc = "Notify 2";			
		} else if($code == "FF"){
			$desc = "Forwarder";			
		} else if($code == "CL"){			
			$desc = "CL";			
		}
		return $desc;
	}	
	function getConfig(){
		$baseURL = "";
		$config_ini = parse_ini_file( dirname(__FILE__).DIRECTORY_SEPARATOR ."../../../../conf/browser-config.ini", true);
		$config =  json_encode($config_ini);			
		$jsonIterator = new RecursiveIteratorIterator(new RecursiveArrayIterator(json_decode($config, TRUE)), RecursiveIteratorIterator::SELF_FIRST);		
		foreach ($jsonIterator as $key => $val) {
				    if(is_array($val)) {
						// do nothing
				    } else {				
						if($key == 'ajax_url'){		
							$baseURL = "http://" . $val . "/";
													 
						} else if($key == 'host'){									
							$gaSql['server']	= $val;
							
						} else if($key == 'tracking_database'){		
							$gaSql['db']	= $val;
						
						} else if($key == 'username'){			
							$gaSql['user'] = $val;
						
						} else if($key == 'password'){			
							$gaSql['password']	= $val; 
						}						
					}				
		} // close loop
		return $baseURL;
	}	
	function getSiteURL(){
		$host_url		= 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : '') .'://'.$_SERVER['HTTP_HOST'].'/';
		return $host_url;
	}

	// Params
	//=======================================================================================	
	$shipment_id = isset($_GET['shipmentId']) ? $_GET['shipmentId'] : 0;
		
	// Base Configuration
	//=======================================================================================	
	$host_url 		= getConfig();
	$query_url		= $host_url . "rest/v2/shipment/" . $shipment_id . "/containers"; 
	


	// QUERY via REST
	//=======================================================================================		
	$request = Requests::get($query_url);				  
	$data = json_decode($request->body, true); 		
	$success = $data['success'];			
	$rows = $data['data'];
	if($success && count($rows) > 0){
	}


    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "ShipmentId";

    /* DB table to use */
    $sTable = "[Tracking].[dbo].[Translator_Shipment_Queue]";
     
    /* Database connection information */
    /**
    $gaSql['user']       		= "apps";
    $gaSql['password']   	= "jcmlives";
    $gaSql['db']         		= "Tracking";
    $gaSql['server']     		= "starscream";
	*/
 
    /* Query Settings */
    //$max_records = " Top 100 "; 
    $max_records = " * "; 
     
     
    /*
    * Columns
    * If you don't want all of the columns displayed you need to hardcode $aColumns array with your elements.
    * If not this will grab all the columns associated with $sTable
    */
 	$aColumns = array( 'ShipmentId', 'FileNumber', 'MasterNumber', 'HouseNumber', 'Status', 'Shipper' );    
 
 ?>