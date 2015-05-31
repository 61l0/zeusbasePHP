<?php

class Micro_Action
{
    protected $module;
    protected $modules = array();

    protected $api;
    protected $apis = array();

    protected $resultKeys = array();

    private $_params = array();

    public function __construct()
    {
        $modules = $this->getDefinedModules();
        $apis = $this->getDefinedApis();

        $this->module = new Micro_Accessor_ModuleAccessor($modules);
        $this->api = new Micro_Accessor_ApiAccessor($apis);
    }

    protected function getDefinedModules()
    {
        return $this->modules;
    }
    protected function getDefinedApis()
    {
        return $this->apis;
    }

    public function setParam($key, $val)
    {
        $this->_params[$key] = $val;
    }

    public function getParam($key)
    {
        if (empty($this->_params[$key])) {
            return null;
        }
        return $this->_params[$key];
    }

    public function getParams()
    {
        return $this->_params;
    }

    public function perform()
    {
        return null;
    }

    public function getResult()
    {
        $result = array();
        foreach ($this->resultKeys as $key) {
            $result[$key] = $this->_params[$key];
        }
        return $result;
    }
}