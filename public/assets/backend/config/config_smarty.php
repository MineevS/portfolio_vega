<?php

	$root = $_SERVER['DOCUMENT_ROOT']; //  . '/public'

	// Подключение зависимостей DBAL, Smarty.
	require_once($_SERVER['DOCUMENT_ROOT'].'/../vendor/autoload.php');

	// Подключение путей.
	require_once($root . '/assets/backend/paths.php');
	
	// Подключение БД.
	require_once($root . '/assets/backend/config/config_db.php'); 		// var_dump($connectionParams);

	$smarty = new Smarty\Smarty; 											// создаем экземпляр класса Smarty

	// SETTINGS SMARTY:
	// указываем, где находятся Smarty-директории
	$smarty->setConfigDir($root . '/smarty_dirs/configs/');
	$smarty->setCacheDir($root . '/smarty_dirs/cache/');
	$smarty->setCompileDir($root . '/smarty_dirs/templates_c/');
	$smarty->setTemplateDir($root . '/smarty_dirs/templates/');
	// $smarty->setEscapeHtml(true);
	// $smarty->caching = Smarty\Smarty::CACHING_LIFETIME_CURRENT;

	// Регистрация фикций(Плагинов) Smarty:
	require_once($root . '/assets/backend/functions.php');

	$smarty->registerPlugin("function", "date_now", "print_current_date"); // ???

	$smarty->registerPlugin("function", "query_projects",           "psql_query_projects");
	$smarty->registerPlugin("function", "query_interests",          "psql_query_interests");
	$smarty->registerPlugin("function", "query_stars",              "psql_query_stars");
	$smarty->registerPlugin("function", "query_vacancies",          "psql_query_vacancies");
	//$smarty->registerPlugin("function", "query_intelligence",       "psql_query_intelligence");
	$smarty->registerPlugin("function", "query_properties_profile", "psql_query_properties_profile");
	$smarty->registerPlugin("function", "query_properties_project", "psql_query_properties_project");
	$smarty->registerPlugin("function", "query_article",            "psql_query_article");
	$smarty->registerPlugin("function", "query_authors",            "psql_query_authors");
	$smarty->registerPlugin("function", "query_teams",              "psql_query_teams");
	$smarty->registerPlugin("function", "query_feedback",           "psql_query_feedback");
	$smarty->registerPlugin("function", "query_screenshots",        "psql_query_screenshots");
	$smarty->registerPlugin("function", "query_vacancy",            "psql_query_vacancy");
	$smarty->registerPlugin("function", "query_properties_vacancy", "psql_query_properties_vacancy");
	//$smarty->registerPlugin("function", "query_editor_button",      "psql_query_editor_button");
	$smarty->registerPlugin("function", "query_header_page",        "psql_query_header_page");

	$smarty->registerPlugin("function", "query_input",              "query_input");
	$smarty->registerPlugin("function", "query_properties_add",     "query_properties_add");
	$smarty->registerPlugin("function", "query_editor_button",      "query_editor_button");
	$smarty->registerPlugin("function", "query_like_project",       "psql_query_like_project");

	
	// $smarty->testInstall(); 

	$smarty->assign("FCN", TOTAL::FCN->value);
	$smarty->assign("CSS", INDEX::CSS->value);

	$smarty->assign("SJS", TOTAL::SJS->value);
	$smarty->assign("JSX", INDEX::JSX->value);
	$smarty->assign("JQR", TOTAL::JQR->value);
	$smarty->assign("HFR", AUTH::PATH->value);

	// $smarty->assign("name", 'Alex');

	$smarty->assign("PROJECTS",  NAV::PRJ->value);
	$smarty->assign("TEAMS",     NAV::TMS->value);
	$smarty->assign("VACANCIES", NAV::VAC->value);

	$smarty->assign("ACTION",   PAGE::ACT->value);      // Страница сервера для выхода; // Общение с сервером осуществляется по одной странице!
	$smarty->assign("INDEX",    INDEX::PATH->value);    // Страница `index.php`;
	$smarty->assign("PROFILE",  PAGE::PFL->value);      // Страница `profile.php`;

	$smarty->assign("CSS_AOS",  AOS::CSS->value); //
	$smarty->assign("AOS", 		AOS::JSX->value); 

	$smarty->assign("CSS_SELECT2",  SELECT2::CSS->value); 
	$smarty->assign("SELECT2", 		SELECT2::JSX->value); 

	$smarty->assign("JSREACT", 		JSLIB::REACT_DEV->value); // REACT_PRO, REACT_DEV
	$smarty->assign("JSAPP", 		JSLIB::APP->value); 


	// TODO 

	$smarty->assign("CSS_TOTAL", STYLE::MAIN->value);

	$smarty->assign('SIZE_PAGE_PROJECTS', SIZE_LOAD_PAGE::$PROJECTS);
	$smarty->assign('SIZE_PAGE_VACANCIES', SIZE_LOAD_PAGE::$VACANCIES);
	$smarty->assign('SIZE_PAGE_TEAMS', SIZE_LOAD_PAGE::$TEAMS);

	$smarty->assign('template_name_default_img_project', 'default_avatar_project.jpg'); // /assets/frontend/icons/
	$smarty->assign('page_default', \INDEX::PATH->value); // Страница для перехода при удалении других страниц.

	// $smarty->display("main.tpl");  // выводим обработанный шаблон
?>