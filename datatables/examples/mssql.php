<?php
// This is for SQL Authentication. I've added instructions if you are using Windows Authentication

// Uncomment this line for troubleshooting / if nothing displays
//ini_set('display_errors', 'On');

// Server Name
$myServer = "starscream";

// If using Windows Authentication, delete this line and the $myPass line as well.
// SQL Server User that has permission to the database
$myUser = "apps";

// SQL Server User Password
$myPass = "jcmlives";

// Database
$myDB = "Tracking";

// If using Windows Authentication, get rid of, "'UID'=>$myUser, 'PWD'=>$myPass, "
// Notice that the latest driver uses sqlsrv rather than mssql
$conn = sqlsrv_connect($myServer, array('UID'=>$myUser, 'PWD'=>$myPass, 'Database'=>$myDB));

// Change TestDB.vwTestData to YOURDB.dbo.YOURTABLENAME
$sql ="select top 1000 * from [dbo].[Shipment]  ";
$data = sqlsrv_query($conn, $sql);  

$result = array();  

do {
    while ($row = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC)){
        $result[] = $row;  
    }
}while ( sqlsrv_next_result($data) );

// This will output in JSON format if you try to hit the page in a browser
echo json_encode($result);

sqlsrv_free_stmt($data);
sqlsrv_close($conn);


/**
*  js Implementation

$(document).ready(function() {
    $('#table1').dataTable( {
        "bProcessing": true,
        "sAjaxSource": "scripts/script.php",
        "sAjaxDataProp": "",
        "aoColumns": [
            { "mData": "Column 1" },
            { "mData": "Column 2" },
            { "mData": "etc..." },
        ]
    });
});

*/

?>