<?php

require_once '../class/Sample.php';

class Sample_Dao_Xxxx_Test extends PHPUnit_Framework_TestCase
{
    private $dao;

    public function setUp() {
        $j = new Jogging();
        $this->dao = $j->getDao('xxxx');
    }

}