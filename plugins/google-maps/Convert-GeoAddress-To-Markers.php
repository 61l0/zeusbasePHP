<?php
		//===============================================================================================
		// Set and Configure Database and Table that Holds Locations to Lookup
		//===============================================================================================		
		require("../dbconnect.php");
			
		$tableToUpdate = "Property";
		$tableToUpdateIdField = "PropertyId";
		/** Developer Note
		 *  - Still need to maually set the cols that make up the address below in the while loop
		 *  And if the address is split accross multiple fields then must concatonate so that we send 
		 *  One field to google to look up
		 */
		
		//===============================================================================================
		// Set the Google Maps API Key Code
		//===============================================================================================		
		// jordancooper.com
		$gmapsAPIkey 	= "ABQIAAAAhMg8B3oW9LFauXOPG2Gc_BQhmMkI6N7dxR_SOVwRLxZE_F9GNxSIz-c9OcVDPPxAI8Ij_La28hBEiA";

		define("MAPS_HOST", "maps.google.com");
		define("KEY", $gmapsAPIkey);

		//===============================================================================================
		// Opens a connection to a MySQL server
		//===============================================================================================
		$connection = mysql_connect($host, $username, $password);
		if (!$connection) {
		  die("Not connected : " . mysql_error());
		}
		
		//===============================================================================================
		// Set the active MySQL database		
		//===============================================================================================		
		$db_selected = mysql_select_db($database, $connection);
		if (!$db_selected) {
		  die("Can\'t use db : " . mysql_error());
		}
		
		//===============================================================================================
		// Select all the rows in the db table
		//===============================================================================================				
		$query = "SELECT * FROM " . $tableToUpdate . " WHERE 1";
		$result = mysql_query($query);
		if (!$result) {
		  die("Invalid query: " . mysql_error());
		}

		
		//===============================================================================================				
		// Initialize delay in geocode speed
		//===============================================================================================		
		$delay = 0;
		$base_url = "http://" . MAPS_HOST . "/maps/geo?output=xml" . "&key=" . KEY;
		
		//===============================================================================================		
		// Iterate through the rows, geocoding each address
		//===============================================================================================		
		while ($row = @mysql_fetch_assoc($result)) {
		  $geocode_pending = true;
		
		  while ($geocode_pending) {
		    $address1 		= $row["AddressOne"];
		    $city	  				= $row["City"];
		    $stateCode	  	= $row["State"];
		    $zipCode  			= $row["ZipCode"];
		    
		    $address = $address1 . ", " . $city . ", " . $stateCode . ", " . $zipCode;
		    $id = $row[$tableToUpdateIdField];
		    
		    $request_url = $base_url . "&q=" . urlencode($address);
		    $xml = simplexml_load_file($request_url) or die("url not loading");
		
		    $status = $xml->Response->Status->code;
		    if (strcmp($status, "200") == 0) {
	 		  //===============================================================================================		    	
		      // Successful geocode
			  //===============================================================================================		      
		      $geocode_pending = false;
		      $coordinates = $xml->Response->Placemark->Point->coordinates;
		      $coordinatesSplit = split(",", $coordinates);
			  //===============================================================================================		      
		      // Format: Longitude, Latitude, Altitude
			  //===============================================================================================		      
		      $lat = $coordinatesSplit[1];
		      $lng = $coordinatesSplit[0];
		

		      $query = sprintf("UPDATE " . $tableToUpdate .
		             " SET lat = '%s', lng = '%s' " .
		             " WHERE " . $tableToUpdateIdField . " = '%s' LIMIT 1;",		      
		             mysql_real_escape_string($lat),
		             mysql_real_escape_string($lng),
		             mysql_real_escape_string($id));
		      $update_result = mysql_query($query);
		      if (!$update_result) {
		        die("Invalid query: " . mysql_error());
		      }
		    } else if (strcmp($status, "620") == 0) {
			    //===============================================================================================		      
		        // sent geocodes too fast
			    //===============================================================================================		      
		   	 	$delay += 100000;
		    } else {
			  //===============================================================================================		      
		      // failure to geocode
			  //===============================================================================================		      
		      $geocode_pending = false;
		      echo "Address " . $address . " failed to geocoded. ";
		      echo "Received status " . $status . "\n";
		    }
		    usleep($delay);
		  }
		}
		
		
?>
