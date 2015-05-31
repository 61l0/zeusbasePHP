<?php

class Micro_Api_Facebook
{
    private $_facebook;

    public function __call($name, $params)
    {
        if ( ! isset($this->_facebook)) {
            $this->_facebook = new Facebook(array(
                'appId'  => Micro::$api_facebook_app_id,
                'secret' => Micro::$api_facebook_app_secret,
            ));
        }
        try {
            $result = call_user_func_array(array($this->_facebook, $name), $params);
        }
        catch (FacebookApiException $e) {
            $result = null;
        }
        return $result;
    }
}