<?php
	//namespace Vega\Portfolio;

	//$name_space = 'Vega\Portfolio\\';

	$name_space = '';

	enum TOTAL : string {
		case SJS  = "/assets/backend/js/library/sortablejs/Sortable.min.js"; // https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.6/Sortable.min.js
		case JQR  = "/assets/backend/js/library/jquery/jquery-3.7.1.min.js";
		case FCN  = "/assets/frontend/icons/vega.ico";
        case CDB  = "/assets/backend/config/config_db.php";
        case WDBC = "/assets/backend/config/WrapperDataBaseConn.php";
	}

	enum INDEX : string {
		case JSX = "/assets/backend/js/index.js";
		case CSS = "/assets/frontend/styles/css/index.css";
		case PATH = "/index.php"; // public/
	}

	enum AUTH : string {
		case JSX  = "/assets/backend/js/authorization.js";
		case CSS  = "/assets/frontend/styles/css/authorization.css";
		case PATH = "/assets/frontend/pages/authorization.php";
	}

    enum REG : string {
        case JSX  = "/assets/backend/js/registration.js";
		case CSS  = "/assets/frontend/styles/css/registration.css";
		case PATH = "/assets/frontend/pages/registration.php";
    }

    enum PAGE : string {
        case PFL 	 	= "/assets/frontend/pages/profile.php";
        case ACT 	 	= "/assets/frontend/pages/action.php";
		case PROJECT 	= "/assets/frontend/pages/project.php";
		case VACANCY 	= "/assets/frontend/pages/vacancy.php";
		case INTERESTS 	= "/assets/frontend/pages/interests.php";
    }

	enum MAIN : string {
		case VACANCY = '/assets/frontend/mains/main_for_vacancy.php';
		case INTERESTS = "/assets/frontend/mains/main_for_interests.php";
	}

	enum NAV : string {
		case PRJ = "/assets/frontend/pages/projects.php";
		case TMS = "/assets/frontend/pages/teams.php";
		case VAC = "/assets/frontend/pages/vacancies.php";
	}

	enum STYLE : string {
		case MAIN 		= "/assets/frontend/styles/css/main.css";
		case INDEX 		= "/assets/frontend/styles/css/css/index.css";
		case PROFILE 	= "/assets/frontend/styles/css/css/profile.css";
		case TEAMS 		= "/assets/frontend/styles/css/css/teams.css";
		case VACANCIES 	= "/assets/frontend/styles/css/css/vacancies.css";
		case PROJECTS	= "/assets/frontend/styles/css/css/projects.css";
		case PROJECT	= "/assets/frontend/styles/css/css/project.css";
		case VACANCY    = "/assets/frontend/styles/css/css/vacancy.css";
	}

	enum ICON_DEFAULT : string {
		case VACANCY 	= "/assets/frontend/icons/default_avatar_vacancy.jpg";
		case PROFILE 	= "/assets/frontend/icons/default_avatar_profile.jpg";
		case PROJECT 	= "/assets/frontend/icons/default_avatar_project.jpg";
	}

	enum PATH_DEFAULT : string {
		case PROFILE = "/assets/frontend/icons/avatars_profiles/";
		case PROJECT = "/assets/frontend/icons/avatars_projects/";
	}

	enum AOS : string {
		case CSS = "/assets/backend/library/aos/aos.css";
		case JSX = "/assets/backend/library/aos/aos.js";
	}

	enum SELECT2 : string {
		case CSS = "/assets/backend/library/select2/select2.min.css";
		case JSX = "/assets/backend/library/select2/select2.min.js";
	}

	enum JSLIB : string {
		case REACT_DEV 	= "/../vendor/npm-asset/react/cjs/react.development.js";
		case REACT_PRO 	= "/../vendor/npm-asset/react/cjs/react.production.js";
		case APP 		= "/assets/backend/js/app.js";
	}

	/* */

	enum TABS_NAME : string {// case TAB_REGISTRATION_USER = "info_user";
		case PROFILES  		= "info_user";
		case PROJECTS  		= "projects";
		case VACANCIES 		= "vacancies"; // vacancies
		case LIKE_PROJECT 	= "like_project";
		case AWESOME 		= "awesome";// recognition
		case REFERENCES     = "refs";
	} // case TAB_PROJECTS = "projects"; /*info_project */
	
	class_alias($name_space . 'TABS_NAME', $name_space . 'TBN');
	
	enum TAB_REGISTRATION_USER { /* TAB_REGISTRATION_USER */
		case id;
		case firstname;
		case lastname;
		case patronymic;
		case login;
		case roles;
		case icon;
		case hash; /* 8 */ /* pswd_hash */
		case telephone;
		case email;
		case status; /* end */
	}
	
	class_alias($name_space . 'TAB_REGISTRATION_USER', $name_space . 'TRU'); 
	
	enum SELECT_QUERY : int {
		case SELECT  = 0;
		case FROM    = 1;
		case WHERE   = 2;
		case ILIKE = 3;
		case LIMIT   = 4;
		case OFFSET  = 5;
		case HAVING  = 6;
		case GROUPBY = 7;
		case ORDERBY = 8;
		case ORDERBYTYPE = 9;

	}
	
	class_alias($name_space . 'SELECT_QUERY', $name_space . 'SQ');
	
	enum ORDERBYTYPE {
		case ASC;
		case DESC;
	}
	
	class_alias($name_space . 'ORDERBYTYPE', $name_space . 'OBT');
	
	enum INSERT_INTO_QUERY : int {
		case INSERT_INTO  = 0;
		case COLUMNS      = 1;
		case VALUES       = 2;
		case RETURNING	  = 3;
	}
	
	class_alias($name_space . 'INSERT_INTO_QUERY', $name_space . 'IIQ');
	
	enum OPBIN : string {
		case AND    = "AND";
		case OR     = "OR";
	}
	
	enum ERRORCODE: int {
		case   BLOCK_PROFILE = 1;
		case UNBLOCK_PROFILE = 0;
		case        PASSWORD = 2;
	}
	
	class_alias($name_space . 'OPBIN', $name_space . 'OB');

	enum UPDATE_QUERY : int {
		case UPDATE  = 0;
		case SET     = 1;
		case WHERE   = 2;
	}

	class SIZE_LOAD_PAGE {
		public static $PROJECTS = 10;
		public static $TEAMS = 3;
		public static $VACANCIES = 10;
	}

	/*enum SIZE_LOAD_PAGE : int {
		case PROJECT = 3;
		case TEAMS = 3;
		case VACANCIES = 3;
	}*/

	class_alias($name_space . 'UPDATE_QUERY', $name_space . 'UQ');
?>