<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
*/

$active_group = 'default';
$active_record = TRUE;

// arig oracle
$tnslistener = '(DESCRIPTION =
(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = '.DB_HOST.')(PORT = '.DB_PORT.'))
)
(LOAD_BALANCE = yes)
(CONNECT_DATA =
(SERVER = DEDICATED)
(SERVICE_NAME = '.DB_NAME.')
)
)';
//------------------------
$db['default']['hostname'] = $tnslistener; //DB_HOST;
$db['default']['domain']   = DB_HOST;

$db['default']['username'] = DB_USER;
$db['default']['password'] = DB_PASS;
$db['default']['database'] = DB_NAME;
$db['default']['dbdriver'] = DB_DRIVER;
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = DB_PCONNECT;
$db['default']['db_debug'] = DB_DBUG;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = DB_CACHEDIR;
$db['default']['swap_pre'] = DB_SWAP_PRE;
$db['default']['autoinit'] = DB_AUTOINIT;
$db['default']['stricton'] = DB_STRICTON;
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';

//// BPHTB
$db['bphtb_db']['hostname'] = DB_HOST_BPHTB;
$db['bphtb_db']['domain']   = DB_HOST_BPHTB;
$db['bphtb_db']['username'] = DB_USER_BPHTB;
$db['bphtb_db']['password'] = DB_PASS_BPHTB;
$db['bphtb_db']['database'] = DB_NAME_BPHTB;
$db['bphtb_db']['dbdriver'] = DB_DRIVER_BPHTB;
//$db['bphtb_db']['versisql'] = DB_VERSISQL;
$db['bphtb_db']['dbprefix'] = '';
$db['bphtb_db']['pconnect'] = DB_PCONNECT;
$db['bphtb_db']['db_debug'] = DB_DBUG;
$db['bphtb_db']['cache_on'] = FALSE;
$db['bphtb_db']['cachedir'] = DB_CACHEDIR;
$db['bphtb_db']['char_set'] = DB_CHAR_SET;
$db['bphtb_db']['dbcollat'] = DB_COLLAT;
$db['bphtb_db']['swap_pre'] = DB_SWAP_PRE;
$db['bphtb_db']['autoinit'] = DB_AUTOINIT;
$db['bphtb_db']['stricton'] = DB_STRICTON;

//rican
// $tnslistener_vq = '(DESCRIPTION =
// (ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = '.DB_HOST_VQ.')(PORT = '.DB_PORT_VQ.'))
// )
// (LOAD_BALANCE = yes)
// (CONNECT_DATA =
// (SERVER = DEDICATED)
// (SERVICE_NAME = '.DB_NAME_VQ.')
// )
// )';
//VA
// $db['va']['dsn'] = '';
// $db['va']['schema'] = 'bjbva';
//$db['va']['hostname'] = '192.168.1.98';
// $db['va']['hostname'] = $tnslistener_vq;
//$db['default']['domain']   = DB_HOST_VQ;
//$db['va']['port']     = '5432';
//$db['va']['username'] = 'postgres';
//$db['va']['password'] = '@dminP51';
//$db['va']['database'] = 'online_payment';
//$db['va']['dbdriver'] = 'postgre';
//$db['va']['dbprefix'] = '';
//$db['va']['pconnect'] = TRUE;
//$db['va']['db_debug'] = DB_DBUG;
//$db['va']['cache_on'] = FALSE;
//$db['va']['cachedir'] = '';
//$db['va']['char_set'] = 'utf8';
//$db['va']['dbcollat'] = 'utf8_general_ci';
//$db['va']['swap_pre'] = '';
//$db['va']['encrypt'] = FALSE;
//$db['va']['compress'] = FALSE;
//$db['va']['autoinit'] = TRUE;
//$db['va']['stricton'] = FALSE;
//$db['va']['save_queries'] = TRUE;

// VA
// $db['va']['dsn'] = '';
// $db['va']['schema'] = 'bjb_va';
// $db['va']['hostname'] = '192.168.1.98';
// $db['va']['port']     = '5432';
// $db['va']['username'] = 'postgres';
// $db['va']['password'] = '@dminP51';
// $db['va']['database'] = 'online_payment';
// $db['va']['dbdriver'] = 'postgre';
// $db['va']['dbprefix'] = '';
// $db['va']['pconnect'] = TRUE;
// $db['va']['db_debug'] = DB_DBUG;
// $db['va']['cache_on'] = FALSE;
// $db['va']['cachedir'] = '';
// $db['va']['char_set'] = 'utf8';
// $db['va']['dbcollat'] = 'utf8_general_ci';
// $db['va']['swap_pre'] = '';
// $db['va']['encrypt'] = FALSE;
// $db['va']['compress'] = FALSE;
// $db['va']['autoinit'] = TRUE;
// $db['va']['stricton'] = FALSE;
// $db['va']['save_queries'] = TRUE;

// define('DB_HOST_PAD', '192.168.1.240');
// define('DB_PORT_PAD', '5432');
// define('DB_TYPE_PAD', 'postgre');
// define('DB_USER_PAD', 'bogorkab');
// define('DB_PASS_PAD', 'bogorkab0864');
// define('DB_NAME_PAD', 'pad_bogor');

$db['va'] = array(
	'dsn'	=> '',
	'hostname' => '192.168.1.98',
	'username' => 'postgres',
	'password' => '@dminP51',
	'database' => 'online_payment',
	'port'	   => '5432',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => TRUE,
	'db_debug' => DB_DBUG,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

/*
$db['default']['hostname'] = DB_HOST;
$db['default']['username'] = DB_USER;
$db['default']['password'] = DB_PASS;
$db['default']['database'] = DB_NAME;
$db['default']['dbdriver'] = DB_TYPE;
$db['default']['port']     = DB_PORT;
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = DB_DBUG;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;
*/
/*
$db['pad']['hostname'] = ESPTPD_DB_HOST;
$db['pad']['username'] = ESPTPD_DB_USER;
$db['pad']['password'] = ESPTPD_DB_PASS;
$db['pad']['database'] = ESPTPD_DB_NAME;
$db['pad']['dbdriver'] = ESPTPD_DB_TYPE;
$db['pad']['port']     = ESPTPD_DB_PORT;
$db['pad']['dbprefix'] = '';
$db['pad']['pconnect'] = TRUE;
$db['pad']['db_debug'] = DB_DBUG;
$db['pad']['cache_on'] = FALSE;
$db['pad']['cachedir'] = '';
$db['pad']['char_set'] = 'utf8';
$db['pad']['dbcollat'] = 'utf8_general_ci';
$db['pad']['swap_pre'] = '';
$db['pad']['autoinit'] = TRUE;
$db['pad']['stricton'] = FALSE;
*/

/*
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

// /* End of file database.php */
/* Location: ./application/config/database.php */