<?php
	$shipment_id = isset($_GET['shipmentId']) ? $_GET['shipmentId'] : 0;
	echo "Shipment Id = " . $shipment_id;
?>
<h3>Showing All Documents for ShipmentId : <?php echo $shipment_id ?></h3>

					<!-- Accordian Status Full Color -->			
					<div class="panel-group accordion accordion-semi" id="accordion4">
					  <div class="panel panel-default">
			              <div class="panel-heading success">
			                <h4 class="panel-title">
			                <a data-toggle="collapse" data-parent="#accordion4" href="#ac4-1">
			                  <i class="fa fa-angle-right"></i> Success Color
			                </a>
			                </h4>
			              </div>
			              <div id="ac4-1" class="panel-collapse collapse in">
			                <div class="panel-body">
			                We have a full documentation for every single thing in this template, let's check it out and if you need support with.
			                </div>
			              </div>
					  </div>
					  <div class="panel panel-default">
			              <div class="panel-heading warning">
			                <h4 class="panel-title">
			                <a class="collapsed" data-toggle="collapse" data-parent="#accordion4" href="#ac4-2">
			                  <i class="fa fa-angle-right"></i> Warning Color
			                </a>
			                </h4>
			              </div>
			              <div id="ac4-2" class="panel-collapse collapse">
			                <div class="panel-body">
			                We have a full documentation for every single thing in this template, let's check it out and if you need support with.
			                </div>
			              </div>
					  </div>
					  <div class="panel panel-default">
			              <div class="panel-heading danger">
			                <h4 class="panel-title">
			                <a class="collapsed" data-toggle="collapse" data-parent="#accordion4" href="#ac4-3">
			                  <i class="fa fa-angle-right"></i> Danger Color
			                </a>
			                </h4>
			              </div>
			              <div id="ac4-3" class="panel-collapse collapse">
			                <div class="panel-body">
			                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non  
			                </div>
			              </div>
					  </div>
					</div>		