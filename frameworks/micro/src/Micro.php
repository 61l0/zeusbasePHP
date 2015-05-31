<?php

if ( ! function_exists('micro_autoload')) {

    function micro_autoload($class)
    {
        // Search in Micro
        $file = dirname(__FILE__) . '/' . str_replace('_', '/', $class) . '.php';
        if (file_exists($file)) {
            require_once($file);
            return;
        }
        // Serach in extended application
        $file = Micro::$app_root_dir . '/class/' . str_replace('_', '/', $class) . '.php';
        if (file_exists($file)) {
            require_once($file);
            return;
        }
    }

    spl_autoload_register('micro_autoload');
}

class Micro {

    public static $id;
    public static $app_root_dir;

    public static $api_facebook_app_id;
    public static $api_facebook_app_secret;

    public static $api_twitter_consumer_key;
    public static $api_twitter_consumer_secret;
    public static $api_twitter_callback_url;

    public static $api_aws_app_key;
    public static $api_aws_app_secret;

    public static $db_hostname;
    public static $db_user;
    public static $db_password;
    public static $db_dbname;

    private $_controller;

    public function __construct()
    {
        self::$app_root_dir = $this->_getRootDir();
        self::$id = basename(self::$app_root_dir);
        $this->initController();
    }

    public function run()
    {
        $this->_controller->run();
    }

    public function getDao($dao)
    {
        $daos = new Micro_Accessor_DaoAccessor(array($dao));
        return $daos->$dao;
    }

    public function getModule($module)
    {
        $modules = new Micro_Accessor_ModuleAccessor(array($module));
        return $modules->$module;
    }

    public function setAuth($auth)
    {
        $this->_controller->setAuth($auth);
    }

    /*-- protected --*/

    protected function initController()
    {
        $controllerClass = ucfirst(self::$id) . "_Controller";
        $this->setController(new $controllerClass);
    }
    protected function setController($controller)
    {
        $this->_controller = $controller;
    }

    /*-- private --*/

    private function _getRootDir()
    {
        $reflector = new ReflectionClass(get_class($this));
        return dirname(dirname($reflector->getFileName()));
    }
}