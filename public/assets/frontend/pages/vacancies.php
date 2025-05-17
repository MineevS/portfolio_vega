<?php
	session_start(); // Продлеваем сессию, запущенную из `action.php`

    $root = $_SERVER['DOCUMENT_ROOT'];

	require_once($root.'/assets/backend/paths.php');
	require_once($root.'/assets/backend/config/config_smarty.php');

	/*if(isset($_SESSION[TRU::icon->name])){
		$smarty->assign(TRU::icon->name, '/assets/frontend/icons/'.$_SESSION[TRU::icon->name]); // $root.
	}*/

	if(isset($_SESSION[TRU::icon->name]))
		$smarty->assign(TRU::icon->name, PATH_DEFAULT::PROFILE->value.$_SESSION[TRU::icon->name]);

	if(isset($_SESSION['project_id'])) unset($_SESSION['project_id']); // Если установлен `project_id`, то `убираем` его.

	$smarty->assign('tab_vacancies', TBN::VACANCIES->value);
	$smarty->assign('limit_vacancies', SIZE_LOAD_PAGE::$VACANCIES);

	$smarty->assign("CSS_MAIN", STYLE::VACANCIES->value);
	$smarty->assign("MAIN", $root.'/assets/frontend/mains/main_for_vacancies.php'); // Указываем, что добавляем. (Реализуем и добавляем только основную часть кода);
    
	/*$smarty->assign("CSS_TOTAL", STYLE::MAIN->value);*/
	$smarty->display($root.'/../src/smarty_dirs/templates/main.tpl' );  // Указываем, куда добавляем и выводим обработанный шаблон.
?>