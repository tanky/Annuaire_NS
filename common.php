<?php
@session_start();

//CHECK_VALID_PAGE
if (!defined('ANNUAIRE'))
{
	die();
}

// inclusion_lib_php
require_once("" . "libs/" . 'sql.php');

// MYSQL INFOS
global $mysql_server, $mysql_username, $mysql_password, $mysql_dbname;

$mysql_server = 'localhost';
$mysql_username = "root";
$mysql_password = "";
$mysql_dbname = 'annuaire_ns';

define('SECURED_INT', 0);
define('SECURED_SQL_STRING', 1);
define('SECURED_HTML_STRING', 2);

// DEFAULT MSG
define('DEFAULT_MSG_CRITICAL_ERROR', 'Critical error : ');
define('DEFAULT_MSG_UNKNOWN_ERROR', 'Unknown error');
define('DEFAULT_MSG_MYSQL_ERROR', 'MYSQL Error');
define('DEFAULT_MSG_SQL_ERROR', 'SQL Error');

// SQL INIT
$mysql_link = @mysql_connect($mysql_server, $mysql_username, $mysql_password);

if ($mysql_link === false)
{
	display_critical_error(DEFAULT_MSG_CRITICAL_ERROR . DEFAULT_MSG_MYSQL_ERROR . " Impossible de se connecter au serveur");
}

if (mysql_select_db($mysql_dbname, $mysql_link) === false)
{
	display_critical_error(DEFAULT_MSG_CRITICAL_ERROR . DEFAULT_MSG_MYSQL_ERROR . "Impossible d'utiliser la base de données");
}
?>