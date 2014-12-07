<?php

//error_reporting(E_ALL);

include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderConnector.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinder.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeDriver.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeLocalFileSystem.class.php';


function access($attr, $path, $data, $volume) {
	return strpos(basename($path), '.') === 0       
		? !($attr == 'read' || $attr == 'write')   
		:  null;                                    
}


$opts = array(
	// 'debug' => true,
	'roots' => array(
		array(
			'driver'        => 'LocalFileSystem',  
			'path'          => dirname(__FILE__).DIRECTORY_SEPARATOR.'../../../cms/uploads/',
			'URL'           => dirname($_SERVER['PHP_SELF']) . '/../../../cms/uploads/',
			'accessControl' => 'access'
		)
	)
);

// run elFinder
$connector = new elFinderConnector(new elFinder($opts));
$connector->run();

