<?php

	require_once($_SERVER['DOCUMENT_ROOT'].'/assets/backend/config/paths.php');

	require_once($_SERVER['DOCUMENT_ROOT'].TOTAL::CDB->value);             /* -> [$dbname, $host, $port, $user, $passwd]; -> './config/config_db.php'*/
	require_once($_SERVER['DOCUMENT_ROOT'].TOTAL::WDBC->value);             /* -> WrapperDataBase(); -> './config/WrapperDataBaseConn.php' */

	$wdbc = new WDBC($dbname, $host, $port, $user, $passwd);

?>


function smarty_function_custom($params, &$smarty){
    return 'Hello, ' . htmlspecialchars($params['name']);
}