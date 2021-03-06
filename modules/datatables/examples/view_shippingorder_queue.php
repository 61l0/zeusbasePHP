<?php
	// GET CONFIG VALUES
	$config_ini = parse_ini_file( dirname(__FILE__).DIRECTORY_SEPARATOR ."../../../conf/translator-portal-config.ini", true);
	$config =  json_encode($config_ini);			
	$jsonIterator = new RecursiveIteratorIterator(new RecursiveArrayIterator(json_decode($config, TRUE)), RecursiveIteratorIterator::SELF_FIRST);
	foreach ($jsonIterator as $key => $val) {
	    if(is_array($val)) {
			// do nothing
	    } else {								
			if($key == 'host'){
				$gaSql['server']	= $val;
				
			} else if($key == 'tracking_database'){		
				$gaSql['db']	= $val;
			
			} else if($key == 'username'){			
				$gaSql['user'] = $val;
			
			} else if($key == 'password'){			
				$gaSql['password']	= $val; 
			}
	    }
	}	
	
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "PO_ShippingOrderId";

    /* DB table to use */
    $sTable = "[Tracking].[dbo].[Translator_ShippingOrder_Queue]";
     
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
 	$aColumns = array( 'PO_ShippingOrderId', 'Number', 'Date', 'Status', 'Shipper', 'Consignee', 'Quantity', 'LoginID');    
 
 
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * no need to edit below this line
     */
     
    /*
     * ODBC connection
     */
    $connectionInfo = array("UID" => $gaSql['user'], "PWD" => $gaSql['password'], "Database"=>$gaSql['db'],"ReturnDatesAsStrings"=>true);
    $gaSql['link'] = sqlsrv_connect( $gaSql['server'], $connectionInfo);
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
           
       
    /* Ordering */
    $sOrder = "";
    if ( isset( $_GET['iSortCol_0'] ) ) {
        $sOrder = "ORDER BY  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                    ".addslashes( $_GET['sSortDir_'.$i] ) .", ";
            }
        }
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" ) {
            $sOrder = "";
        }
    }
       
    /* Filtering */
    $sWhere = "";
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
        $sWhere = "WHERE (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
            $sWhere .= $aColumns[$i]." LIKE '%".addslashes( $_GET['sSearch'] )."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )  {
            if ( $sWhere == "" ) {
                $sWhere = "WHERE ";
            } else {
                $sWhere .= " AND ";
            }
            $sWhere .= $aColumns[$i]." LIKE '%".addslashes($_GET['sSearch_'.$i])."%' ";
        }
    }
       
    /* Paging */
    $top = (isset($_GET['iDisplayStart']))?((int)$_GET['iDisplayStart']):0 ;
    $limit = (isset($_GET['iDisplayLength']))?((int)$_GET['iDisplayLength'] ):10;
    $sQuery = "SELECT TOP $limit ".implode(",",$aColumns)."
        FROM $sTable
        $sWhere ".(($sWhere=="")?" WHERE ":" AND ")." $sIndexColumn NOT IN
        (
            SELECT $sIndexColumn FROM
            (
                SELECT TOP $top ".implode(",",$aColumns)."
                FROM $sTable
                $sWhere
                $sOrder
            )
            as [virtTable]
        )
        $sOrder";
     
    $rResult = sqlsrv_query($gaSql['link'],$sQuery) or die("$sQuery: " . sqlsrv_errors());
  
    $sQueryCnt = "SELECT " . $max_records . "  FROM $sTable $sWhere";
    $rResultCnt = sqlsrv_query( $gaSql['link'], $sQueryCnt ,$params, $options) or die (" $sQueryCnt: " . sqlsrv_errors());
    $iFilteredTotal = sqlsrv_num_rows( $rResultCnt );
  
    $sQuery = " SELECT  " . $max_records . "  FROM $sTable ";
    $rResultTotal = sqlsrv_query( $gaSql['link'], $sQuery ,$params, $options) or die(sqlsrv_errors());
    $iTotal = sqlsrv_num_rows( $rResultTotal );
       
    $output = array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );
       
    while ( $aRow = sqlsrv_fetch_array( $rResult ) ) {
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
            if ( $aColumns[$i] != ' ' ) {
                $v = $aRow[ $aColumns[$i] ];
                $v = mb_check_encoding($v, 'UTF-8') ? $v : utf8_encode($v);
                $row[]=$v;
            }
        }
        If (!empty($row)) { $output['aaData'][] = $row; }
    }   
    echo json_encode( $output );
?>