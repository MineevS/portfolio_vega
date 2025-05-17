<?php

/*
    Перед включением данного файла в проект необходимо инизиализировать систему, включив файл `paths.php`.
*/
function print_current_date($params, $smarty){
    if (empty($params["format"])) {
        $format = "%b %e, %Y";
    } else {
        $format = $params["format"];
    }
    return time(); // strftime($format,time());
}

function psql_query_like_project(){ // Для определения общего количества лайков на конкретный проект от всех пользователей, которые поставили соответствующий like.
    $count_args = func_num_args();

    $count_like_project_id = 0; // default;
    if($count_args > 0){
        $pid = func_get_arg(0);

        global $conn;

        $query = $conn->createQueryBuilder()
            ->select('count(*)')
            ->from(\TABS_NAME::LIKE_PROJECT->value)
        ->where('project_id = ' . $pid); /* $_POST['project_id'] */

        switch($count_args){
            case 2:
                $sid = func_get_arg(1);

                $query->andWhere("phpsessid = '". $sid . "'");
                break;
            default:
                // TODO // Непредвиденное поведение при большем кол.ве агрументов !
                break;
        }

        $count_like_project_id = $query->executeQuery()->fetchOne();
    }

    return ($count_like_project_id != false ? $count_like_project_id : 0);
}

function psql_query_projects($params, $smarty){
    global $conn;

    $query = make_query($params, $smarty);

    $for = '';
    if (isset($params['for']))
        $for = $params['for'];

    $include_right = true;
    switch ($for) {
        case 'profile':
            $include_right = false;
            break;
    }

    $array_data = $query->executeQuery()->fetchAllAssociative();

    $html = '';
    foreach ($array_data as $data) {
        $tags  = (isset($data['tags']) ? json_decode($data['tags']) : array());

        $html_tags = '';
        foreach ($tags as $tag) 
            $html_tags .= '<p>#' . $tag . '</p>';

        $tab = \TABS_NAME::LIKE_PROJECT->value;

        $pid = $data['id'];
        $sid = session_id();

        // Получение наличие лайка на конкретный проект от текущего пользователя
        $count_like_pid_sid = psql_query_like_project($pid, $sid); 

        // Получение общего кол.ва лайков на проект.
        $count_like_pid     = psql_query_like_project($pid); 

        $feedbacks          = (isset($data["feedback"]) ? json_decode($data["feedback"]) : array());
        $cnt_feedbacks      = count((array) $feedbacks);

        $participants       = ( isset($data["participants"]) ? json_decode($data["participants"]) : array() );
        $cnt_participants   = count((array) $participants);
        $tags2              = ( isset($tags) ? join(",", $tags) : null);
        $icon               = ( isset($data['icon']) ? $data['icon'] : $smarty->getTemplateVars('template_name_default_img_project'));

        $html .= '<cstm-form-project 
            data-id="'.$data['id'].'" 
            data-icon="'.$icon.'" 
            data-status="'.$data['status'].'" 
            data-count-like='.$count_like_pid.'
            data-is-like='.($count_like_pid_sid ? 'true' : 'false').'
            data-is-right='.($include_right ? 'true' : 'false').'
            data-name="'.$data["name"].'"
            data-description="'.$data["description"].'"
            data-tags="'.$tags2.'"
            data-url="'.$smarty->getTemplateVars('ACTION').'"
            data-cnt-feedback='.$cnt_feedbacks.'
            data-cnt-participants='.$cnt_participants.'
        ></cstm-form-project>';
    }
    
    return $html;
}

function psql_query_interests($params, $smarty)
{
    $interests = array(
        'Frontend'      => array('PHP', 'JS', 'CSS'),
        'Backend'       => array('C/C++', 'C#', 'Java', 'Python'),
        'DevOps'        => array('Gitlab', 'Docker'),
        'Web-дизайн'    => array('Figma'),
        'Data Science'  => array('Spark'),
        'AI технологии' => array('OpenAI', 'Azure'),
        'Базы данных'   => array('PostgreSQL', 'MongoDB'),
        'Боты'          => array('Telegram Bot')
    );

    $html = "";
    while ($element = current($interests)) {
        $key = key($interests);
        $array_value = $interests[$key];

        $value_html = "";
        foreach ($array_value as $value) {
            $value_html = $value_html . '<p>' . $value . '</p>';
        }

        $html .=
            '<form class="interestsSubmitButton" method="POST" action="' . $smarty->getTemplateVars('PAGE_INTERESTS') . '" class=" interestsForm">
                <div class="buttonTitle">
                    <span style="display: inline-flex; width: 25px;">//</span>' . $key . '</h1>
                </div>
                <button type="submit" style="all: unset; cursor: pointer; padding-right: 5vw;" >
                    <div class="buttonTags">' . $value_html . '
                        <svg  xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
                        </svg>
                    </div>
                </button>
            </form>';

        next($interests);
    }

    $html .=
        '<form class="interestsSubmitButton" method="POST" action="' . $smarty->getTemplateVars('PAGE_INTERESTS') . '" style="background: #EA5657; border-radius: 0 0 25px 25px; width: 100%;" class=" interestsForm">
        <div class="buttonTitle">
            <span style="display: inline-flex; width: 25px;">//</span> И многие другие </h1>
        </div>
        <button type="submit" style="all: unset; cursor: pointer; padding-right: 5vw;" >
            <div class="buttonTags">Посмотреть все
                <svg  xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
                </svg>
            </div>
        </button>
    </form>'; // onclick="window.location.href={$INTERESTS}"

    return $html;
}

function psql_query_stars($params, $smarty)
{

    global $conn;

    /*require_once($_SERVER['DOCUMENT_ROOT'].TOTAL::CDB->value);             //-> [$dbname, $host, $port, $user, $passwd]; -> './config/config_db.php'
    require_once($_SERVER['DOCUMENT_ROOT'].TOTAL::WDBC->value);             // -> WrapperDataBase(); -> './config/WrapperDataBaseConn.php' 

    $wdbc = new WDBC($dbname, $host, $port, $user, $passwd);
    */
    $array_data = $conn->createQueryBuilder()
        ->select($params['select'])
        ->from($params['from'])
        ->orderby($params['orderby'])
        ->executeQuery()
    ->fetchAllAssociative();

        // ->exec(); // ->limit  (isset($params['limit']) ? $params['limit'] : '')

    //$status = true;

    // $array_data = $query->executeQuery()->fetchAllAssociative(); //$wdbc->query()->responce(); // $wdbc->query()->responce() // value="<?= $cur_idx

    $html = '';
    $deb = array();
    foreach ($array_data as $data) {
        //$status_block = ( $data["id"] == 2 ? 'block' : 'none'); 
        // $status_block = ($data["id"] == 2 ? 'visible' : 'hidden'); // // visibility // display: '.$status_block.';

        $icon = "someone.svg";

        $icon = $conn->createQueryBuilder()
            ->select('icon')
            ->from('info_user')
            ->where('id = :uid')
            ->setParameter('uid', $data["user_id"])
            ->executeQuery()->fetchOne();; // 

        if(!isset($icon) || !$icon) $icon = "someone.svg";

        $id = $data["id"];

        $html .= '<cstm-star class="carousel-item" id="'.$id.'" icon="'.$icon.'" description="'.$data["description"].'"></cstm-star>';
    }

    return $html;
}

enum Color: string
{
    case Red = '#FF0000';
    case Green = '#00FF00';
    case Blue = '#0000FF';
    public function hex(): string
    {
        return $this->value;
    }
    public function rgb(): array
    {
        return sscanf($this->value, '#%02x%02x%02x');
    }
    public static function random(): self
    {
        return self::cases()[array_rand(self::cases())];
    }
}

function make_query($params, $smarty){
    global $conn;

    $query = $conn->createQueryBuilder();

    if (isset($params['select']))  $query->select($params['select']);
    if (isset($params['from']))     $query->from($params['from']);

    if (isset($params['where']) && isset($params[$params['where']]))
        $query->where($params['where'] . ' = ' . $params[$params['where']]);
    else if(isset($params['where'])) 
        $query->where($params['where']);

    if (isset($params['ilike'])) $query->ilike($params['ilike']);

    // if (isset($params['orderby'])) $query->orderby($params['orderby']); 

    if(isset($params['orderbytype'])){
        $query->orderby($params['orderby'], $params['orderbytype']);
    } else if (isset($params['orderby'])) $query->orderby($params['orderby']);

    if (isset($params['offset']))
        $query->setFirstResult($params['offset']); // offset($params['offset']); // $query->offset($params['offset']);

    if (isset($params['limit']))
        $query->setMaxResults($params['limit']); // $query->limit($params['limit']); // limit

    // if (isset($params['limit']))   $query->limit($params['limit']);
    // if (isset($params['offset']))  $query->offset($params['offset']);

    return $query;
}

function psql_query_vacancies($params, $smarty){
    $query = make_query($params, $smarty);

    $isGrid = (isset($params['style']) && $params['style'] == 'grid' ? true : false);

    $html = '';

    $array_data = $query->executeQuery()->fetchAllAssociative(); // $wdbc->query()->responce() // value="<?= $cur_idx

    $count = count($array_data);
    for ($i = 0; $i < $count; $i++) {
        $data = $array_data[$i];

        $style = ($isGrid && $i % 2 == 0 && ($i == $count - 1) // Стиль для выравнивания по центру последнего item-vacancies при нечетном количестве.
            ? 'width:  50%; grid-column: 1 / span 2;'
            : 'width: 100%;');

        $speciality  = ( isset($data['speciality'])  ? $data['speciality']  : '');
        $description = ( isset($data['description']) ? $data['description'] : '');
        $tags        = ( isset($data['tags'])        ? $data['tags']        : '');
        $experience  = ( isset($data['experience'])  ? $data['experience']  : '');

        // coincidence (совпадение);
        $coin_show = false;
        $coincidence = '';
        switch ($data['id']) {
            case 1:
                $coin_show = true;
                $coincidence = 95;
                break;
            case 3:
                $coin_show = true;
                $coincidence = 15;
                break;
        }

        $html .= '<cstm-form-vacancy style="'.$style.'"
            data-id="'.$data['id'].'"
            action="/assets/frontend/pages/vacancy.php"
            speciality="'.$speciality.'" 
            coincidence="'.$coincidence.'"
            is-coincidence="'.($coin_show ? 'true': 'false').'" 
            description="'.$description.'"
            tags="'.htmlspecialchars($tags, ENT_QUOTES, 'UTF-8').'" 
            duties="'.htmlspecialchars($data['duties'], ENT_QUOTES, 'UTF-8').'"
            experience="'.htmlspecialchars($experience, ENT_QUOTES, 'UTF-8').'"
            is-grid="'.($isGrid ? 'true': 'false').'"
        ></cstm-form-vacancy>';
    }

    return $html;
}

function wrapperHtmlGroups(){
    $groups_names = func_get_args();
    $content_html_groups = '<select class="showHide selProperty" name="education" id="education" hidden="true">';
    foreach ($groups_names as $group_name) {
        $name = $group_name["name"];
        if ($name) $content_html_groups .= '<option value="' . $name . '" >' . $name . '</option>';
    }

    $content_html_groups .= '</select>';
    return $content_html_groups;
}

function query_groups(){
    global $conn;

    $data = $conn->createQueryBuilder()
        ->select('name')
        ->from('groups')
        ->where('name IS NOT NULL')
        ->executeQuery()
        ->fetchAllAssociative();

    return $data;
}

function wrapperHtmlOption(){
    $values = func_get_args();
    $content_html_vaues = '';

    foreach ($values as $value)
        if ($value) $content_html_vaues .= '<option value="' . $value . '" >' . $value . '</option>';

    return $content_html_vaues;
}

function wrapperHtmlSelect(){
    $values = func_get_args();
    $content_html_vaues = '<select class="selProperty" name="education" id="education" hidden="true">';

    foreach ($values as $value)
        if ($value) $content_html_vaues .= '<option value="' . $value . '" >' . $value . '</option>';

    $content_html_vaues .= '</select>';
    return $content_html_vaues;
}

function query_property_option(){
    $property = func_get_arg(0);

    $array_values = array();
    switch ($property) {
        case 'education':
            $array_values = array("Бакалавриат", "Магистратура", "Специалитет", "Аспирантура");
            break;
        case 'course':
            $array_values = array("1", "2", "3", "4");
            break;
        case 'institute':
            $array_values = array("ИИ - Искусственного интеллекта", "ИТ - Информационных технологий", "КБ - комплексной безопасности", "РИ - радиотехнических и телекоммуникационных систем", "...");
            break;
        case 'division':
            $array_values = array("БК 536 РТУ МИРЭА", "...");
            break;
        case 'specialization':
            $array_values = array("Прикладная математика и информатика", "...");
            break;
        case 'year':
            $count = 0;

            $array_yers = array();
            while ($count < 10) { // Последние 10 лет показываем
                array_push($array_yers, date("Y", strtotime("-$count year")));
                $count++;
            }

            $array_values = $array_yers;
            break;
        case 'status';
            $array_values = array("Запуск", "В разработке", "Завершен", "В Архиве", "Идёт набор");
            break;
    }

    $html = wrapperHtmlSelect(...$array_values);

    return $html;
}


function psql_query_properties_profile($params, $smarty){
    if (empty($params["for"])) return '';

    global $conn;

    $query = $conn->createQueryBuilder()
        ->select('*')
        ->from('info_user')
        ->where('id = :id')
        ->setParameter('id', $_SESSION['id'])
        ->executeQuery();

    $array_data = $query->fetchAllAssociative();//$wdbc->query()->responce(); // $wdbc->query()->responce() // value="<?= $cur_idx

    $html = '';
    foreach ($array_data as $data) {
        switch ($params["for"]) {
            case 'base_properties':
                $groups = query_groups();
                $dt = array_column($groups, 'name');
                $gr = json_encode($dt);
                
                $html .= '
                    <cstm-property-profile text=\'Образовательная программа\' name=\'education\'        value=\''.$data['education'].'\'                                                ></cstm-property-profile>
                    <cstm-property-profile text=\'Группа\'                    name=\'group\'            value=\''.$data['group'].'\'                data=\''.$gr.'\'                    ></cstm-property-profile>
                    <cstm-property-profile text=\'Курс\'                      name=\'course\'           value=\''.$data['course'].'\'                                                   ></cstm-property-profile>
                    <cstm-property-profile text=\'Шифр\'                      name=\'cipher\'           value=\''.$data['cipher'].'\'               data=\'["'.$data['cipher'].'"]\'    ></cstm-property-profile>
                    <cstm-property-profile text=\'Институт\'                  name=\'institute\'        value=\''.$data['institute'].'\'                                                ></cstm-property-profile>
                    <cstm-property-profile text=\'Кафедра\'                   name=\'division\'         value=\''.$data['division'].'\'                                                 ></cstm-property-profile>
                    <cstm-property-profile text=\'Специальность\'             name=\'specialization\'   value=\''.$data['specialization'].'\'                                           ></cstm-property-profile>
                    <cstm-property-profile text=\'Год приёма\'                name=\'year\'             value=\''.$data['year'].'\'                                                     ></cstm-property-profile>
                ';
                break;
            case 'about':
                $html .= '<cstm-textarea-wrapper name="'.$params["for"].'" is_save="true">'.$data['about'].'</cstm-textarea-wrapper>';
                break;
            case 'head':
                $html .= $data['firstname'] . ' ' . $data['lastname'];
                break;
            case 'skills':
                if (isset($data['skills'])) {
                    $skills = json_decode($data['skills'], true);
                    $html .= wrapperHtmlLabel(...$skills);
                }
                break;
            case 'goals':
                $html .= '<ul>';
                if (isset($data['goals']))  $goals = json_decode($data['goals'], true);
                $html .= wrapperHtmlLi(...$goals);
                $html .= '</ul>';
                break;
            case 'references': // contacts
                if (isset($data['refs'])) {
                    $refs = json_decode($data['refs'], true);

                    foreach ($refs as $reference) {
                        $url = $reference;
    
                        $html .= '<cstm-reference url="'.$url.'"></cstm-reference>';
                    }
                }
                break;
            case 'contacts':
                if (isset($data['contacts'])) {
                    $contacts = json_decode($data['contacts']);
                    $emails = $contacts->emails;
                    $phones = $contacts->phones;
                    $sites  = $contacts->sites;

                    if (isset($emails)) $html .= wrapperHtmlSpan(...$emails);
                    if (isset($phones)) $html .= wrapperHtmlSpan(...$phones);
                    if (isset($sites))  $html .= wrapperHtmlSpan(...$sites);
                }
                break;
            case 'socials':
                if (isset($data['socials'])) {
                    $socials = json_decode($data['socials'], true);
                    foreach ($socials as $social) {
                        $html .= '<cstm-social-network url="'.$social.'"></cstm-social-network>';
                    }
                }

                /*$html .= '
                    <cstm-social-network url="https://vk.com/msa_7"></cstm-social-network>
                    <cstm-social-network url="https://t.me/token0609"></cstm-social-network>';*/
                break;
        }
    }

    return $html;
}

function psql_query_properties_user($params, $smarty){
    if (empty($params["for"])) return ''; // fro="project"

    global $conn;

    if (isset($params['data_users'])) $data_users = $params['data_users'];

    $html = '';
    foreach ($data_users as $key => $value) {
        $query = $conn->createQueryBuilder()
            ->select('*')
            ->from('info_user')
            ->where('id = :id')
            ->setParameter('id', $key)
        ->executeQuery();

        $array_data = $query->fetchAllAssociative(); // $wdbc->query()->responce() // value="<?= $cur_idx

        foreach ($array_data as $data) {
            $firstname = '';
            $lastname = '';
            $from = '';
            $to = '';
            $role = '';
            $icon = '';
            $id_prefix = 'pro';

            switch ($params["for"]) {
                case 'project':
                case 'feedback':
                    if (isset($data["firstname"]))   $firstname  = $data["firstname"];
                    if (isset($data["lastname"]))    $lastname   = $data["lastname"];
                    if (isset($data["lastname"]))    $lastname   = $data["lastname"];
                    if (isset($data["icon"]))        $icon       = $data["icon"];

                    break;
            }

            switch ($params["for"]) {
                case 'project':
                    if (isset($value[0]))            $from  = $value[0];
                    if (isset($value[1]))            $to    = $value[1];
                    if (isset($value[2]))            $role  = $value[2];
                    break;
                case 'feedback':
                    $id_prefix = 'fb';

                    if (isset($value[0]))            $count_stars    = $value[0];
                    if (isset($value[1]))            $msg            = $value[1];

                    break;
                /*case 'references':
                    if (isset($value[0]))            $count_stars    = $value[0];
                    if (isset($value[1]))            $msg            = $value[1];

                    break;*/
            }

            $cardname = $params["for"];
            // '.$_SERVER['HTTP_REFERER'].

            $id = $id_prefix . '-' . $key;

            $edit = false;
            if($firstname == $_SESSION["firstname"] && 
                $lastname == $_SESSION["lastname"] && 
                $icon == $_SESSION["icon"]){
                    $edit = true;
                }

            switch ($params["for"]) {
                case 'project':
                    $html .= '<cstm-participant 
                        class="card-'.$cardname.'" 
                        data-id="'.$id.'" 
                        data-firstname="'.$firstname.'" 
                        data-lastname="'.$lastname.'" 
                        cur_url="/assets/frontend/icons/avatars_profiles/'.$icon.'"
                        data_from="'.$from.'"
                        data_to="'.$to.'"
                        data_role="'.$role.'"
                        readonly=true
                        edit="'.( $edit ? "true" : "false" ).'" >
                    </cstm-participant>';
                    break;
                case 'feedback':
                    $html .= '<cstm-feedback 
                        class="card-'.$cardname.'" 
                        data-id="'.$id.'" 
                        data-firstname="'.$firstname.'" 
                        data-lastname="'.$lastname.'" 
                        cur_url="/assets/frontend/icons/avatars_profiles/'.$icon.'"
                        data-msg="'.$msg.'"
                        data_stars="'.$count_stars.'"
                        readonly=true
                        edit="'.( $edit ? "true" : "false" ).'" >
                    </cstm-feedback>';
                    break;
            }
        }
    }

    return $html;
}

function psql_query_intelligence($params, $smarty) {}

function query_editor_button($params, $smarty){ 
    $style = '';

    if (isset($params['style']))  $style = $params['style'];

    $action = $smarty->getTemplateVars('ACTION'); // style="' . $style . '" class="editor"

    return '
    <svg class="editor" width="30" height="30" onclick="editPage.call(this, false, true, false, \'' . $action . '\');" > 
        <use xlink:href="#editor"></use>
    </svg>';
}

function psql_query_header_page($params, $smarty)
{ // $params['action'] // \'{$ACTION}\'

    /*$style = '';
    if(isset($params['style']))  $style = $params['style'];*/

    $action = $smarty->getTemplateVars('ACTION');
    $url_templ_img = $smarty->getTemplateVars('template_name_default_img');
    // $url_img_profile = $smarty->getTemplateVars('icon');
    // $page = $params['page'];

    /*
        {query_properties 1_profile for="head"}
		{query_editor_button}
    */

    // $page = $smarty->template_resource;

    $page = explode('.', end(explode('_', end(explode('/', $smarty->template_resource)))))[0];

    $content_html = '';

    $data = '';

    $page_default = '';

    // $action = '';
    switch ($page) {
        case 'profile':
            $params['for'] = 'head';
            $url_img = $smarty->getTemplateVars('icon');
            $name    = psql_query_properties_profile($params, $smarty);
            //$content_html .= query_editor_button($params, $smarty);

            if ($smarty->getTemplateVars('access')) {
                $action = 'action="'.$action.'"';
            }

            /*$svg_border = '
                <rect width="197.234" height="197.234" x="8.067" y="10.59" fill="url(#a)" stroke="#EA5657" stroke-width="3" rx="98.617"/>
                <path stroke="#EA5657" stroke-linecap="round" stroke-width="3" d="M103.532 208.216C144.523 215.784 212 179.207 212 116.144c0-78.829-53.604-110.99-108.468-110.99C48.667 5.153 2 44.251 2 109.837s84.504 104.685 130.541 87.658"/>
                <path stroke="#EA5657" stroke-linecap="round" stroke-width="3" d="M2 109.838C7.045 49.298 33.532 16.505 72.63 2"/>';

            $width = 214;
            $height = 211;*/
            break;
        case 'project':
            // {query_propertiesd 1_project for="icon" icon_default="$icon_default"}
            $params_list = array(
                'for' => "url_icon",
                'icon_default' => $smarty->getTemplateVars('icon_default')
            );

            //$url_img = $smarty->getTemplateVars('icon');

            $url_img = psql_query_properties_project($params_list, $smarty); // Иконка аватара для заголовка

            //{query_properties 1_project for="name" name_default="$name_default"}
            $params_list = array(
                'for' => "name",
                'name_default' => $smarty->getTemplateVars('name_default')
            );
            $name = psql_query_properties_project($params_list, $smarty); 

            // $htm_editor_button = '';
            if ($smarty->getTemplateVars('access')) {
                $action = 'action="'.$action.'"';

                $page_default = $smarty->getTemplateVars('page_default');
            }

            break;
        case 'vacancy':
            $params_list = array(
                'for' => "name",
                'name_default' => $smarty->getTemplateVars('name_default')
            );
            $name = psql_query_properties_project($params_list, $smarty);

            if ($smarty->getTemplateVars('access')) {
                $action = 'action="'.$action.'"';

                $page_default = $smarty->getTemplateVars('page_default');
            }

            $data = $params['data'];

            break;
    }

    $url      = (isset($url_templ_img)? 'url="'.$url_img.'"':'');
    $url_temp = (isset($url_temp)? 'url_temp_img="'.$url_templ_img.'"':'');

    return '<cstm-header '.$url.' '.$url_temp.' name="'.$name.'" data="'.$data.'" '.$action.' page-default="'.$page_default.'" ></cstm-header>';
}

function query_input($params, $smarty)
{
    if (isset($params['for'])) $for = $params['for'];

    $html = '<cstm-input data-for="'.$for.'"></cstm-input>';

    return $html;
}

function query_properties_add($params, $smarty){
    if (isset($params['for'])) $for = $params['for'];

    $onclick = '';
    switch ($for) {
        case 'contacts':
            break;
        case 'projects':
            $onclick = 'window.location.href=\'' . $smarty->getTemplateVars('PAGE_PROJECT') . '\'';
            break;
        case 'references':
            break;
        case 'feedbacks':
            //$onclick = 'addElement.call(this.parentNode.parentNode.previousElementSibling, \''.$_SESSION['firstname'].'\' , \''.$_SESSION['lastname'].'\' , \''.$_SESSION['icon'].'\' )';
            break;
        case 'socials':
            break;
        case 'screenshots':
            break;
        case 3:
            break;
    }

    $html = '
    <cstm-button-add 
        data-click="' . $onclick . '" 
        fname="'.$_SESSION['firstname'].'" 
        lname="'.$_SESSION['lastname'].'" 
        icon="'.$_SESSION['icon'].'" 
        data-for="'. $for.'"
    ></cstm-button-add>'; 

    return $html;
}

function psql_query_properties_project($params, $smarty){
    if (empty($params["for"])) return '';

    global $conn;

    if (isset($_SESSION['project_id'])) { /* 'projects' */
        $query = $conn->createQueryBuilder()
            ->select('*')
            ->from(\TBN::PROJECTS->value)
            ->where('id = :pid')
            ->setParameter('pid', $_SESSION['project_id'])
            ->executeQuery();
    }

    /* Инициализация по умолчанию */
    $premier        = '...';
    $status         = '...';
    $stack          = '...';
    $communities    = '...';
    $experts        = '...';
    $tags           = '...';
    $name           = (isset($params['name_default']) ? $params['name_default'] : '');
    $icon           = (isset($params['icon_default']) ? $params['icon_default'] : '');
    $description    = '...';

    //$page = (isset($params['page']) ? $params['page']: '');

    $html = '';
    $array_data = ( isset($query) ? $query->fetchAllAssociative(): null); // $wdbc->query()->responce() // value="<?= $cur_idx

    foreach ($array_data as $data) {
        switch ($params["for"]) {
            case 'properties':
                if (isset($data['premier']))         $premier        = $data['premier'];
                if (isset($data['status']))          $status         = $data['status'];
                if (isset($data['stack']))           $stack          = $data['stack'];
                if (isset($data['communities']))     $communities    = $data['communities'];
                if (isset($data['experts']))         $experts        = $data['experts'];
                break;
            case 'icon':
            case 'url_icon':
                if (isset($data['icon']))            $icon           = '/assets/frontend/icons/avatars_projects/' . $data['icon']; // avatar ?
                break;
            case 'name':
                if (isset($data['name']))            $name           = $data['name'];
                break;
            case 'description':
                if (isset($data['description']))     $description    = $data['description'];
                break;
            case 'tags':
                if (isset($data['tags']))            $tags           = json_decode($data['tags']);
                break;
            case 'stack':
                if (isset($data['stack']))           $stack          = json_decode($data['stack']);
                break;
            case 'team':
                if (isset($data['team']))            $team           = json_decode($data['team']);
                break;
            case 'artefacts':
                // TODO from DB:
                break;
        }
    }

    $refs = array();
    switch($params["for"]){ // т.к. ссылки находятся в отдельной таблице, то делаем второй запрос
        case 'references':
            $query2 = $conn->createQueryBuilder()
                ->select('*')
                ->from(\TBN::REFERENCES->value)
                ->where('id_project = :pid')
                ->setParameter('pid', $_SESSION['project_id'])
            ->executeQuery();

            $refs = ( isset($query2) ? $query2->fetchAllAssociative(): null); // $wdbc->query()->responce() // value="<?= $cur_idx

            break;
    }


    switch ($params["for"]) {
        case 'properties':
            // $html_select = query_property_option('status');

            $html .= '
                <cstm-property-project type="date"   text="Дата начала"  name="premier" value="'.$premier.'" ></cstm-property-project>
                <cstm-property-project type="select" text="Статус"       name="status"  value="'.$status.'"  ></cstm-property-project>';
            break;
        case 'icon':
            $html .= '<img id="project" class="avatar" src="' . $icon . '" alt="..." style="width: 150px; height: 150px; border-radius: 20px;">';
            break;
        case 'url_icon':
            $html .= $icon;
            break;
        case 'name':
            $html .= $name;
            break;
        case 'name_html':
                $html .= '<input class="contentProperty" id="' . $params["for"] . '"  value="' . $name . '"
                style="height: fit-content; border: none;color: #EA5657; font-family: \'Vasek\'; font-size: 5vw; outline:none; caret-color: transparent;"
                />';
            break;
        case 'description':
            $html .= '<cstm-textarea-wrapper name="' . $params["for"] . '">'.$description.'</cstm-textarea-wrapper>';
            // $html .= '<textarea class="about contentProperty" oninput="resizeTextarea.call(this);" id="' . $params["for"] . '" style="width: 100%;" readonly>' . $description . '</textarea>';
            break;
        case 'tags':
            if (isset($data[$params["for"]])) {
                $tags = json_decode($data[$params["for"]]);
                $html .= wrapperHtmlA(...$tags);
            }
            break;
        case 'stack':
            if (isset($data[$params["for"]])) {
                $stack = json_decode($data[$params["for"]]);
                $html .= wrapperHtmlLabel(...$stack);
            }
            break;
        case 'team':
            if (isset($data[$params["for"]])) {
                $team = json_decode($data[$params["for"]]);

                $params_list = array(
                    'for' => 'project',
                    'data_users' => $team
                );

                $html .= psql_query_properties_user($params_list, $smarty);

                // $html .= wrapperHtmlLabel(...$team);
            }
            break;
        case 'screenshots':
            if (isset($data[$params["for"]])) {
                $screenshots = json_decode($data[$params["for"]]);

                foreach ($screenshots as $screenshot) {
                    $html .= '<cstm-screenshot src="/assets/frontend/img/'.$screenshot.'"></cstm-screenshot>';
                }
            }

            break;
        case 'feedback':
            if (isset($data[$params["for"]])) {
                $feedbacks = json_decode($data[$params["for"]]);

                $params_list = array(
                    'for' => 'feedback',
                    'data_users' => $feedbacks
                );

                $html .= psql_query_properties_user($params_list, $smarty);
            }
            break;
        case 'references':
            if (isset($refs)) { // $data[$params["for"]]
                foreach ($refs as $reference) {
                    $url = $reference["url"];

                    $html .= '<cstm-reference url="'.$url.'"></cstm-reference>';
                }
            }
            break;
        case 'artefacts':
            $html .= '<cstm-artefact url="'.$url.'"></cstm-artefact>';
            break;
    }

    return $html;
}

function psql_query_article($params, $smarty){
    $html = '';
    if (isset($params['head1']) || isset($params['head2']) || isset($params['head3']))
        $html .= '<article id="' . (isset($params['id']) ? $params['id'] : '') . '" style="' . (isset($params['style']) ? $params['style'] : '') . '" >'; //$html .= '<article'; // class="acticle"

    if (isset($params['head1']))
        $html .= '<h1 class="' . (isset($params['class']) ? $params['class'] : 'HelveticaMain') . '" style="justify-self: start;">' . $params['head1'] . '</h1>';

    if (isset($params['head2']))
        $html .= '<p class="' . (isset($params['class2']) ? $params['class2'] : 'VasekMain') . '" style="justify-self: center;">' . $params['head2'] . '</p>';

    if (isset($params['svg']))
        switch ($params['svg']) {
            case 1:
                $html .= '
                        <svg style="justify-self: center;" xmlns="http://www.w3.org/2000/svg" width="447" height="134" fill="none" viewBox="0 0 447 134">
                            <path fill="#EA5657" d="M16.125 63.25c.667-.833 1.417-1 2.25-.5.875.458 1.083 1.167.625 2.125A114.718 114.718 0 0 0 7.937 87.188c-.375.958-1.062 1.354-2.062 1.187-.917-.375-1.292-1.063-1.125-2.063A119.823 119.823 0 0 1 16.125 63.25Zm21.563.188c.583-.834 1.333-1.042 2.25-.626.791.626 1 1.396.624 2.313a174.07 174.07 0 0 0-9.624 23.688c-.459 1-1.146 1.374-2.063 1.124-.917-.291-1.292-.958-1.125-2a178.418 178.418 0 0 1 9.938-24.5ZM37.812 75c1.084.125 1.626.688 1.626 1.688 0 .374-.167.75-.5 1.124-.292.376-.667.542-1.126.5A91.586 91.586 0 0 0 6.75 79.626c-1.083.125-1.75-.27-2-1.188-.25-.958.125-1.624 1.125-2 10.542-2.291 21.188-2.77 31.938-1.437Zm28.438 3.438c-.708.833-1.542 1.02-2.5.562-.917-.5-1.146-1.25-.688-2.25a37.516 37.516 0 0 0 2-3c.667-1.083.834-2.23.5-3.438-.791-2.083-2.458-3.333-5-3.75-2.458-.291-4.833.146-7.124 1.313-2.292 1.167-4.126 2.604-5.5 4.313-1.292 1.541-2.25 3.312-2.876 5.312-.583 1.958-.312 3.813.813 5.563 1.333 1.541 3.125 2.229 5.375 2.062 2.25-.208 4.188-.98 5.813-2.313a30.945 30.945 0 0 0 4.437-4.624 29.524 29.524 0 0 1 4.563-4.563c1-.625 1.874-.604 2.624.063.792.666.792 1.416 0 2.25-.333.541-.541 1.291-.624 2.25a29.464 29.464 0 0 0-.563 3.25c-.25 2.083.583 3.75 2.5 5 .708.75.708 1.52 0 2.312-.875.625-1.77.625-2.688 0-2.541-1.917-3.729-4.354-3.562-7.313.167-1.458.417-2.916.75-4.374.083-1.334.604-2.48 1.563-3.438.874.75 1.75 1.52 2.624 2.313a46.331 46.331 0 0 0-5.937 6.187c-1.792 2.25-4.104 4-6.938 5.25-2.874 1.167-5.791 1.313-8.75.438-2.958-1.042-4.833-2.917-5.624-5.626-.626-2.624-.376-5.187.75-7.687a18.638 18.638 0 0 1 4.937-6.438c2.292-2 5.042-3.437 8.25-4.312 3.25-.917 6.375-.688 9.375.688 2.75 1.5 4.333 3.645 4.75 6.437a7.108 7.108 0 0 1-.938 4 47.184 47.184 0 0 1-2.312 3.563Zm15.375-15.313c.583-.833 1.27-1 2.063-.5.833.458 1.062 1.167.687 2.125-4 7.25-7.23 14.833-9.688 22.75-.458.917-1.124 1.27-2 1.063-.874-.25-1.229-.896-1.062-1.938a126.88 126.88 0 0 1 10-23.5Zm18.937.188c.542-.792 1.25-.98 2.126-.563.791.583.979 1.313.562 2.188a193.562 193.562 0 0 0-8.375 23.437c-.417.958-1.063 1.313-1.938 1.063-.874-.25-1.25-.876-1.124-1.876a191.206 191.206 0 0 1 8.749-24.25Zm3.938-.75c1.042.124 1.562.645 1.562 1.562 0 .417-.166.792-.5 1.125-.291.333-.645.5-1.062.5a75.412 75.412 0 0 0-27.125 2.563c-1 .124-1.625-.25-1.875-1.126-.25-.916.104-1.562 1.063-1.937C85.686 62.667 95 61.77 104.5 62.562Zm9.875 5.937c.75-.583 1.479-.583 2.187 0 .584.708.584 1.438 0 2.188a27.026 27.026 0 0 0-1.75 2.5c-1.041 1.541-1.791 3.291-2.25 5.25-.416 1.958.063 3.708 1.438 5.25 1.375 1.333 2.917 1.916 4.625 1.75 1.708-.167 3.313-.75 4.813-1.75 3.291-2.126 5.624-5.021 7-8.688 1.041-3.292.312-6.063-2.188-8.313-1.167-.833-2.5-1.208-4-1.124-1.667.166-3.208.77-4.625 1.812A15.495 15.495 0 0 0 116.062 71a27.808 27.808 0 0 0-2.562 4.438 125.33 125.33 0 0 0-4.625 10.874 231.18 231.18 0 0 0-5.063 14.25 279.97 279.97 0 0 0-7.562 29c-.333.876-.958 1.25-1.875 1.126-.875-.376-1.23-1.021-1.063-1.938.25-1.333.521-2.667.813-4a260.197 260.197 0 0 1 9-31.75 247.652 247.652 0 0 1 5.563-14.313 40.868 40.868 0 0 1 5.874-10.75A16.84 16.84 0 0 1 119.188 64c1.833-1.083 3.791-1.604 5.874-1.563 4.25.5 7.084 2.792 8.5 6.876.626 2.083.626 4.145 0 6.187-.624 2-1.604 3.854-2.937 5.563a21.941 21.941 0 0 1-4.813 4.812 14.336 14.336 0 0 1-6.25 2.625c-2.25.25-4.333-.23-6.25-1.438-1.916-1.208-3.166-2.958-3.75-5.25-.416-2.458-.104-4.812.938-7.062a28.086 28.086 0 0 1 3.875-6.25Zm45.125 9.938c-.708.833-1.542 1.02-2.5.562-.917-.5-1.146-1.25-.688-2.25a37.063 37.063 0 0 0 2-3c.667-1.083.834-2.23.5-3.438-.791-2.083-2.458-3.333-5-3.75-2.458-.291-4.833.146-7.124 1.313-2.292 1.167-4.126 2.604-5.5 4.313-1.292 1.541-2.25 3.312-2.876 5.312-.583 1.958-.312 3.813.813 5.563 1.333 1.541 3.125 2.229 5.375 2.062 2.25-.208 4.188-.98 5.812-2.313a30.95 30.95 0 0 0 4.438-4.624 29.521 29.521 0 0 1 4.562-4.563c1-.625 1.876-.604 2.626.063.791.666.791 1.416 0 2.25-.334.541-.542 1.291-.626 2.25a29.462 29.462 0 0 0-.562 3.25c-.25 2.083.583 3.75 2.5 5 .708.75.708 1.52 0 2.312-.875.625-1.771.625-2.688 0-2.541-1.917-3.729-4.354-3.562-7.313.167-1.458.417-2.916.75-4.374.083-1.334.604-2.48 1.562-3.438.876.75 1.75 1.52 2.626 2.313A46.335 46.335 0 0 0 156 82.124c-1.792 2.25-4.104 4-6.938 5.25-2.874 1.167-5.791 1.313-8.75.438-2.958-1.042-4.833-2.917-5.624-5.626-.626-2.624-.376-5.187.75-7.687a18.628 18.628 0 0 1 4.937-6.438c2.292-2 5.042-3.437 8.25-4.312 3.25-.917 6.375-.688 9.375.688 2.75 1.5 4.333 3.645 4.75 6.437a7.105 7.105 0 0 1-.938 4 47.177 47.177 0 0 1-2.312 3.563Zm18.125-12.5c1.083-.167 1.833.25 2.25 1.25.167 1.083-.25 1.833-1.25 2.25-4.25.958-6.833 3.541-7.75 7.75-.25 1.916.146 3.604 1.187 5.062 1.084 1.417 2.584 2.292 4.5 2.625 2.042.292 3.876-.104 5.5-1.188 1.667-1.083 2.938-2.5 3.813-4.25a10.78 10.78 0 0 0 1.187-5.687c-.25-1.708-1.187-2.896-2.812-3.563a10.097 10.097 0 0 0-2.5-.687 20.95 20.95 0 0 1-3.188-.25 5.819 5.819 0 0 1-2.687-1.438 53.9 53.9 0 0 1-2.187-2.187c-.459-.542-.626-1.125-.5-1.75.166-.667.604-1.104 1.312-1.313a74.322 74.322 0 0 0 10.688-3.062 46.97 46.97 0 0 0 9.5-4.438c4.791-3.083 7.895-7.374 9.312-12.874.375-1.334.542-2.688.5-4.063 0-1.292-.229-2.438-.688-3.438a1.227 1.227 0 0 0-.437-.374c-.25-.084-.5-.146-.75-.188a7.834 7.834 0 0 0-2.75.375c-4.917 1.458-9.125 4.083-12.625 7.875-2 2.042-3.729 4.396-5.188 7.063-1.458 2.666-2.062 5.5-1.812 8.5 0 .5-.188.937-.562 1.312-.376.333-.792.5-1.25.5-1.042 0-1.646-.604-1.813-1.813-.25-4.041.708-7.791 2.875-11.25a38.164 38.164 0 0 1 7-8.687 32.17 32.17 0 0 1 8.312-5.438 21.703 21.703 0 0 1 6.75-2c2.834-.25 4.792.938 5.876 3.563.958 3.167.937 6.354-.063 9.563-1.917 6.5-5.771 11.479-11.563 14.937A59.084 59.084 0 0 1 186 63.063a78.107 78.107 0 0 1-10.562 3c.25-1 .52-2 .812-3 .792 1 1.688 1.854 2.688 2.562a4.449 4.449 0 0 0 1.812.25c.667 0 1.333.063 2 .188 2.708.374 4.896 1.604 6.562 3.687a7.14 7.14 0 0 1 1.313 3.75 12.943 12.943 0 0 1-.25 4 15.104 15.104 0 0 1-3.313 6.688c-1.791 2.041-3.979 3.374-6.562 4-2.583.624-5.104.374-7.562-.75-2.376-1.209-4.021-2.98-4.938-5.313-.917-2.333-1-4.75-.25-7.25 1.667-4.792 4.958-7.77 9.875-8.938Zm18.687 23.624c-.958.459-1.75.25-2.374-.624-.459-.959-.25-1.75.624-2.376 9.876-7.666 19.167-16 27.876-25 .666-.583 1.354-.666 2.062-.25.75.417 1.021 1.063.812 1.938A193.403 193.403 0 0 0 219.688 88c-.376 1-1.084 1.396-2.126 1.188-.958-.376-1.354-1.084-1.187-2.126a186.346 186.346 0 0 1 5.563-24.75c1 .584 1.979 1.167 2.937 1.75a262.82 262.82 0 0 1-28.563 25.5Zm30.126-6.874c-.459.041-.855-.126-1.188-.5-.333-.376-.5-.771-.5-1.188 0-.958.562-1.5 1.688-1.625A91.328 91.328 0 0 0 235.75 78a35.444 35.444 0 0 0 8.938-3.063 18.983 18.983 0 0 0 6.437-4.874c.792-.876 1.167-1.855 1.125-2.938-.125-.5-.458-.833-1-1a4.9 4.9 0 0 0-1.438-.375c-2.916-.292-5.604.25-8.062 1.625-2.458 1.375-4.333 3.354-5.625 5.938-1.167 2.458-1.542 5.02-1.125 7.687.208 1.25.812 2.23 1.812 2.938a7.018 7.018 0 0 0 3 1.062A13.095 13.095 0 0 0 247 83.437a27.878 27.878 0 0 0 6.188-4.062c.791-.667 1.583-.667 2.374 0 .626.792.626 1.583 0 2.375-2.541 2.292-5.541 4.146-9 5.563-3.416 1.416-6.812 1.479-10.187.187-2.25-1.083-3.708-2.688-4.375-4.813-.625-2.124-.688-4.374-.188-6.75.5-2.374 1.334-4.458 2.5-6.25 2.042-3 4.771-5.124 8.188-6.374 1.583-.584 3.292-.917 5.125-1 1.875-.126 3.604.145 5.187.812 1.709.833 2.646 2.208 2.813 4.125-.042 1.792-.646 3.396-1.813 4.813A22.778 22.778 0 0 1 246 78a40.329 40.329 0 0 1-9.562 3.188 103.48 103.48 0 0 1-10 1.5ZM271 63.25c.667-.833 1.417-1 2.25-.5.875.458 1.083 1.167.625 2.125a114.777 114.777 0 0 0-11.063 22.313c-.374.958-1.062 1.354-2.062 1.187-.917-.375-1.292-1.063-1.125-2.063A119.803 119.803 0 0 1 271 63.25Zm21.562.188c.584-.834 1.334-1.042 2.25-.626.792.626 1 1.396.626 2.313a174.21 174.21 0 0 0-9.626 23.688c-.458 1-1.145 1.374-2.062 1.124-.917-.291-1.292-.958-1.125-2a178.466 178.466 0 0 1 9.937-24.5ZM292.688 75c1.083.125 1.624.688 1.624 1.688 0 .374-.166.75-.5 1.124-.291.376-.666.542-1.124.5a91.589 91.589 0 0 0-31.063 1.313c-1.083.125-1.75-.27-2-1.188-.25-.958.125-1.624 1.125-2 10.542-2.291 21.188-2.77 31.938-1.437Zm12.187-11.938c.667-.833 1.417-1 2.25-.5.833.459 1.042 1.188.625 2.188a120.333 120.333 0 0 0-10.188 22.375c-.5.958-1.208 1.313-2.124 1.063-.917-.25-1.271-.896-1.063-1.938a124.794 124.794 0 0 1 10.5-23.188Zm-7.687 24.75c-1 .376-1.75.146-2.25-.687-.459-.833-.271-1.563.562-2.188A268.873 268.873 0 0 0 327.188 64c.708-.375 1.374-.292 2 .25.5.583.583 1.25.25 2-3.5 7.5-6.459 15.188-8.876 23.063-.416 1-1.104 1.374-2.062 1.124-.917-.25-1.292-.916-1.125-2a194.768 194.768 0 0 1 9.187-23.874l2.25 2.25a266.794 266.794 0 0 1-31.624 21Zm29.25 3c-1.042.167-1.688-.187-1.938-1.062-.208-.917.146-1.604 1.062-2.063a22.401 22.401 0 0 0 5.376-2.437 103.522 103.522 0 0 0 5-3.25l11.124-7.5c.917-.458 1.605-.27 2.063.563.5.791.354 1.52-.437 2.187L337.312 85a40.235 40.235 0 0 1-10.874 5.813Zm20.5-28.25c.916.417 1.25 1.084 1 2-.209.917-.834 1.292-1.876 1.126-1.958-.5-3.833-.105-5.624 1.187-1.626 1.083-2.855 2.625-3.688 4.625-.833 1.958-.5 3.708 1 5.25.708.583 1.542.854 2.5.813a8.247 8.247 0 0 0 2.688-.688c2-.875 3.374-2.313 4.124-4.313.459-.958 1.126-1.312 2-1.062.917.25 1.292.896 1.126 1.938-1.25 3.374-3.584 5.645-7 6.812a8.97 8.97 0 0 1-4.313.438c-1.417-.209-2.667-.876-3.75-2-1.958-2.417-2.458-5.126-1.5-8.126.958-2.666 2.687-4.854 5.187-6.562 2.542-1.708 5.25-2.188 8.126-1.438Zm3.25 1.75c.458-.958 1.145-1.312 2.062-1.062.917.25 1.271.896 1.062 1.938-1.416 4-2.75 8.083-4 12.25A56.332 56.332 0 0 0 347.125 90c-.167 1.042-.729 1.563-1.687 1.563-.917 0-1.417-.521-1.5-1.563.208-4.417.937-8.75 2.187-13 1.25-4.292 2.604-8.52 4.063-12.688Z"/>
                            <path fill="#EA5657" d="M348.916 89.535a1.5 1.5 0 1 0-2.755 1.187l2.755-1.187Zm25.468 6.644-.344-1.46.344 1.46Zm23.032-33.522-.005 1.5.005-1.5Zm15.573 22.759-.617-1.367.617 1.367Zm28.911-32.31a1.5 1.5 0 0 0-1.846-1.044l-13.009 3.609a1.5 1.5 0 1 0 .802 2.89l11.563-3.207 3.208 11.563a1.5 1.5 0 1 0 2.891-.802L441.9 53.107Zm-95.739 37.616c1.179 2.736 3.739 5.598 8.35 7.187 4.576 1.578 11.091 1.878 20.216-.27l-.687-2.92c-8.79 2.069-14.688 1.686-18.551.354-3.828-1.32-5.734-3.592-6.573-5.538l-2.755 1.187Zm28.566 6.917c11.612-2.734 22.4-11.35 27.903-19.321 2.712-3.93 4.383-8.051 3.799-11.395-.307-1.76-1.237-3.262-2.842-4.287-1.557-.995-3.636-1.47-6.165-1.48l-.011 3c2.202.008 3.653.428 4.561 1.008.86.549 1.332 1.3 1.502 2.275.371 2.124-.701 5.39-3.313 9.174-5.147 7.456-15.34 15.568-26.121 18.106l.687 2.92Zm22.695-36.482c-13.932-.049-21.024 11.063-18.669 20.1 1.188 4.56 4.757 8.383 10.671 9.786 5.845 1.386 13.876.398 24.183-4.26l-1.235-2.734c-9.98 4.51-17.3 5.25-22.255 4.075-4.887-1.16-7.566-4.19-8.461-7.623-1.811-6.95 3.598-16.386 15.755-16.344l.011-3Zm16.185 25.626c11.706-5.29 19.645-17.495 28.153-32.537l-2.611-1.477c-8.582 15.172-16.097 26.453-26.777 31.28l1.235 2.734Z"/>
                        </svg>';
                break;
            case 2:
                $html .= '
                        <div style="display: flex; justify-self: center; align-items: center;">
                            <p class="VasekMain">Аллеи Славы</p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="94" height="83" fill="none" viewBox="0 0 94 83">
                                <path stroke="#EA5657" stroke-linecap="round" stroke-width="3" d="M11.789 67.475C25.731 44.632 53.615-.423 53.615 2.102c0 2.338 1.526 46.36 2.459 72.907.067 1.921-2.352 2.808-3.558 1.31l-35.427-44c-.968-1.204-.266-3.004 1.261-3.233l71.687-10.76c2.119-.319 3.187 2.466 1.399 3.646L2 81"/>
                            </svg>
                        </div>';
                break;
        }

    if (isset($params['head3']))
        $html .= '<h1 class="' . (isset($params['class']) ? $params['class'] : 'HelveticaMain') . '" style="justify-self: end;">' . $params['head3'] . '</h1>';

    if (isset($params['head1']) || isset($params['head2']) || isset($params['head3']))
        $html .= '</article>';

    return $html;
}

function psql_query_authors($params, $smarty){
    $html = '';

    // TODO:

    return $html;
}

function psql_query_teams($params, $smarty){
    global $conn;

    /*require_once($_SERVER['DOCUMENT_ROOT'].TOTAL::CDB->value);             //-> [$dbname, $host, $port, $user, $passwd]; -> './config/config_db.php'
    require_once($_SERVER['DOCUMENT_ROOT'].TOTAL::WDBC->value);             // -> WrapperDataBase(); -> './config/WrapperDataBaseConn.php' 

    $wdbc = new WDBC($dbname, $host, $port, $user, $passwd);
    */
    /*$status = $wdbc ->query()
            ->select ($params['select'])
            ->from   ($params['from'])
            ->orderby($params['orderby'])
            ->limit  ($params['limit'])
        ->exec();*/

        /*
            $responce = $conn->createQueryBuilder() // Проверка на `like` по проекту  и текущему `phpsessid`
            ->select('id')
            ->from(\TABS_NAME::LIKE_PROJECT->value)
            ->where('project_id = :id')
            ->setParameter('id', $data['id'])
            ->andWhere('phpsessid = :sid')
            ->setParameter('sid', session_id())
            ->groupby('id')
            ->executeQuery()->fetchAllAssociative();
        */

    $status = false;

    $html = '';
    if ($status) {
        $array_data = $conn->executeQuery()->fetchAllAssociative();; // $wdbc->query()->responce(); // $wdbc->query()->responce() // value="<?= $cur_idx


        /*foreach($array_data as $data){
                $html = $html.
                    '<div class="item" style="">
                    
                    </div>';
            }*/

        for ($i = 0; $i < 1; $i++) {
            $html = $html .
                '<div class="item-of-teams" style="display: block; "> <!-- none / block -->

                    </div>';
        }

        return $html;
    }

    return $html;
}

function psql_query_feedback($params, $smarty)
{
    global $wdbc;

    /*require_once($_SERVER['DOCUMENT_ROOT'].TOTAL::CDB->value);             //-> [$dbname, $host, $port, $user, $passwd]; -> './config/config_db.php'
    require_once($_SERVER['DOCUMENT_ROOT'].TOTAL::WDBC->value);             // -> WrapperDataBase(); -> './config/WrapperDataBaseConn.php' 

    $wdbc = new WDBC($dbname, $host, $port, $user, $passwd);
    */
    /*$status = $wdbc ->query()
            ->select ($params['select'])
            ->from   ($params['from'])
            ->orderby($params['orderby'])
            ->limit  ($params['limit'])
        ->exec();*/

    $status = true;

    $html = '';
    if ($status) {
        $array_data = $wdbc->query()->responce(); // $wdbc->query()->responce() // value="<?= $cur_idx


        /*foreach($array_data as $data){
                $html = $html.
                    '<div class="item" style="">
                    
                    </div>';
            }*/

        for ($i = 0; $i < 1; $i++) {
            $html = $html .
                '<div class="item-of-feedback" style="display: block; "> <!-- none / block -->

                    </div>';
        }

        return $html;
    }

    return $html;
}

function psql_query_screenshots($params, $smarty)
{
    global $wdbc;

    /*require_once($_SERVER['DOCUMENT_ROOT'].TOTAL::CDB->value);             //-> [$dbname, $host, $port, $user, $passwd]; -> './config/config_db.php'
    require_once($_SERVER['DOCUMENT_ROOT'].TOTAL::WDBC->value);             // -> WrapperDataBase(); -> './config/WrapperDataBaseConn.php' 

    $wdbc = new WDBC($dbname, $host, $port, $user, $passwd);
    */
    /*$status = $wdbc ->query()
            ->select ($params['select'])
            ->from   ($params['from'])
            ->orderby($params['orderby'])
            ->limit  ($params['limit'])
        ->exec();*/

    $status = true;

    $html = '';
    if ($status) {
        $array_data = $wdbc->query()->responce(); // $wdbc->query()->responce() // value="<?= $cur_idx


        /*foreach($array_data as $data){
                $html = $html.
                    '<div class="item" style="">
                    
                    </div>';
            }*/

        for ($i = 0; $i < 1; $i++) {
            $html = $html .
                '<div class="item-of-screenshots" style="display: block; "> <!-- none / block -->

                </div>';
        }

        return $html;
    }

    return $html;
}

function psql_query_vacancy($params, $smarty)
{
    global $wdbc;

    /*require_once($_SERVER['DOCUMENT_ROOT'].TOTAL::CDB->value);             //-> [$dbname, $host, $port, $user, $passwd]; -> './config/config_db.php'
    require_once($_SERVER['DOCUMENT_ROOT'].TOTAL::WDBC->value);             // -> WrapperDataBase(); -> './config/WrapperDataBaseConn.php' 

    $wdbc = new WDBC($dbname, $host, $port, $user, $passwd);
    */
    /*$status = $wdbc ->query()
            ->select ($params['select'])
            ->from   ($params['from'])
            ->orderby($params['orderby'])
            ->limit  ($params['limit'])
        ->exec();*/

    $status = true;

    $html = '';
    if ($status) {
        $array_data = $wdbc->query()->responce(); // $wdbc->query()->responce() // value="<?= $cur_idx


        /*foreach($array_data as $data){
                $html = $html.
                    '<div class="item" style="">
                    
                    </div>';
            }*/

        for ($i = 0; $i < 1; $i++) {
            $html = $html .
                '<div class="item-of-screenshots" style="display: block; "> <!-- none / block -->

                </div>';
        }

        return $html;
    }

    return $html;
}

function psql_query_properties_vacancy($params, $smarty){
    if (empty($params["for"])) return '';

    global $conn;

    if (isset($_SESSION['vacancy_id'])) { /* 'projects' */
        $query = $conn->createQueryBuilder()
            ->select('*')
            ->from(\TBN::VACANCIES->value)
            ->where('id =' . $_SESSION['vacancy_id'])
            ->executeQuery();
    }

    /* Инициализация по умолчанию */
    $name        = '...';
    $about       = '...';
    $create      = '...'; // data;
    $duties      = array();
    $tags        = array();
    $condidats   = '...';
    $speciality  = '...';
    $project_id  = '...'; // !!! $_SESSION['project_id']
    $status      = '...';

    $del = 'false';
    if (empty($params["del"])) $del = $params["del"];

    /*$premier        = '...';
    $status         = '...';
    $stack          = '...';
    $communities    = '...';
    $experts        = '...';
    $tags           = '...';
    $name           = (isset($params['name_default']) ? $params['name_default']: '');
    $icon           = (isset($params['icon_default']) ? $params['icon_default']: '');
    $about          = '...';*/

    $html = '';

    $array_data = ( isset($query) ? $query->fetchAllAssociative() : array()) ; // $wdbc->query()->responce() // value="<?= $cur_idx

    foreach ($array_data as $data) {
        switch ($params["for"]) {
            case 'properties':
                $name         = ( isset($data['name'])       ? $data['name']        : '');
                $about        = ( isset($data['about'])      ? $data['about']       : '');
                $create       = ( isset($data['create'])     ? $data['create']      : '');
                $status       = ( isset($data['status'])     ? $data['status']      : '');
                $duties       = ( isset($data['duties'])     ? $data['duties']      : '');
                $tags         = ( isset($data['tags'])       ? $data['tags']        : '');
                $condidats    = ( isset($data['condidats'])  ? $data['condidats']   : '');
                $speciality   = ( isset($data['speciality']) ? $data['speciality']  : '');
                $speciality   = ( isset($data['project_id']) ? $data['project_id']  : '');

                /*if (isset($data['name']))            $name               = $data['name'];
                if (isset($data['about']))           $about              = $data['about'];
                if (isset($data['create']))          $create             = $data['create'];
                if (isset($data['status']))          $status             = $data['status'];
                if (isset($data['duties']))          $duties             = $data['duties'];
                if (isset($data['tags']))            $tags               = $data['tags'];
                if (isset($data['condidats']))       $condidats          = $data['condidats'];
                if (isset($data['speciality']))      $speciality         = $data['speciality'];
                if (isset($data['project_id']))      $project_id         = $data['project_id'];*/
                break;
            case 'icon':
                if (isset($data['icon']))            $icon           = '/assets/frontend/icons/avatars_vacancies/' . $data['icon']; // avatar ?
                break;
            case 'name':
                if (isset($data['name']))            $name           = $data['name'];
                break;
            case 'about':
                if (isset($data['about']))            $about         = $data['about'];
                if (isset($data['description']))      $description   = $data['description'];
                $about = $description;
                break;
            case 'speciality':
                if (isset($data['speciality']))      $speciality     = $data['speciality'];
                break;
            case 'tags':
                $tags   = ( isset($data['tags']) ? json_decode($data['tags'])  : array());

                // if (isset($data['tags']))            $tags           = json_decode($data['tags']); // Преобразовать id -> name;
                break;
            case 'duties':
                if (isset($data['duties']))          $duties         = json_decode($data['duties']);
                break;
        }
    }

    switch ($params["for"]) {
        case 'properties':
            $html .= '
            <string>Дата создания:                    <input id="date-preview"          value="' . $create . '"        type="date"         readonly /></string>                                       
            <span>
                <label for="select_status">Статус:  <input id="input_status"            value="' . $status . '"         name="selectStatus" readonly /></label> <!-- hidden type="hidden" -->
                <select name="Status" id="select_status" hidden> 
                    <option value="Показать">Показать</option>
                    <option value="Скрыть"  >Скрыть</option>
                    <option value="Закрыть" >Закрыть</option>
                </select>
            </span>
            <string>Специальность:              <input id="speciality"      value="' . $speciality . '"    type="text"         readonly /></string>  
            <string>Теги:                           <input id="tags"                   value="' . $tags . '"          type="text"         readonly /></string>';
            break;
        case 'icon':
            $html .= '<img class="avatar-project" src="' . $icon . '" alt="..." style="width: 150px; height: 150px; border-radius: 20px;">';
            break;
        case 'name':
            $html .= '<input class="contentProperty" name="name" style="font-family: \'Vasek\', arial; font-size: 4vw; text-align: center; color: #EA5657; margin: 0; line-height: .8em; white-space:nowrap;" value="' . $name . '" readonly/>';
            break;
        case 'about':
            $html .= '<textarea class="contentProperty" name="description" style="width: 100%;" readonly>' . $about . '</textarea>';
            break;
        case 'duties':
            $html .= '<ul class="contentProperty" name="duties" style="width: 100%">';
                $html .= wrapperHtmlLi(...$duties);
            $html .= '</ul>';
            break;
        case 'speciality':
            $html .= '<input class="contentProperty" name="speciality" value="' . $speciality . '"  type="text"   style="text-align: center;"    readonly />';
            break;
        case 'search':
            $html .= "
                <li onclick=\"resultSearchTags('Adele')\"><a href=\"#\">Adele</a></li>
				<li onclick=\"resultSearchTags('Agnes')\"><a href=\"#\">Agnes</a></li>
				<li onclick=\"resultSearchTags('Billy')\"><a href=\"#\">Billy</a></li>
				<li onclick=\"resultSearchTags('Bob')\"><a href=\"#\">Bob</a></li>
				<li onclick=\"resultSearchTags('Calvin')\"><a href=\"#\">Calvin</a></li>
				<li onclick=\"resultSearchTags('Christina')\"><a href=\"#\">Christina</a></li>
				<li onclick=\"resultSearchTags('Cindy')\"><a href=\"#\">Cindy</a></li>";
            break;
        case 'tags':
            if (count($tags) === 0) { // strlen($tags) === 0
                // $html .= '<input id="tags"      value="отсутствуют"    type="text"   style="text-align: center;"    readonly />';
            
                // Вывод информации об отсутствии тегов
            } else {
                $html .= wrapperHtmlLabel(...$tags);
            }
            break;
    }

    return $html;
}

function sortByLength($a, $b)
{
    return strlen($a) - strlen($b);
}

function wrapperHtmlLabel()
{
    $list = func_get_args();
    usort($list, 'sortByLength');

    $content_html = '';
    foreach ($list as $elem)
        $content_html .= '<cstm-stack value="'.$elem.'"></cstm-stack>'; 
    
    return $content_html;
}

function wrapperHtmlA(){
    $list = func_get_args();
    usort($list, 'sortByLength');

    $content_html = '';
    foreach ($list as $elem)
        $content_html .= '<cstm-tag value="'.$elem .'"></cstm-tag>';

    return $content_html;
}

function wrapperHtmlLi(){
    $list = func_get_args();
    usort($list, 'sortByLength');

    $content_html = '';
    foreach ($list as $elem)
        $content_html .= '<cstm-duty value="'.$elem.'"></cstm-duty>';

    return $content_html;
}

function wrapperHtmlSpan(){
    $list = func_get_args(); // usort($list,'sortByLength');
    $content_html = '';
    foreach ($list as $elem) {
        $type = 'email';
        if (filter_var($elem, FILTER_VALIDATE_EMAIL)) {
        } else if (filter_var($elem, FILTER_VALIDATE_URL)) {
            $type = 'site';
        } else { 
            $type = 'phone';
        }

        $content_html .= '<cstm-contact type="'.$type.'" value="'.$elem.'"></cstm-contact>';
    }

    return $content_html;
}
