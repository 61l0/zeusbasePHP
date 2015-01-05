<?php


include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderConnector.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinder.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeDriver.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeLocalFileSystem.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeMySQL.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeFTP.class.php';


$opts = array(
	'debug' => false,
	'roots' => array(
		array(
			'driver'     => 'LocalFileSystem',
			'path'       => dirname(__FILE__).DIRECTORY_SEPARATOR.'../files/',
			'startPath'  => dirname(__FILE__).DIRECTORY_SEPARATOR.'../files/',
			'URL'        => dirname($_SERVER['PHP_SELF']) . '/..files/',			
		    'alias'      => 'Local Disk',
			'mimeDetect' => 'internal',
			'utf8fix'    => true,
			'accessControl' => 'access'
		),
		array(
			'driver' => 'FTP',
			'host' => 'ftp.tinlab.com',
			'user' => 'zeuswebserver',
			'pass' => 'jcmlives',
			'path' => 'tinlab/',
			'tmpPath' => '../files/ftp',
		),
	)
		
);


header('Access-Control-Allow-Origin: *');
$connector = new elFinderConnector(new elFinder($opts), true);
$connector->run();
