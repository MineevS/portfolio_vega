<?php
	session_start(); // Продлеваем сессию, запущенную из `action.php`

	//error_reporting(E_ALL);                                                     // For Debug ERROR:
    //ini_set('display_errors', 'On'); 

    $root = $_SERVER['DOCUMENT_ROOT'];

	require_once($root.'/assets/backend/paths.php');
	require_once($root.'/assets/backend/config/config_smarty.php');

	if(isset($_SESSION[TRU::icon->name]))
		$smarty->assign(TRU::icon->name, PATH_DEFAULT::PROFILE->value.$_SESSION[TRU::icon->name]); // $root. // '/assets/frontend/icons/avatars_profiles/'

	if(isset($_SESSION['project_id'])) unset($_SESSION['project_id']); // Если установлен `project_id`, то `убираем` его.

	$smarty->assign('tab_projects', TBN::PROJECTS->value);
	
	$smarty->assign("CSS_MAIN", STYLE::PROJECTS->value);
	$smarty->assign("MAIN", $root.'/assets/frontend/mains/main_for_projects.php'); // Указываем, что добавляем. (Реализуем и добавляем только основную часть кода);

    $smarty->display($root.'/../src/smarty_dirs/templates/main.tpl' );  // Указываем, куда добавляем и выводим обработанный шаблон.
?>