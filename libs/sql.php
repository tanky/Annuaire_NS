<?php

if (!defined('ANNUAIRE'))
{
	die();
}

function		get_sql_result($sql_query, $sql_link)
{
	if (($result = mysql_query($sql_query, $sql_link)) === false)
	{
		display_critical_error(DEFAULT_MSG_CRITICAL_ERROR . DEFAULT_MSG_SQL_ERROR);
	}
	return ($result);
}


function		get_sql_array_from_result($sql_result, $sql_result_type = MYSQL_BOTH)
{
	$result = array();
	while (($row = mysql_fetch_array($sql_result, $sql_result_type)) !== false)
	{
		$result[] = $row;
	}
	return ($result);
}

function 		get_sql_assoc_from_result($sql_result)
{
	$result = array();
	while (($row = mysql_fetch_assoc($sql_result)) !== false)
	{
		$result[] = $row;
	}
	return ($result);
}

?>