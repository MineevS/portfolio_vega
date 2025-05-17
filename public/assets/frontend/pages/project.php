<?php
	session_start(); // Продлеваем сессию, запущенную из `action.php`

	// Включите вывод ошибок для отладки
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);

	// Проверьте полученные данные
	//var_dump($_POST); // Для POST-запросов
	//var_dump($_GET);  // Для GET-запросов

    $root = $_SERVER['DOCUMENT_ROOT'];

	require_once($root.'/assets/backend/paths.php');

	require_once($root.'/assets/backend/config/config_smarty.php');

	if(isset($_POST['id'])) $_SESSION['project_id'] = $_POST['id'];

	if(isset($_SESSION['vacancy_id'])) unset($_SESSION['vacancy_id']); // Если поднимается на уровень выше, то сбрасываем `vacancy_id`;

	if(isset($_SESSION['id'])  && isset($_SESSION['project_id'])){ // Если мы вошли в систему
		global $conn;

		$data = $conn->createQueryBuilder()
			->select('author')
			->from(\TBN::PROJECTS->value)
			->where('id =' . $_SESSION['project_id'], 'author = '. $_SESSION['id'])
			->executeQuery()
			->fetchAllAssociative();

		if(count($data) === 1){
			$smarty->assign('id_author', $_SESSION['id']); // Показываем текущему пользователю только его проекты.
			$smarty->assign('access', true);
		} //OPBIN::AND, 'author', $_SESSION['id']

	/*	
		$smarty->assign('icon', 
		(isset($_SESSION[\TRU::icon->name]) 
			? \PATH_DEFAULT::PROFILE->value.$_SESSION[TRU::icon->name] // '/assets/frontend/icons/avatars_profiles/'
			: \ICON_DEFAULT::PROFILE->value)); // '/assets/frontend/icons/default_avatar_profile.jpg'
	*/
	} 


	if(isset($_SESSION['id'])){
		$smarty->assign('icon', 
		(isset($_SESSION[\TRU::icon->name]) 
			? \PATH_DEFAULT::PROFILE->value.$_SESSION[TRU::icon->name] // '/assets/frontend/icons/avatars_profiles/'
			: \ICON_DEFAULT::PROFILE->value)); // '/assets/frontend/icons/default_avatar_profile.jpg'
	}

	/* 14.01.25 - 7:40 */
	/* 
		Если: в $_SESSION есть `project_id`, то загрузить данные в из БД для существующего проекта.
	   	Иначе: Отобразить страницу на создание проекта.
	 */
	if(isset($_SESSION['project_id'])){
		// Ранее сохраненный проект
		$smarty->assign('project_id', $_SESSION['project_id']);

	} else {
		// Новый проект
		$smarty->assign('icon_default', '/assets/frontend/icons/default_avatar_project.jpg');
		$smarty->assign('name_default', "Новый проект");
		$smarty->assign('access', true);
	}

	/* */

// {query_properties_project for="properties"}
    /*
	$smarty->assign('firstname', 
	(isset($_SESSION[TRU::firstname->name]) ? $_SESSION[TRU::firstname->name] : 'firstname'));
    */
/*
	$smarty->assign('lastname', 
	(isset($_SESSION[TRU::lastname->name]) ? $_SESSION[TRU::lastname->name] : 'lastname'));
    */

	$smarty->assign('template_name_default_img', '/assets/frontend/icons/default_avatar_project.jpg');


	$smarty->assign('tab_vacancies', \TBN::VACANCIES->value);

	$smarty->assign("CSS_MAIN", \STYLE::PROJECT->value);
	$smarty->assign("MAIN", $root.'/assets/frontend/mains/main_for_project.php'); // Указываем, что добавляем. (Реализуем и добавляем только основную часть кода);
    
	
	$smarty->assign("PAGE_VACANCY", \PAGE::VACANCY->value);

	/*$smarty->assign("CSS_TOTAL", STYLE::MAIN->value);*/
	$smarty->display($root.'/../src/smarty_dirs/templates/main.tpl' );  // Указываем, куда добавляем и выводим обработанный шаблон.
?>