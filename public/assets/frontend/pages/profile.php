<?php

session_start(); // Продлеваем сессию, запущенную из `action.php`

$root = $_SERVER['DOCUMENT_ROOT'];

require_once($root . '/assets/backend/paths.php');
require_once($root . '/assets/backend/config/config_smarty.php');

if (!isset($_POST['id'])) unset($_SESSION['project_id']);

if(isset($_SESSION['id'])){ // заходим как авторизованный пользователь!
	$smarty->assign('access', (!isset($_POST['id']) || (isset($_POST['id']) && $_POST['id'] == $_SESSION['id']) ? true : false));

	if(!isset($_POST['id'])) $_POST['id'] = $_SESSION['id'];

	$smarty->assign(
		'icon',
		(isset($_SESSION[\TRU::icon->name])
			? '/assets/frontend/icons/avatars_profiles/' . $_SESSION[\TRU::icon->name]
			: '/assets/frontend/icons/default_avatar_profile.jpg')
		); 

} else { // Заходим как гость
	// TODO
}

$smarty->assign('id_author', $_POST['id']); 
$smarty->assign('tab_projects', \TBN::PROJECTS->value);

$smarty->assign('template_name_default_img', '/assets/frontend/icons/default_avatar_profile.jpg');

$smarty->assign("CSS_MAIN", \STYLE::PROFILE->value);
$smarty->assign("MAIN", $root . '/assets/frontend/mains/main_for_profile.php'); // Указываем, что добавляем. (Реализуем и добавляем только основную часть кода);

$smarty->assign("PAGE_PROJECT", \PAGE::PROJECT->value);

$smarty->assign("CSS_TOTAL", \STYLE::MAIN->value);
$smarty->display($root . '/../src/smarty_dirs/templates/main.tpl');  // Указываем, куда добавляем и выводим обработанный шаблон.
