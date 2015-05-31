<?php

class Micro_Module
{
    protected $module;
    protected $modules = array();

    protected $api;
    protected $apis = array();

    protected $dao;
    protected $daos = array();

    public function __construct()
    {
        $this->module = new Micro_Accessor_ModuleAccessor($this->modules);
        $this->dao = new Micro_Accessor_DaoAccessor($this->daos);
        $this->api = new Micro_Accessor_ApiAccessor($this->apis);
    }
}