micro
==========================

micro is a small and simple web application framework that can collaborate with facebook and twitter API easily.

Depends on
-----
- PHP 5.3 +
- Smarty
- Facebook PHP SDK @ https://github.com/facebook/facebook-php-sdk
- twitteroauth @ https://github.com/abraham/twitteroauth

Usage
-----

    require_once '/path/to/micro/Micro.php';
    require_once '/path/to/smarty/Smarty.class.php';
    require_once '/path/to/facebook_sdk/facebook.php';
    require_once '/path/to/twitteroauth/twitteroauth.php';

    class App extends Micro 
    {
      // override something if needed
    }

    $app = new App();
    $app->run();
