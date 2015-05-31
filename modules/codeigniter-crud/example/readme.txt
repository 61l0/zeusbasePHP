1. Copy example folder into your host.

2. Create codeignitercrud database with your tool and run example/example.sql file.

3. Open application/config/database.php and change your config mysql database server.
<?php
	$active_group = 'default';
	$active_record = TRUE;

	$db['default']['hostname'] = 'localhost';
	$db['default']['username'] = 'root';
	$db['default']['password'] = '';
	$db['default']['database'] = 'codeignitercrud';
	$db['default']['dbdriver'] = 'mysql';
	$db['default']['dbprefix'] = '';
	$db['default']['pconnect'] = TRUE;
	$db['default']['db_debug'] = TRUE;
	$db['default']['cache_on'] = FALSE;
	$db['default']['cachedir'] = '';
	$db['default']['char_set'] = 'utf8';
	$db['default']['dbcollat'] = 'utf8_general_ci';
	$db['default']['swap_pre'] = '';
	$db['default']['autoinit'] = TRUE;
	$db['default']['stricton'] = FALSE;
?>
4. Browser url bellow to run example
	+ http://your_domain.com/example