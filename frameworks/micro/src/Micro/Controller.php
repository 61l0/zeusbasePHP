<?php

class Micro_Controller
{
    const DEFAULT_ACTION = 'index';

    private $_smarty; // should be $_render
    private $_auth;

    public function __construct()
    {
        $this->_smarty = new Smarty();
        $this->_smarty->template_dir = Micro::$app_root_dir . '/tpl/';
        $this->_smarty->config_dir   = Micro::$app_root_dir . '/smarty/configs/';
        $this->_smarty->addPluginsDir(Micro::$app_root_dir . '/smarty/plugins/');
        $this->_smarty->compile_dir  = '/tmp/smarty/templates_c/';

        $this->_auth = new Micro_Auth_Facebook();
    }

    public function setAuth($auth)
    {
        $this->_auth = $auth;
    }

    public function run()
    {
        if (isset($_GET['action'])) {
            $action_name = $_GET['action'];
        } else {
            $action_name = self::DEFAULT_ACTION;
        }

        // Generate Action class
        $action = $this->_getAction($action_name);
        if (is_null($action)) {
            echo "Invalid action";
            return;
        }

        // Authentication
        if (isset($this->_auth)) {
            if ($this->_auth->authenticate()) {
                // TODO
                $me = array(
                    'user_id' => $this->_auth->getUserId(),
                );
                $provider = $this->_auth->getProvider();

                $this->onAuthenticationSuccess($me, $provider);

                $action->setParam('me', $me);
            } else {
                $this->onAuthenticationFailure();
                echo "Authentication failed.";
                return;
            }
        }

        // Set Params
        $params = array_merge(array(), $_GET, $_POST);
        foreach ($params as $key => $val) {
            $action->setParam($key, $val);
        }

        // Action
        $template_name = $action->perform();

        // Render
        if (array_key_exists('format', $params) && $params['format'] === 'json') {
            $result = $action->getResult();
            if ( ! empty($result)) {
                header('Content-type: application/json');
                print json_encode($result);
            } else {
                print "{}";
            }
        } else {
            $this->_display($template_name, $action->getParams());
        }
    }

    /*-- protected --*/

    protected function onAuthenticationSuccess(&$me, $provider)
    {
    }

    protected function onAuthenticationFailure()
    {
    }

    /*-- private --*/

    private function _getAction($action_name)
    {
        if (is_null($action_name)) {
            error_log("## Error : action name is null.");
            return null;
        }

        // Generate action class name
        $action_elements = explode('_', $action_name);
        foreach ($action_elements as &$action_element) {
            $action_element = ucfirst($action_element);
        }
        $action_class = ucfirst(Micro::$id) . '_Action_' . implode('_', $action_elements);

        // Load action class
        $action_file = Micro::$app_root_dir . '/action/' . str_replace('_', '/', implode('_', $action_elements)) . '.php';
        if ( ! file_exists($action_file)) {
            error_log("## Error : $action_file not found.");
            return null;
        }
        require_once($action_file);

        return new $action_class;
    }

    private function _display($template_name, $params)
    {
        // Set params on smarty
        foreach ($params as $key => $val) {
            $this->_smarty->assign($key, $val);
        }

        // Generate template file name
        if (is_null($template_name)) {
            $elements = explode('_', get_class($this));
            foreach ($elements as &$element) {
                $element = lcfirst($element);
            }
            $template_name = implode('_', $elements);
        }
        $template_file = str_replace('_', '/', $template_name) . '.html';

        // Header here

        $this->_smarty->display($template_file);

        // Footer here
    }
}