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
	$query_url		= $host_url . "rest/v2/shipment/" . $shipment_id . "/events"; 
	
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
			                    	<i class="fa fa-angle-right"></i> <?php echo $row['StatusDefinition'] ?>
			                  </a>
			                </h4>
			              </div>
			              <div id="ac3-<?php echo $counter ?>" class="panel-collapse collapse">
			                <div class="panel-body">
                                    <div class="statistic-box well well-nice well-impressed bg-blue-light">
                                        <div class="section-title">
                                            <h5>
	                                            <i class="fontello-icon-tags"></i>	                                            
													Shipment Event
	                                            <span class="info-block pull-right">
	                                            <i class="fontello-icon-flag-1"></i></span>
	                                        </h5>
                                        </div>
                                        <div class="section-content">
	                                     <div class="table-responsive">
											<!-- container -->
											<table class="table no-border hover">
												<thead class="no-border">
													<tr>
	                                                        <th scope="col" width="10%"> Date</th>
	                                                        <th scope="col" class="hidden-phone">Time</th>
	                                                        <th scope="col" class="hidden-tablet hidden-phone">Status</th>
	                                                        <th scope="col" class="text-right">Definition</th>	              
													</tr>
												</thead>
												<tbody class="no-border-x">
													<tr>
	                                                        <th><span class="label label-positive"><?php echo $row['Date'] ?></span></th>
	                                                        <td class="text-left bold"><?php echo $row['Time'] ?></td>
	                                                        <td class="text-left bold"><span class="label label-status"><?php echo $row['StatusCode'] ?></span></td>
	                                                        <td class="text-left bold"><?php echo $row['StatusDefinition'] ?></td>
													</tr>
												</tbody>
											</table>
	                                     </div>

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
							<h3>No Events Found</h3>
						</div>
						<div class="content overflow-hidden">
							<div class="well">The system was unable to locate any events related to this shipment.<p>&nbsp;</p>
							<p class="text-right">Please contact support for further assistance.</p></div>
						</div>
					</div>	
 	
<?php
	} 
 ?>		 
 					