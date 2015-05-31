<?php

class Micro_Api_Twitter
{
    public function connect()
    {
        if ( ! array_key_exists('oauth_token', $_REQUEST)) {
            $tw = new TwitterOAuth(Micro::$api_twitter_consumer_key, Micro::$api_twitter_consumer_secret);

            $token = $tw->getRequestToken(Micro::$api_twitter_callback_url);
            if(! isset($token['oauth_token'])){
                return false;
            }

            $_SESSION['oauth_token']        = $token['oauth_token'];
            $_SESSION['oauth_token_secret'] = $token['oauth_token_secret'];

            $authURL = $tw->getAuthorizeURL($_SESSION['oauth_token']);
            header("Location: " . $authURL);

            return null;
        }
        else {
            if ($_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
                unset($_SESSION);
                return false;
            }

            $tw = new TwitterOAuth(Micro::$api_twitter_consumer_key, Micro::$api_twitter_consumer_secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
            $access_token = $tw->getAccessToken($_REQUEST['oauth_verifier']);
        }

        return $access_token;
    }

    public function getConnection($oauth_token, $oauth_token_secret)
    {
        return new TwitterOAuth(Micro::$api_twitter_consumer_key, Micro::$api_twitter_consumer_secret, $oauth_token, $oauth_token_secret);
    }
}