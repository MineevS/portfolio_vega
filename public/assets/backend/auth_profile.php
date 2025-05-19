<?php
class AUTH_PORTFOLIO
{
    function login($login, $password)
    {
        global $conn;

        $responce =  $conn->createQueryBuilder()
            ->select('*')
            ->from(\TBN::PROFILES->value) // TAB_REGISTRATION_USER
            ->where("login = :login")
            ->setParameter('login', $login)
            ->executeQuery()->fetchAllAssociative();

        if (isset($responce)) {
            // $responce = $this->query->responce();

            foreach ($responce as $row_data) {
                $hash_from_db = $row_data[\TRU::hash->name];

                // Проверка на блокировку профиля:
                $stprofile = $row_data[\TRU::status->name];

                if ($stprofile == "block") {
                    $this->last_error = \ERRORCODE::BLOCK_PROFILE->value;
                    return false;
                }

                $result = password_verify($password, $hash_from_db);
                if ($result) {
                    /*$_SESSION['isLogin'] = true;
                        $_SESSION['id']      = $row[0];
                        $_SESSION['nik']     = $row[1];
                        $_SESSION['nama']    = $row[2];
                        $_SESSION['email']   = $row[3];
                        $_SESSION['telp']    = $row[4];
                        $_SESSION['alamat']  = $row[5];*/

                    $_SESSION[\TRU::id->name]         = $row_data[\TRU::id->name];
                    $_SESSION[\TRU::firstname->name]  = $row_data[\TRU::firstname->name];
                    $_SESSION[\TRU::lastname->name]   = $row_data[\TRU::lastname->name];
                    $_SESSION[\TRU::patronymic->name] = $row_data[\TRU::patronymic->name];
                    $_SESSION[\TRU::login->name]      = $row_data[\TRU::login->name];
                    $_SESSION[\TRU::roles->name]      = $row_data[\TRU::roles->name];
                    $_SESSION[\TRU::icon->name]       = $row_data[\TRU::icon->name];
                    $_SESSION[\TRU::hash->name]       = $row_data[\TRU::hash->name];
                    $_SESSION[\TRU::email->name]      = $row_data[\TRU::email->name];
                    $_SESSION[\TRU::telephone->name]  = $row_data[\TRU::telephone->name];
                    $_SESSION[\TRU::status->name]     = $row_data[\TRU::status->name];

                    $this->last_error = \ERRORCODE::UNBLOCK_PROFILE->value;
                } else {
                    $_SESSION['message'] = "Password error!";

                    $this->last_error = \ERRORCODE::PASSWORD->value;
                }
                return $result;
            }
        } else {
            $_SESSION['message'] = "Not find account!";
            return 'account';
        }
    }

    function validate_post_args()
    {
        $count_args = func_num_args();
        $_SESSION['message'] = "";
        for ($index_arg = 0; $index_arg < $count_args; $index_arg++) {
            $arg = func_get_arg($index_arg);
            if (!isset($_POST[$arg])) {
                $_SESSION['message'] = $arg;
                return $arg;
                exit;
            }
        }
    }

    function save_data_profile()
    {
        global $conn;

        $query = $conn->createQueryBuilder()
            ->select('column_name, data_type')
            ->from('information_schema.columns')
            ->where("table_name = '" . \TBN::PROFILES->value . "'")
            ->executeQuery();

        // $_POST['id'] = $_SESSION['id']; // Не изменяем!

        $pkeys = array_keys($_POST);
        $fkeys = array_keys($_FILES);

        $status_query = false;
        foreach ($query->iterateKeyValue() as $cn => $type) {
            $status_key_in_post  = in_array($cn, $pkeys);
            $status_key_in_files = in_array($cn, $fkeys);

            if ($status_key_in_post) {
                $data = $_POST[$cn];

                switch ($cn) {
                    case 'icon':
                        break;
                    default:
                        $query = $conn->createQueryBuilder()
                            ->update(\TBN::PROFILES->value);

                        $cn = "\"$cn\""; // Учет совпадения названий с зарезервированными словами psql (например: group);
                        switch ($type) {
                            case 'bigint':
                                $query->set($cn, $data);
                                break;
                            case 'json':
                            case 'text':
                                $query->set($cn, "'$data'");
                                break;
                        }

                        $count = $query->where('id = ' . $_SESSION['id'])->executeQuery();

                        if ($count == 1 && !$status_query) $status_query = true;

                        break;
                };
            } else if ($status_key_in_files) {
                switch ($cn) {
                    case 'icon':
                        $this->save_img(
                            './../../frontend/icons/avatars_profiles',  /* Указать, в какую директорию загружать */
                            \TBN::PROFILES->value,
                            $_SESSION['id'],
                            $cn
                        );

                        // TODO
                        break;
                    default:
                        break;
                }
            } else {
                if (
                    $cn == 'id'    || $cn == 'login' || $cn == 'roles'
                    || $cn == 'icon'  || $cn == 'hash'  || $cn == 'telephone'
                    || $cn == 'email' || $cn == 'status'
                ) continue;

                $cname_rror = $cn;

                /* Не обновляются: 
                        id, login, roles(роли пользователя), 
                        icon (глобально, только локально), hash, 
                        telephone, email, status(статус аккаунта: разблокирован или заблокирован)
                    */

                // TODO
            }
        }

        return $status_query;
    }

    function change_data($tab_name, $type_changed, $folder_for_load_avatar)
    {
        global $conn;

        $query = $conn->createQueryBuilder()
            ->select('column_name, data_type')
            ->from('information_schema.columns')
            ->where("table_name = '" . $tab_name . "'")
            ->executeQuery();

        // profile: $_POST['id'] = $_SESSION['id']; // Не изменяем!

        $pkeys = array_keys($_POST);
        $fkeys = array_keys($_FILES);
        $del_val_id = 'id';

        if (($key = array_search($del_val_id, $pkeys)) !== false) {
            unset($pkeys[$key]); // id не меняется !!!
        }

        $status_query = false;
        foreach ($query->iterateKeyValue() as $cn => $type) {
            $status_key_in_post  = in_array($cn, $pkeys);
            $status_key_in_files = in_array($cn, $fkeys);

            $query_data = function ($tab_name, $cn) {
                global $conn;
                // Получение json-данных
                $pre_data = $conn->createQueryBuilder()
                    ->select("\"$cn\"")
                    ->from($tab_name)
                    ->where('id = ' . $_POST['id']) // $_SESSION['id']
                    ->executeQuery()
                    ->fetchOne();

                return $pre_data;
            };

            if ($status_key_in_post) {
                $data = $_POST[$cn];

                switch ($type_changed) {
                    case 'delete':
                        switch ($type) {
                            case 'json':
                                // Получение json-данных
                                /*$pre_data = $conn->createQueryBuilder()
                                        ->select("\"$cn\"")
                                        ->from($tab_name)
                                        ->where('id = '. $_SESSION['id'])
                                        ->executeQuery()
                                    ->fetchOne();*/

                                $pre_data = $query_data($tab_name, $cn);

                                // Экспорт строки json-данных в объект json.
                                $json_data = json_decode($pre_data);

                                // Удаление не актуальных данных.
                                $del_val = json_decode($data);

                                $check_val = function (&$array, $val) {
                                    if (($index = array_search($val, $array)) !== false) {
                                        unset($array[$index]);
                                    }
                                };

                                if ($json_data instanceof stdClass && $del_val instanceof stdClass) {
                                    foreach ($del_val as $key => $value) {
                                        foreach ($value as $d_val) {
                                            $dv = $d_val;
                                            if (property_exists($json_data, $key)) {
                                                $check_val($json_data->$key, $dv);
                                            } else {
                                                // Несовпадение ключей
                                            }
                                        }

                                        // TODO
                                    }
                                } else if ($json_data instanceof stdClass) {
                                    $dv  = $del_val;

                                    // Нет информации о ключе по которому изменять данные в json_data.

                                    // TODO
                                } else if ($del_val instanceof stdClass) {
                                    // $array = $json_data;
                                    foreach ($del_val as $key => $value) { // 1
                                        foreach ($value as $d_val) {
                                            $dv = $d_val; // 1

                                            $check_val($json_data, $dv);
                                        }
                                    }
                                } else {
                                    // $array = $json_data;
                                    // $dv    = $del_val;

                                    foreach ($del_val as $dv) {
                                        $check_val($json_data, $dv);
                                    }
                                }

                                // Запись обратно в json-строку для последующего обновления данных.
                                $data = json_encode($json_data, false);
                                break;
                            case 'bigint':
                            case 'text':
                                break;
                        }
                        break;
                    case 'save':
                        switch ($cn) {
                            case 'icon':
                                break;
                            case 'feedback':
                                $data_old = $query_data($tab_name, $cn);

                                // Экспорт строки json-данных в объект json.
                                $objectB = json_decode($data_old);
                                $objectA = json_decode($data);

                                // Объединение данных;
                                foreach ($objectA as $k => $v) $objectB->$k = $v;

                                // Экспорт в json;
                                $data = json_encode($objectB);

                                break;
                        }
                        break;
                }

                switch ($cn) {
                    case 'icon':
                        break;
                    default:
                        $query = $conn->createQueryBuilder()->update($tab_name);

                        $cn = "\"$cn\""; // Учет совпадения названий с зарезервированными словами psql (например: group);
                        switch ($type) {
                            case 'bigint':
                                $query->set($cn, $data);
                                break;
                            case 'json':
                            case 'text':
                                $query->set($cn, "'$data'");
                                break;
                        }

                        $count = $query->where('id = ' . $_POST['id'])->executeQuery(); // $_SESSION['id']

                        if ($count == 1 && !$status_query) $status_query = true;
                        break;
                }
            } else if ($status_key_in_files) {
                switch ($cn) {
                    case 'icon':
                        $this->save_img(
                            './../../frontend/icons/' . $folder_for_load_avatar,  /* Указать, в какую директорию загружать */
                            $tab_name,
                            $_POST['id'],
                            $cn,
                            true
                        ); // avatars_profiles // $_SESSION['id']
                        break;
                    case 'screenshots':
                        $folder_for_load_screenshots = "screens_for_project_id_" . $_POST['id'];
                        $this->save_img(
                            './../../frontend/img/projects/' . $folder_for_load_screenshots,  /* Указать, в какую директорию загружать */
                            $tab_name,
                            $_POST['id'],
                            $cn,
                            false
                        ); // avatars_profiles // $_SESSION['id']
                        //ToDo Реализовать функционал для удаления сриншотов
                        break;
                    default:
                        break;
                }
            } else {
                // Для profile:
                if (
                    $cn == 'id'    || $cn == 'login' || $cn == 'roles'
                    || $cn == 'icon'  || $cn == 'hash'  || $cn == 'telephone'
                    || $cn == 'email' || $cn == 'status'
                ) continue;

                $cname_rror = $cn;

                /* Не обновляются:
                    // Для profile: 
                        id, login, roles(роли пользователя), 
                        icon (глобально, только локально), hash, 
                        telephone, email, status(статус аккаунта: разблокирован или заблокирован)
                    */

                // TODO
            }
        }

        return $status_query;
    }

    function change_data_profile($type_changed)
    {
        $tab_name = \TBN::PROFILES->value;

        $_POST['id'] = $_SESSION['id'];

        return $this->change_data($tab_name, $type_changed, 'avatars_profiles');
    }

    function change_data_project($type_changed)
    {
        $tab_name = \TBN::PROJECTS->value;

        $_POST['id'] = $_POST['project_id'];

        return $this->change_data($tab_name, $type_changed, 'avatars_projects');
    }

    function change_data_vacancy($type_changed)
    {
        $tab_name = \TBN::VACANCIES->value;

        $_POST['id'] = $_POST['vacancy_id'];

        return $this->change_data($tab_name, $type_changed, ''); // 'avatars_vacancy'
    }


    private $list_properties_project = [ // Добавить свойства проекта при необходимости
        'name',
        'premier',
        'status',
        'stack',
        'tags',
        'author',
        'communities',
        'experts',
        'description'
    ]; // populars_ // 'date_preview', 'scores_communities', 'scores_experts',

    private $list_properties_vacancy = [ // Добавить свойства `вакансии` при необходимости
        'speciality',
        'description',
        'tags',
        'duties',
        'project_id'
    ]; // populars_ // 'date_preview', 'scores_communities', 'scores_experts',


    function save_data_vacancy()
    {
        $_POST['project_id'] = $_SESSION['project_id']; // Добавление текущего `project_id` проекта в качестве `родителя` создаваемой вакансии!

        $list_properties = $this->list_properties_vacancy;

        $this->validate_post_args(...$list_properties); // 'avatar', 

        $this->query->update(\TBN::VACANCIES->value);

        //if(isset($_POST['avatar'])){ array_push($list_properties, 'avatar'); $_SESSION['icon-project'] = $_POST['avatar']; }

        $status_query = $conn->createQueryBuilder()
            ->set(...$list_properties)
            ->where('id = :id')
            ->setParameter('id', $_POST['vacancy_id'])
            ->executeQuery()
            ->fetchAllAssociative();
        //->exec();

        // --------------------

        return $status_query;
    }

    function create_project()
    {
        global $conn;

        $_POST['author'] = $_SESSION['id']; // Добавление текущего `id` пользователя в качестве `автора` создаваемого проекта!

        if (isset($_POST['icon'])) {
            array_push($list_properties, 'icon');
            $_SESSION['icon-project'] = $_POST['icon'];
        }

        $tabname = \TBN::PROJECTS->value;

        $tabn_id = $tabname . '_id_seq';

        $sql1 = "SELECT nextval('$tabn_id')"; // -- Текущее значение последовательности
        $sql2 = "SELECT MAX(id) FROM $tabname";  // -- Максимальный существующий ID
        $sql3 = "SELECT setval('$tabn_id', (SELECT MAX(id) FROM $tabname))";


        $sql = 'INSERT INTO ' . \TBN::PROJECTS->value . ' (name, status, author) VALUES (?, ?, ?) RETURNING id';
        $params = [$_POST['name'], $_POST['status'], $_SESSION['id']];

        $query_data = function ($sql, $params) {
            global $conn;
            $result = $conn->executeQuery($sql, $params)->fetchOne();
            return $result;
        };

        $nextval = $query_data($sql1, []);
        $id = $query_data($sql2, []);

        // Если nextval меньше MAX(id), обновить последовательность:
        if ($nextval < $id) $d3 = $query_data($sql3, []);

        $insertedId = $query_data($sql, $params);

        $_POST['project_id'] = $insertedId; // Для последующего сохранения данных
        $_SESSION['project_id'] = $insertedId; // Для удержания информации о выбранном на текущий момент проекте.

        $this->change_data_project('save'); // Сохранение остальных данных;      

        return $insertedId;
    }

    function create_vacancy()
    {
        global $conn;

        $_POST['project_id'] = $_SESSION['project_id']; // Добавление текущего `id` проекта в качестве `родителя` создаваемой вакансии!

        $tabname = \TBN::VACANCIES->value;

        $tabn_id = $tabname . '_id_seq';

        $sql1 = "SELECT nextval('$tabn_id')"; // -- Текущее значение последовательности
        $sql2 = "SELECT MAX(id) FROM $tabname";  // -- Максимальный существующий ID
        $sql3 = "SELECT setval('$tabn_id', (SELECT MAX(id) FROM $tabname))";

        $sql = 'INSERT INTO ' . $tabname . ' (speciality, description, project_id) VALUES (?, ?, ?) RETURNING id';
        $params = [$_POST['speciality'], $_POST['description'], $_POST['project_id']];

        $query_data = function ($sql, $params) {
            global $conn;
            $result = $conn->executeQuery($sql, $params)->fetchOne();
            return $result;
        };

        $nextval = $query_data($sql1, []);
        $id = $query_data($sql2, []);

        // Если nextval меньше MAX(id), обновить последовательность:
        if ($nextval < $id) $d3 = $query_data($sql3, []);

        $insertedId = $query_data($sql, $params);

        $_POST['vacancy_id'] = $insertedId; // Для последующего сохранения данных
        $_SESSION['vacancy_id'] = $insertedId; // Для удержания информации о выбранной на текущий момент вакансии.

        $this->change_data_vacancy('save'); // Сохранение остальных данных;      

        return $insertedId;
    }

    function register()
    {
        $this->validate_post_args('firstname', 'lastname', 'telephone', 'email', 'login', 'password');

        $status_query = $this->query                    // Проверка, существует под данным логином  учетная запись ?
            ->select('*')
            ->from(\TBN::TAB_REGISTRATION_USER->value)
            ->where("login", $_POST['login'])
            ->exec();

        // $status_query = false; // For Debug;

        $error_code = 1;
        if ($status_query) { // $status_query
            if (count($this->query->responce()) == 0) {

                // variance: one;
                /*  
                        $hash_pswd = password_hash($this->clean_escape($_POST['password']), PASSWORD_DEFAULT);
                        $status_query = $this->query
                            ->insert_into(TABS_NAME::TAB_REGISTRATION_USER->value)
                            ->columns("id", "firstname", "lastname", "telephone", "email", "password")                                                      // , "firstname", "lastname", "login", "passwd", "roles","icons"
                            ->values($_POST['id'], $_POST['firstname'], $_POST['lastname'], $_POST['telephone'], $_POST['email'], $_POST['password'])       // ,"root", "toor", "root@toor.com", "1234", 
                        ->exec();
                    */

                // variance: two;
                $status_query = $this->query
                    ->insert_into(\TBN::TAB_REGISTRATION_USER->value)
                    ->values_from_columns("firstname", "lastname", "telephone", "email", "login", "password")
                    ->exec();

                $error_code = ($status_query ? 0 : 3);
            } else {
                $error_code = 2;
            }
        }

        /*switch($error_code){
                case 0:
                    break;
                case 1:
                    break;
                case 2:
                    break;
                case 3;
                    break;
            }*/

        $this->last_error = $error_code;

        $_SESSION['message'] = ($status_query ? "success_register" : "failed_register");

        return $status_query;
    }

    function last_error()
    {
        return $this->last_error;
    }

    function clean_escape($val)
    {
        return pg_escape_string($val);
    }

    function getCountLikeForProjectId($pid)
    { // Для определения общего количества лайков на конкретный проект от всех пользователей, которые поставили соответствующий like.
        global $conn;

        $count_like_project_id = $conn->createQueryBuilder()
            ->select('count(*)')
            ->from(\TABS_NAME::LIKE_PROJECT->value)
            ->where('project_id = ' . $pid) /* $_POST['project_id'] */
            ->executeQuery()
            ->fetchOne();

        return ($count_like_project_id != false ? $count_like_project_id : 0);
    }

    function check_like_project()
    {
        global $conn;

        $pid = $_POST['project_id'];
        $sid = session_id();

        // Определение количества лайков на конкретный проект от конкретного пользователя
        /*$result_data = $conn->createQueryBuilder()
                ->select('*')
                ->from(\TABS_NAME::LIKE_PROJECT->value)
                ->where('project_id = ' . $pid)
                ->andWhere('phpsessid = :sid ')
                ->setParameter('sid', $sid)
                ->executeQuery()
            ->fetchAllAssociative();
            if(!isset($result_data)) return 0;*/

        $count_likes_pid_sid = psql_query_like_project($pid, $sid);

        $sgn = -1;
        if ($count_likes_pid_sid > 0) { // Если `like` уже имеется, то снять (удалить запись). // count($result_data)
            $status_query = $conn->createQueryBuilder()
                ->delete(\TABS_NAME::LIKE_PROJECT->value)
                ->where('project_id = :pid')
                ->setParameter('pid', $pid)
                ->andWhere('phpsessid = :sid')
                ->setParameter('sid', $sid)
                ->executeQuery();
        } else { // если нет, то установить.
            $data = ['project_id' => $_POST['project_id'], 'phpsessid' => ':sid'];

            $queryBuilder = $conn->createQueryBuilder()
                ->insert(\TABS_NAME::LIKE_PROJECT->value)
                ->values($data)
                ->setParameters(['sid' => $sid])
                ->executeQuery();

            $sgn = 1; // ?
        }

        $count_like_pid = psql_query_like_project($pid); // $smarty->

        return $count_like_pid;
    }

    function save_img($dir, $tab, $id, $col_name, $is_delete)
    {
        global $conn;

        $uploaddir = $dir; // . - текущая папка где находится submit.php // './../icons/avatars_projects' ; avatars/

        // cоздадим папку если её нет
        if (! is_dir($uploaddir)) {
            mkdir($uploaddir, 0777, true);
        } else {
            if ($col_name == "icon") {
                move_uploaded_file('/assets/frontend/icons/default_avatar_project.jpg', "$uploaddir/default_avatar_project.jpg"); // for project;
                move_uploaded_file('/assets/frontend/icons/default_avatar.jpg',         "$uploaddir/default_avatar.jpg"); // for profile;
            }
        }

        $files      = $_FILES; // полученные файлы
        $done_files = array();

        $files_names = array();
        // переместим файлы из временной директории в указанную
        if ($is_delete) { // для удаления иконок, аватарок проекта и профиля 
            $old_icon = $conn->createQueryBuilder()
                ->select('icon')
                ->from($tab)
                ->where('id = ' . $id)
                ->executeQuery()
                ->fetchOne();

            $path_old_icon = "$uploaddir/$old_icon";

            if (file_exists($path_old_icon)) {
                unlink($path_old_icon);
            }
        }

        foreach ($files as  $file) {
            $files_names = $file['name'];
            
            foreach($files_names as $index => $file_name){
                $temp_file_name = $file['tmp_name'][$index];

                if (move_uploaded_file($temp_file_name, "$uploaddir/$file_name")) {
                    $done_files[] = realpath("$uploaddir/$file_name");

                    if($col_name == 'icon') $_POST['icon'] = $file_name;
                }
            }

        }

        $json_data = json_encode($files_names);

        $count = $conn->createQueryBuilder()
            ->update($tab)
            ->set($col_name, "'$json_data'")
            ->where('id = ' . $id)
            ->executeQuery()
        ->fetchAllAssociative(); //  $_SESSION['project_id']

        if ($count > 0 && isset($_POST['icon'])) {
            $icon_path = $_POST['icon'];

            if ($tab == \TBN::PROFILES->value) {
                $_SESSION[$col_name] = $icon_path; // 'icon' // обновление иконки пользователя!
            }

            echo json_encode(array(
                'load_avatar'  => ($count > 0 ? "success" : "failed"),
                'error_code'   => ($count > 0 ? 0 : 1),
                'icon'         => $dir . "/" . $icon_path
            ));
        } else {

            $load_name = 'load_'. $col_name;
            echo json_encode(array(
                $load_name  => ($count > 0 ? "success" : "failed"),
                'error_code'   => ($count > 0 ? 0 : 1),
                'dir'         => $dir . "/",
                'data'        => $json_data
            ));
        }
    }

    function delete_page()
    {
        $delete_page = (isset($_POST['page']) ? $_POST['page'] : null);

        if ($delete_page) {
            switch ($delete_page) {
                case 'project':
                    $tab = \TBN::PROJECTS->value;
                    $id  = $_SESSION['project_id'];
                    break;
                case 'vacancy':
                    $tab = \TBN::VACANCIES->value;
                    $id  = $_SESSION['vacancy_id'];
                    break;
            }

            global $conn;

            $res = $conn->createQueryBuilder()
                ->delete($tab)
                ->where('id = ' . $id)
                ->executeQuery();
        }

        return false;
    }
};
