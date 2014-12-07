<?php  

	//===============================================================================================
	// Set and Configure Database and Table that Holds Locations to Lookup
	//===============================================================================================		
	require("../dbconnect.php");
	$tableToUpdate = "Property";
	$tableToUpdateIdField = "PropertyId";	
	
	//===============================================================================================			
	// Start XML file, create parent node	
	//===============================================================================================			
	$dom = new DOMDocument("1.0");
	$node = $dom->createElement("markers");
	$parnode = $dom->appendChild($node); 
	
	//===============================================================================================			
	// Opens a connection to a MySQL server
	//===============================================================================================			
	$connection=mysql_connect ($host, $username, $password);
	if (!$connection) {  die('Not connected : ' . mysql_error());} 
	
	//===============================================================================================			
	// Set the active MySQL database
	//===============================================================================================			
	$db_selected = mysql_select_db($database, $connection);
	if (!$db_selected) {
	  die ('Can\'t use db : ' . mysql_error());
	} 
	
	//===============================================================================================			
	// Select all the rows in the markers table
	//===============================================================================================			
	$query = "SELECT * FROM Property Where 1";
	$result = mysql_query($query);
	if (!$result) {  
	  die('Invalid query: ' . mysql_error());
	} 

	//===============================================================================================			
	// @TODO: Run a query to determine if there available units and fill xml below - we can use
	//  different markers on the map to show this.
	//===============================================================================================			
	
	
	//===============================================================================================		
	// Set File Header Info	
	//===============================================================================================			
	header("Content-type: text/xml"); 

	//===============================================================================================			
	// Iterate through the rows, adding XML nodes for each
	//===============================================================================================			
	while ($row = @mysql_fetch_assoc($result)){  
	  // ADD TO XML DOCUMENT NODE  
	  $node = $dom->createElement("marker");  
	  $newnode = $parnode->appendChild($node);   
	  $newnode->setAttribute("supername", $row['SuperName']);
	  $newnode->setAttribute("superphone", $row['SuperPhone']);	  
	  $newnode->setAttribute("address", $row['AddressOne']);  
	  $newnode->setAttribute("lat", $row['lat']);  
	  $newnode->setAttribute("lng", $row['lng']);  
	  $newnode->setAttribute("type", $row['Type']);
	  $newnode->setAttribute("city", $row['City']);
	  $newnode->setAttribute("statecode", $row['State']);
	  $newnode->setAttribute("zipcode", $row['ZipCode']);
	  $newnode->setAttribute("hyperlink", $row['Website']);
	  
	} 
	
	//===============================================================================================		
	// Echo Out the XML Doc
	//===============================================================================================				
	echo $dom->saveXML();

?>