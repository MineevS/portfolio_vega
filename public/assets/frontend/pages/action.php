<?php
    session_start();

    enum ACTION {
        case registr;
        case login;
        case logout;

        case save_data_profile;
        case delete_data_profile;
        case save_data_project;
        case delete_data_project;
        case save_data_vacancy;
        case delete_data_vacancy;

        case load_projects;
        case load_project;
        case load_avatar_project;

        case delete_page;

        case check_like_project;
        case show_input_suggestion;
        case order_sort;
    }

    $root = $_SERVER['DOCUMENT_ROOT'];

require_once($root . '/assets/backend/config/config_smarty.php');

    $URL = ""; // ?
    $last_error_wdbc = 0; // ?

    if (!isset($_POST['action'])) exit();

require_once($root . '/assets/backend/auth_profile.php');

    $auth_profile = new AUTH_PORTFOLIO();

    switch ($_POST['action']) {
        case \ACTION::registr->name:
            $result = $auth_profile->register();

            $last_error_wdbc = $auth_profile->last_error();
            /*$URL = ($result 
                    ? "index.php?register=success" 
                    : "index.php?register=$last_error_wdbc"
                );*/

            echo json_encode(array(
                'register' => ($result ? "success" : "failed"),
                'error_code' => $last_error_wdbc
            )); // ( $result ?  "0" :  )
            break;
        case \ACTION::login->name:
            $result = $auth_profile->login($_POST['login'], $_POST['password']);

            $last_error_wdbc = $auth_profile->last_error();

            $URL = ($result
                ?  \PAGE::PFL->value
                : "index.php?error=$result"
            );

            echo json_encode(array(
                'login'      => ($result ? "success" : "failed"),
                'error_code' => $last_error_wdbc,
                'url'        => $URL
            ));

            break;
        case \ACTION::logout->name:
            session_destroy();
            $URL = "/index.php"; // ?logout=true

            echo json_encode(array(
                'logout'      => "success",
                'error_code' => 0,
                'url'        => $URL
            ));
            break;
        case \ACTION::save_data_profile->name:
            $result = $auth_profile->change_data_profile('save');
            break;
        case \ACTION::delete_data_profile->name:
            $result = $auth_profile->change_data_profile('delete');
            break;
        case \ACTION::load_projects->name:
            $count = \SIZE_LOAD_PAGE::$PROJECTS;
            $offset = $_POST['page_load_projects'] * $count;
            $tab = \TBN::PROJECTS->value; //'info_project'
            /*'info_project'*/
            $params = array(
                'select' => '*',
                'from' => "$tab",
                'orderby' => 'id',
                'limit' => "$count",
                'offset' => "$offset",
            );

            $content_html = trim(psql_query_projects($params, $smarty));

            //psql_query_projects($params, $smarty);

            //$content_html = '';
            //if($result) $data = $wdbc->responce();

            echo json_encode(array(
                'load_projects' => "success",
                'error_code' => 0,
                'data' => $content_html
            ));

            break;
        case \ACTION::save_data_project->name:
            // Смотреть на наличие `id` проекта. 
            // Если `id` проекта `есть`, то просто `сохранить` данные.
            // Если `нет`, то `создать` проект и `сохранить` данные.

            if (isset($_SESSION['project_id'])) { // ! Не путать $_SESSION['id']- Идентификатор пользователя в системе с $_POST['id'] - Идентификатор существующего(-ей) проекта/вакансии/команды.
                $_POST['project_id'] = $_SESSION['project_id'];

                // Редактирование проекта
                $result = $auth_profile->change_data_project('save');
            } else {
                // Создание проекта
                $project_id = $auth_profile->create_project();
                echo json_encode(array(
                    'save_data_project' => (isset($vacancy_id) ? "success" : "failed"),
                    'error_code' => 0,
                    'project_id' => $project_id /* Сообщаем `идентификатор созданого проекта` */
                ));
            }

            break;
        case \ACTION::delete_data_project->name:
            $result = $auth_profile->change_data_project('delete');

            break;
        case \ACTION::load_avatar_project->name:
            if (isset($_FILES['avatar'])) {
                $auth_profile->save_img('./../icons/avatars_projects', \TBN::PROJECTS->value, $_SESSION['project_id'], 'project-icon');
            }
            break;
        case \ACTION::save_data_vacancy->name:
            if (isset($_SESSION['vacancy_id'])) { 
                $_POST['vacancy_id'] = $_SESSION['vacancy_id'];

                // Редактирование вакансии
                $result = $auth_profile->change_data_vacancy('save');

            } else {
                // Создание вакансии
                $vacancy_id = $auth_profile->create_vacancy();
                echo json_encode(array(
                    'save_data_vacancy' => (isset($vacancy_id) ? "success" : "failed"),
                    'error_code' => 0,
                    'vacancy_id' => $vacancy_id /* Сообщаем `идентификатор созданого проекта` */
                ));
            }
            break;
        case \ACTION::delete_data_vacancy->name:
            $result = $auth_profile->change_data_vacancy('delete');
            break;
        case \ACTION::check_like_project->name: // Установка/снятие лайков на проект;
            $ckeck_like_project = $auth_profile->check_like_project();

            $pid = $_POST['project_id'];
            $sid = session_id();
    
            // Получение наличие лайка на конкретный проект от текущего пользователя
            $count_like_pid_sid = psql_query_like_project($pid, $sid); 

            echo json_encode(array(
                'check_like_project' => ($ckeck_like_project >= 0 ? "success" : "failed" ),
                'error_code' => 0,
                'is_like' => ($count_like_pid_sid > 0 ? true : false), 
                'like' => $ckeck_like_project,
                'project_id' => $_POST['project_id']
            ));

            break;
        case \ACTION::show_input_suggestion->name: // Подсказка для поиска проектов;
            
            $search = $_POST['search'];
            $tab = \TBN::PROJECTS->value; //'info_project'
            $params = array(
                'select' => '*',
                'from' => "$tab",
                'orderby' => 'id',
                'where' => "name",
                'ilike' => "'$search%'",
            );

            $content_html = psql_query_projects($params, $smarty);

            //psql_query_projects($params, $smarty);

            //$content_html = '';
            //if($result) $data = $wdbc->responce();

            echo json_encode(array(
                'load_projects' => "success",
                'error_code' => 0,
                'data' => $content_html // $wdbc->query()->request()
            ));

            break;
        case \ACTION::order_sort->name: // Подсказка для поиска проектов;

            $type = $_POST['type'];
            $page = $_POST['page'];

            $tab = '';
            $col = 'premier';
            $ordebytype = \OBT::ASC->name;
            switch($page){
                case 'profiles':
                    break;
                case 'projects':
                    $tab = \TBN::PROJECTS->value; //'info_project'

                    switch($type){
                        case 'new':
                            break;
                        case 'old':
                            $ordebytype = \OBT::DESC->name;
                            break;
                        case 'rel':
                            break;
                    }
                
                    break;
                case 'vacancies':
                    break;                      
            }

            /*
            LIMIT 10;
            groupby('create')
            orderByType(OBT::ASC->value)
            ASC/DESC
            */
            
            
            $params = array(
                'select' => '*',
                'from' => "$tab",
                'orderby' => $col, // asc добавить
                'orderbytype' => $ordebytype 
            );

            $content_html = trim(psql_query_projects($params, $smarty));

            //psql_query_projects($params, $smarty);

            //$content_html = '';
            //if($result) $data = $wdbc->responce();

            echo json_encode(array(
                'load_projects' => "success",
                'error_code' => 0,
                'data' => $content_html // $wdbc->query()->request()
            ));
        
            break;
        case \ACTION::delete_page->name:
            $res = $auth_profile->delete_page();

            echo json_encode(array(
                'delete_page' => "success",
                'error_code' => 0,
                'data' => ''
            ));

            break;
    }
    
    exit();
?>