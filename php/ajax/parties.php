<?php
	
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
	$query_url		= $host_url . "rest/v2/shipment/" . $shipment_id . "/parties"; 
	
	// Request Library
	//=======================================================================================	
	include(dirname($_SERVER['SCRIPT_FILENAME']).DIRECTORY_SEPARATOR.'../../../lib/Requests/Requests.php');
	Requests::register_autoloader();	

	// QUERY via REST
	//=======================================================================================		
	$request = Requests::get($query_url);				  
	$data = json_decode($request->body, true); 		
	$success = $data['success'];			
	$rows = $data['data'];
	if($success && count($rows) > 0){
?>
					<div class="panel-group accordion accordion-semi" id="accordion3">
<?php 
		$counter = 1;
		foreach($rows as $row){
?>												
					  <div class="panel panel-default">
			              <div class="panel-heading">
			                <h4 class="panel-title">
			                  <a class="collapsed" data-toggle="collapse" data-parent="#accordion3" href="#ac3-<?php echo $counter ?>">
			                    	<i class="fa fa-angle-right"></i> <?php echo partyTypeLookup($row['PartyType']) . " - " . $row['Contact'] ?>
			                  </a>
			                </h4>
			              </div>
			              <div id="ac3-<?php echo $counter ?>" class="panel-collapse collapse">
			                <div class="panel-body">
                                    <div class="statistic-box well well-nice well-impressed bg-blue-light">
                                        <div class="section-title">
                                            <h5>
	                                            <i class="fontello-icon-phone"></i>	                                            
	                                            		<?php echo $row['Phone'] ?> 
	                                            <span class="info-block pull-right">
	                                            <i class="fontello-icon-mail-5"></i>
	                                            		<a href="mailto:<?php echo $row['Email'] ?>"><?php echo $row['Email'] ?></a>
	                                            </span>
	                                        </h5>
                                        </div>
                                        <div class="section-content">
                                            <h2 class="statistic-values"></h2>
                                            <span class="info-block">
                                                <?php echo $row['Address1'] ?><br>                                
                                                <?php echo $row['Address2'] ?><br>
                                                <?php echo $row['Address3'] ?><br>
                                                <?php echo $row['City'] . ", " . $row['State'] . " " . $row['ZipCode'] ?><br>
                                            </span> 
                                            <p class="text-right" ><?php echo $row['City'] . " " . $row['Country'] ?></p>
                                        </div>
                                    </div>
			                </div>
			              </div>
					  </div>		  
<?php
		$counter++;
		}
?>					
					</div>	
<?php
	} else {
 ?>		
					 <!-- No Results Found -  Query was unsuccessfull -->
 					<div class="block-flat">
						<div class="header">
							<h3>No Parties Found</h3>
						</div>
						<div class="content overflow-hidden">
							<div class="well">An error has occured preventing the system from retrieving the parties related to this shipment.
							<p class="text-right">Please contact support for further assistance.</p></div>
						</div>
					</div>	
 	
<?php
	} 
 ?>		 
 
 