<?php

class Micro_Auth_Facebook implements Micro_Auth
{
    private $_facebook;

    private $_isLoggedIn;
    private $_userId;

    public function __construct()
    {
        $this->_facebook = new Micro_Api_Facebook;
    }

    public function authenticate()
    {
        $userId = null;

        $signed_request = $this->_facebook->getSignedRequest();
        if ( ! empty($signed_request)) {
            //error_log("## auth by signed_request");
            $userId = $signed_request['user_id'];
        }
        else if ( ! empty($_SESSION['userId'])) {
            //error_log("## auth by stored userId in session");
            $userId = $_SESSION['userId'];
        }
        else if ( ! empty($_GET['accessToken']) || ! empty($_POST['accessToken'])) {
            //error_log("## authing by calling API");
            $accessToken = !empty($_GET['accessToken']) ? $_GET['accessToken'] : $_POST['accessToken'];
            $this->_facebook->setAccessToken($accessToken);
            $user = $this->_facebook->api('/me','GET');
            if ( ! empty($user)) {
                //error_log("## authed by calling API");
                $userId = $user['id'];
            }
        }
        else {
            error_log("## no auth information");
            // return false;
        }

        if ($userId) {
            $this->_isLoggedIn = true;
            $this->_userId = $userId;
        } else {
            $this->_isLoggedIn = false;
            $this->_userId = null;
        }

        return true;
    }

    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }

    public function getUserId()
    {
        return $this->_userId;
    }

    public function getProvider()
    {
        return 'facebook';
    }

    private function now()
    {
        return round(microtime(true)*1000);
    }

}