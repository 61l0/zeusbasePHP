<?php

// TODO: fix these
require_once '/path/to/micro/Micro.php';
require_once '/path/to/smarty/Smarty.class.php';
require_once '/path/to/facebook_sdk/facebook.php';
require_once '/path/to/twitteroauth/twitteroauth.php';

class Sample extends Micro
{
}

$sample = new Sample();
$sample->run();
