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
	$query_url		= $host_url . "rest/v2/shipment/" . $shipment_id . "/containers"; 
	
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
			                    	<i class="fa fa-angle-right"></i>Container #:  <?php echo $row['ContainerNumber'] ?>
			                  </a>
			                </h4>
			              </div>
			              <div id="ac3-<?php echo $counter ?>" class="panel-collapse collapse">
			              <div class="panel-body">
                                    <div class="statistic-box well well-nice well-impressed bg-blue-light">
                                        <div class="section-title">
                                            <h5>
	                                            <i class="fontello-icon-archive-1"></i> Status: 	                                            
	                                            		<?php echo $row['Status'] ?> 
	                                            <span class="info-block pull-right">
	                                            <i class="fontello-icon-comment-empty"></i> Comments: 
														<?php echo $row['Comment'] ?> 
	                                            </span>
	                                        </h5>
                                        </div>
                                        <div class="section-content">
	                                     
	                                     <div class="table-responsive">
											<!-- container -->
											<table class="table no-border hover">
												<thead class="no-border">
													<tr>
														<th>SizeType</th>
														<th>Seal</th>
														<th>Seal2</th>
														<th>Seal3</th>
														<th>Pieces</th>
														<th>Lbs</th>
														<th>Kgs</th>
														<th>CFT</th>
														<th>CBM</th>
														<th>Packages</th>
													</tr>
												</thead>
												<tbody class="no-border-x">
													<tr>
														<td><?php echo $row['SizeType'] ?></td>
														<td><?php echo $row['Seal'] ?></td>
														<td><?php echo $row['Seal2'] ?></td>
														<td><?php echo $row['Seal3'] ?></td>
														<td><?php echo $row['Pieces'] ?></td>
														<td><?php echo $row['Lbs'] ?></td>
														<td><?php echo $row['Kgs'] ?></td>
														<td><?php echo $row['CFT'] ?></td>
														<td><?php echo $row['CBM'] ?></td>
														<td><?php echo $row['Packages'] ?></td>
													</tr>
												</tbody>
											</table>
	                                     </div>
<?php
			// rest call for content
			$container_number 	= $row['ContainerNumber'];
			$fileId							= $row['FileId'];
			set_time_limit(90);
			$content_url = $host_url . "rest/v2/container/" . trimFrontAndBackFromString($container_number) . "/" . $fileId . "/contents";
			$request = Requests::get($content_url);				  
			$data = json_decode($request->body, true); 		
			$success = $data['success'];			
			$contents = $data['data'];	
			//var_dump($content_url);
			if($success && count($contents) > 0){
?>
											<!-- contents -->												
											<div class="table-responsive">												
												<table class="no-border">
													<thead class="no-border">
														<tr>
															<th>Pieces</th>
															<th>Piece Type</th>
															<th>Packages</th>
															<th>Description</th>
															<th>Lbs</th>
															<th>Kgs</th>
															<th>CFT</th>
															<th>CBM</th>
														</tr>
													</thead>													
													<tbody class="no-border-x no-border-y">
														
<?php 		foreach($contents as $content){ ?>
														<tr>
															<td><?php echo $content['Pieces'] ?></td>
															<td><?php echo $content['PieceType'] ?></td>
															<td><?php echo $content['Packages'] ?></td>
															<td><?php echo $content['Description'] ?></td>
															<td><?php echo $content['Lbs'] ?></td>
															<td><?php echo $content['Kgs'] ?></td>
															<td><?php echo $content['CFT'] ?></td>
															<td><?php echo $content['CBM'] ?></td>
														</tr>
<?php 		} // close content loop ?>	
													
													</tbody>													
												</table>
											</div>
<?php
			} // close content 
?>
											
                                            
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
							<h3>No Containers Found</h3>
						</div>
						<div class="content overflow-hidden">
							<div class="well">An error has occured preventing the system from retrieving the containers related to this shipment.
							<p class="text-right">Please contact support for further assistance.</p></div>
						</div>
					</div>	
 	
<?php
	} 
 ?>		 
 
 