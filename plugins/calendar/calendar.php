<?php

	/*************************************************************************
	*	Ajax Full Featured Calendar
	*	- Add Event To Calendar
	*	- Edit Event On Calendar
	*	- Delete Event On Calendar
	*	- View Event On Calendar
	*	- Update Event On Rezise
	*	- Update Event On Drag
	*
	*	Author: Paulo Regina
	*	Version: 1.3
	*	
	**************************************************************************/
	
	class calendar
	{
		
		###############################################################################################
		#### Properties
		###############################################################################################
		
		// Initializes A Container Array For All Of The Calendar Events
		var $json_array = array();
		var $connection = '';
		
		############################################################################################### 
		#### Methods
		###############################################################################################
		
		/**
		* Construct
		* Returns connection
		*/
		public function __construct($db_server, $db_username, $db_password, $db_name, $table)
		{
			// Set Internal Variables
			$this->db_server = $db_server;	
			$this->db_username = $db_username;
			$this->db_password = $db_password;
			$this->db_name = $db_name;
			$this->table = $table;	

			// Connection @params 'Server', 'Username', 'Password'
			$this->connection = mysql_connect($this->db_server, $this->db_username, $this->db_password);
			
			// Display Friend Error Message On Connection Failure
			if(!$this->connection) 
			{
				die('Could not connect: ' . mysql_error());
			}
			
			// Internal UTF-8
			mysql_query("SET NAMES 'utf8'");
			mysql_query('SET character_set_connection=utf8');
			mysql_query('SET character_set_client=utf8');
			mysql_query('SET character_set_results=utf8');
			
			// Select The Database Name
			$db = mysql_select_db($this->db_name);
			
			// Display Friend Error Message On Database Select Failure
			if(!$db)
			{
				die('Could not select: ' . mysql_error());	
			}
			
			// Run The Query
			$this->result = mysql_query("SELECT * FROM $this->table ");
			
		}
		
		/**
		* Function To Transform MySQL Results To jQuery Calendar Json
		* Returns converted json
		*/
		public function json_transform($js = true)
		{
			
			while($this->row = mysql_fetch_array($this->result, MYSQL_ASSOC))
			{
				 // Set Variables Data from DB
				 $event_id = $this->row['id'];
				 $event_title = $this->row['title'];
				 $event_description = $this->row['description'];
				 $event_start = $this->row['start'];
				 $event_end = $this->row['end'];
				 $event_allDay = $this->row['allDay'];
				 $event_color = $this->row['color'];
				 $event_url = $this->row['url'];
				 
				 if($js == true) 
				 {
				 	 // JS MODE
					
					 // When allDay = false the allDay options appears on the script, when its true it doesnot appear 
					 if($event_url == 'false' && $event_allDay == 'false')
					 {
						 // Build it Without URL & allDay
						 
						 // Stores Each Database Record To An Array (Without URL)
						$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'allDay' => $event_allDay, 'color' => $event_color);
	
						// Adds Each Array Into The Container Array
						array_push($this->json_array, $build_json);
						
					 } elseif($event_url == 'false' && $event_allDay == 'true') {
						 
						 // Build it Without URL 
						 
						 // Stores Each Database Record To An Array (Without URL)
						$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'color' => $event_color);
	
						// Adds Each Array Into The Container Array
						array_push($this->json_array, $build_json);
					  
					 } elseif($event_url == 'true' && $event_allDay == 'false') {
						 
						 // Built it Without URL & allDay True
						 
						// Stores Each Database Record To An Array
						$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'allDay' => $event_allDay, 'color' => $event_color, 'url' => $event_url);
						
						// Adds Each Array Into The Container Array
						array_push($this->json_array, $build_json);
						
					 } else {
						 
						 if($event_allDay == 'false') {
							// Built it With URL & allDay false
							 
							// Stores Each Database Record To An Array
							$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'allDay' => $event_allDay, 'color' => $event_color, 'url' => $event_url);
							
							// Adds Each Array Into The Container Array
							array_push($this->json_array, $build_json);
						 } else {
							// Built it With URL & allDay True
							 
							// Stores Each Database Record To An Array
							$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'color' => $event_color, 'url' => $event_url);
							
							// Adds Each Array Into The Container Array
							array_push($this->json_array, $build_json);	 
						 }
						 
					 }
				 
				 } else {
						
					// PHP MODE
					
					// When allDay = false the allDay options appears on the script, when its true it doesnot appear 
					 if($event_url == 'false' && $event_allDay == 'false')
					 {
						 // Build it Without URL & allDay
						 
						 // Stores Each Database Record To An Array (Without URL)
						$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'allDay' => $event_allDay, 'color' => $event_color);
	
						// Adds Each Array Into The Container Array
						array_push($this->json_array, $build_json);
						
					 } elseif($event_url == 'false' && $event_allDay == 'true') {
						 
						 // Build it Without URL 
						 
						 // Stores Each Database Record To An Array (Without URL)
						$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'color' => $event_color);
	
						// Adds Each Array Into The Container Array
						array_push($this->json_array, $build_json);
					  
					 } elseif($event_url == 'true' && $event_allDay == 'false') {
						 
						 // Built it Without URL & allDay True
						 
						// Stores Each Database Record To An Array
						$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'allDay' => $event_allDay, 'color' => $event_color, 'url' => $event_url);
						
						// Adds Each Array Into The Container Array
						array_push($this->json_array, $build_json);
						
					 } else {
						 
						 if($event_allDay == 'false' && substr($event_url, -4, 1) == '.' || substr($event_url, -3, 1) == '.') { // domain top level checking
							// Built it With URL & allDay false
							 
							// Stores Each Database Record To An Array
							$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'allDay' => $event_allDay, 'color' => $event_color, 'url' => $event_url);
							
							// Adds Each Array Into The Container Array
							array_push($this->json_array, $build_json);
							
						 } elseif($event_allDay == 'true' && substr($event_url, -4, 1) == '.' || substr($event_url, -3, 1) == '.') {
							
							// Built it With URL & allDay true
							 
							// Stores Each Database Record To An Array
							$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end,  'color' => $event_color, 'url' => $event_url);
							
							// Adds Each Array Into The Container Array
							array_push($this->json_array, $build_json);
							
						 } elseif($event_allDay == 'false' && isset($event_url)) {
						 	
							// Built it With any URL and allDay false
							
							// Stores Each Database Record To An Array
							$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end,  'allDay' => $event_allDay, 'color' => $event_color, 'url' => $event_url . $event_id);
							
							// Adds Each Array Into The Container Array
							array_push($this->json_array, $build_json);
							
					 	 } else {
							// Built it With URL & allDay True
							 
							// Stores Each Database Record To An Array
							$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'color' => $event_color, 'url' => $event_url . $event_id);
							
							// Adds Each Array Into The Container Array
							array_push($this->json_array, $build_json);	 
						 }
						 
					 }
					
					 
				 }
				 	  
			} // end while loop
			
			// Output The Json Formatted Data So That The jQuery Call Can Read It
			return json_encode($this->json_array);	
		}
		
		/**
		* This function updates event drag, resize from jquery fullcalendar
		* Returns true
		*/
		public function update($allDay, $start, $end, $id)
		{			
			// Convert Date Time
			$start = strftime('%Y-%m-%d %H:%M:%S', strtotime(substr($start, 0, 24)));
			$end = strftime('%Y-%m-%d %H:%M:%S', strtotime(substr($end, 0, 24)));
			
			if($allDay == 'false') {
				$allDay_value = 'true';
			} elseif($allDay == 'true') {
				$allDay_value = 'false';	
			}
			
			// The update query
			$query = sprintf('UPDATE %s 
									SET 
										start = "%s",
										end = "%s",
										allDay = "%s"
									WHERE
										id = %s
						',
										mysql_real_escape_string($this->table),
										mysql_real_escape_string($start),
										mysql_real_escape_string($end),
										mysql_real_escape_string($allDay_value),
										mysql_real_escape_string($id)
						);
			
			// The result
			return $this->result = mysql_query($query);
		}
		
		/**
		* This function updates events to the database
		* Returns true
		*/
		public function updates($id, $title, $description, $url)
		{			
			// The update query
			$query = sprintf('UPDATE %s 
									SET 
										title = "%s",
										description = "%s",
										url = "%s"
									WHERE
										id = %s
						',
										mysql_real_escape_string($this->table),
										mysql_real_escape_string(htmlentities($title)),
										mysql_real_escape_string(htmlentities($description)),
										mysql_real_escape_string(htmlentities($url)),
										mysql_real_escape_string($id)
						);
			
			// The result
			return $this->result = mysql_query($query);
		}
		
		/**
		* This function adds events to the database
		* Returns true
		*/
		public function addEvent($title, $description, $start_date, $start_time, $end_date, $end_time, $color, $allDay, $url)
		{			
			// Convert Date Time
			$start = $start_date.' '.$start_time.':00';
			$end = $end_date.' '.$end_time.':00';
			
			// Checking
			if(empty($url)) 
			{
				$url = 'false';
			}
			
			// Check for empty data
			if(empty($title) && empty($start_date))
			{
				return false;	
			}

			// The update query
			$query = sprintf('INSERT INTO %s 
									SET 
										title = "%s",
										description = "%s",
										start = "%s",
										end = "%s",
										allDay = "%s",
										color = "%s",
										url = "%s"
						',
										mysql_real_escape_string($this->table),
										mysql_real_escape_string(htmlentities($title)),
										mysql_real_escape_string(htmlentities($description)),
										mysql_real_escape_string(htmlentities($start)),
										mysql_real_escape_string(htmlentities($end)),
										mysql_real_escape_string($allDay),
										mysql_real_escape_string(htmlentities($color)),
										mysql_real_escape_string(htmlentities($url))

						);
			
			// The result
			$this->result = mysql_query($query);
			
			if($this->result) 
			{
				return true;
			} else {
				return false;	
			}
		}
		
		/**
		* This function deletes event from database
		* Returns true
		*/
		public function delete($id)
		{
			// Delete Query
			$query = "DELETE FROM $this->table WHERE id = $id";	
			
			// Result
			$this->result = mysql_query($query);
			
			if($this->result) 
			{
				return true;
			} else {
				return false;	
			}
			
		}
		
		/**
		* This function exports each event to the icalendar format and forces a download
		* Returns true
		*/		
		public function icalExport($id, $title, $description, $start_date, $end_date)
		{
			// Build the ics file
			$ical = 'BEGIN:VCALENDAR
VERSION:1.0
BEGIN:VEVENT
DTSTART:' . $start_date . '
DTEND:' . $end_date . '
DESCRIPTION:' . addslashes($description) . '
SUMMARY:' . addslashes($title) . '
END:VEVENT
END:VCALENDAR';
			 
			//set correct content-type-header
			if(isset($id)) {
				return $ical;
			} else {
				return false;
			}
		}
		
		/**
		* This function retrieves calendar data
		* Returns true
		*/
		public function retrieve($id)
		{
			// Result Query
			$this->result = mysql_query(sprintf("SELECT * FROM $this->table WHERE id = %s", mysql_real_escape_string($id)));
			
			if($this->result) {
				return mysql_fetch_assoc($this->result);
			} else {
				return false;	
			}
				
		}
				
	}

?>