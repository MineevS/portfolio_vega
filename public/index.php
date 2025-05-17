<?php
    namespace Vega\Portfolio;

    session_start(); // Продлеваем сессию, запущенную из `action.php`

    error_reporting(E_ALL);                                                     // For Debug ERROR:
    ini_set('display_errors', 'On');

    // echo $_SERVER['DOCUMENT_ROOT'].' '; // C:\projects\portfolio_serg\portfolio

    // echo __DIR__ ; // C:\projects\portfolio_serg\portfolio\public

    require_once __DIR__ . '/../vendor/autoload.php';

    // require_once($_SERVER['DOCUMENT_ROOT'].'/../vendor/autoload.php');

    // require_once('vendor/autoload.php');
    // require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
    // require_once($_SERVER['DOCUMENT_ROOT'].'/../vendor/autoload.php');

    $PATH_SRC = $_SERVER['DOCUMENT_ROOT']; //  . '\src';                             // echo __DIR__;

    require_once($PATH_SRC . '/assets/backend/config/config_smarty.php');       // var_dump($connectionParams);

    // Подключение путей.
	require_once($root . '/assets/backend/paths.php');

    if(isset($_SESSION[\TRU::icon->name]))
		$smarty->assign(\TRU::icon->name, \PATH_DEFAULT::PROFILE->value.$_SESSION[\TRU::icon->name]); // '/assets/frontend/icons/avatars_profiles/'

	if(isset($_SESSION['project_id'])) unset($_SESSION['project_id']); // Если установлен `project_id`, то `убираем` его.

	$smarty->assign('tab_projects',     \TBN::PROJECTS->value);                             // TABS_NAME
	$smarty->assign('tag_awesome',      \TBN::AWESOME->value); 
	$smarty->assign('tab_vacancies',    \TBN::VACANCIES->value);
	$smarty->assign('limit_vacancies',  \SIZE_LOAD_PAGE::$VACANCIES);

	$smarty->assign('PAGE_INTERESTS',   \PAGE::INTERESTS->value);

	$smarty->assign("CSS_MAIN",         \STYLE::INDEX->value);                              // 
	$smarty->assign("MAIN", 	        $root.'/assets/frontend/mains/main_for_index.php'); // Указываем, что добавляем. (Реализуем и добавляем только основную часть кода);
	
	// $smarty->assign("CSS_TOTAL", STYLE::MAIN->value);

    // $sid = session_id();

	$smarty->display($_SERVER['DOCUMENT_ROOT'].'/../src/smarty_dirs/templates/main.tpl' );     // Указываем, куда добавляем и выводим обработанный шаблон.
    
    // TODO <?php echo __DIR__  <?php echo $_SERVER['DOCUMENT_ROOT'] 
?>
