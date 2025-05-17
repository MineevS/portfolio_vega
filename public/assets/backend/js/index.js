// debugger;

const name_id_iframe = "iframe-auth-reg";
window.delete = false;
window.delete_avatar_project = true;

window.page_load_projects = 0;
window.page_load_vacancies = 0;
window.page_load_teams = 0;
window.reference_default = "http://example.com/";
window.max_length_tag = 12;
window.base_url = "/assets/frontend/pages/action.php";
window.page_vacancy = "/assets/frontend/pages/vacancy.php";
window.page_profile = "/assets/frontend/pages/profile.php";
window.page_default = "/assets/frontend/pages/index.php";
// window.default_avatar = "/assets/frontend/pages/action.php";

// import {CustomArtefact} from './components.js';

import './components.js';

function checking_for_length(name, value, min, max){
	var status_length = false;

	var text = '';
	var chech_min = (value.length == min);
	
	if (value.length > max || chech_min) { 
		status_length = true;
		text = (chech_min ? `меньше ${min + 1}` : `превышает верхний порог длины ${name}, который равен ${max} символов`);
	}
	
	if (status_length) {
		window.notice.setAttribute('value', `Длина ${name} "${value}" ${text} !`);
	}

	return !status_length;
}

function checking_for_duplicates(childrens, value, name){
	var status_clone = false;                                         // Проверка на повторяющие теги;
	childrens.some(function(child, index) {
		if (!status_clone && child.attributes.value.nodeValue == value) { 
			status_clone = true; 
			return; 
		}
		else { console.log(child.attributes.value.nodeValue); }
	});

	var map_data = { /* Окончания для множественных */
		'Тег '        : 'ов',
		'Навык '      : 'ов',
		'Цель'        : 'ей',
		'Обязанность' : 'ей',
	} /* name=[Тег -> тегов, навык -> навыков, Обязанность -> обязанностей] */

	var name_res = name.slice(0, -1).toLowerCase() + map_data[name];
	
	if (status_clone) {
		window.notice.setAttribute('value', name + " \`" + value + "\` уже есть в списке выбранных "+name_res+"!"); 
	}

	return !status_clone;
}

function addElement(data_for, data, fname, lname, icon){
	var map_data = {
		"contacts"  : {'isDragDrop': false,  'height': '42px'}, 
		"projects"  : {'isDragDrop': false,  'height': '99%' },
		"references": {'isDragDrop': false,  'height': '99%' },
		"feedbacks" : {'isDragDrop':  true,  'height': '99%' , 'is_append': true },
		"goals"     : {'isDragDrop':  true,  'height': '99%' , 'is_append': true },
		"duties"    : {'isDragDrop':  true,  'height': '99%' , 'is_append': true }
	};

	var is_append = false;

	var currentPage = window.location.href.split('/').pop().split('.')[0];
	
	var count_children = this.children.length;
    var elem;
	
	switch(data_for){
	case 'socials':
		elem           = document.createElement('cstm-social-network');
		elem.type      = 'text'; // default;
		elem.value     = '...';
		// elem.is_readOnly = "false";
		elem.setAttribute('readOnly', false);
		elem.setAttribute('url', window.reference_default);
		// elem.className = "contact"; // contentProperty
		elem.id        = this.children.length + 1;
		break;
	case 'contacts':
		// if (count_children > 6) return; // !!!
		
		elem           = document.createElement('cstm-contact');
		elem.type      = 'text'; // default;
		elem.value     = '...';
		// elem.is_readOnly = "false";
		elem.setAttribute('readOnly', "false");
		// elem.className = "contact"; // contentProperty
		elem.id        = this.children.length + 1;
		
		break;
	case 'feedbacks':
		elem           = document.createElement('cstm-feedback');
		elem.className = "card-feedback";
		elem.id        = this.children.length + 1;

		elem.setAttribute('data-id', `fb-${elem.id}`);
		elem.setAttribute('data-firstname', `${fname}`);
		elem.setAttribute('data-lastname', `${lname}`);
		elem.setAttribute('cur_url', `/assets/frontend/icons/avatars_profiles/${icon}`);
		elem.setAttribute('data-msg', "...");
		elem.setAttribute('data_stars', "0");
		elem.setAttribute('readonly', "false");
		elem.setAttribute('data_stars', "0");
		elem.setAttribute('edit', "true");
		is_append = true;

			// дореализовать

		break;
	case 'references':
		elem = document.createElement('cstm-reference');

		elem.setAttribute('data-class', 'hide');
			
		elem.setAttribute('url', window.reference_default);
		

		// addRefs.call(this.parentNode.parentNode);
		break;
	case 'tags':
		var childrens = Array.from(this.children);

		if (!checking_for_length('тега', data, 0, window.max_length_tag)) return;
		if(!checking_for_duplicates(childrens, data, 'Тег ')) return;

		elem = document.createElement('cstm-tag');
		elem.setAttribute('value', data);
		
		if(currentPage == 'vacancy'){
			elem.setAttribute('style', true);
			elem.setAttribute('button', 'show');
		} else {
			elem.setAttribute('svg', 'show');
		}

		is_append = true;

		break;
	case 'skills':
	case 'stack':
		var childrens = Array.from(this.children);

		if (!checking_for_length((data_for === 'skills' ? 'навыка' : 'элемента стека'), data, 0, window.max_length_tag)) return;
		if(!checking_for_duplicates(childrens, data, 'Навык ')) return;
		
		elem = document.createElement('cstm-stack');
		elem.setAttribute('value', data);
		elem.setAttribute('button', 'show');
		break;
	case 'duties':
	case 'goals':
		var childrens = Array.from(this.children);

		if(!checking_for_duplicates(childrens, data, (data_for === 'duties' ? 'Обязанность' : 'Цель'))) return;
			
		elem = document.createElement('cstm-duty');
		elem.setAttribute('button', 'show');
		elem.setAttribute('value', data);

		is_append = true;
		break;
	}
	
	// TODO;

	if(elem) {
		if(is_append){
			this.appendChild(elem);
			this.scrollTop = this.scrollHeight; /* Прокрутка в конец */
		} else {
			this.insertBefore(elem, this.children[count_children - 1]);
		}
	}
}

window.addElement = addElement;

function create_iframe_authorization_registration() {
    var layout = document.getElementsByClassName('layout')[0];

    var pre_iframe = document.getElementById(name_id_iframe);
    if (!pre_iframe) {
        var iframe_auth = document.createElement("iframe");

        iframe_auth.id = name_id_iframe;
        iframe_auth.name = iframe_auth.id;
		iframe_auth.src = event.target.href;
        // iframe_auth.attr("scrolling", "no");

		// layout.insertAdjacentElement('afterbegin', iframe_auth);

        layout.prepend(iframe_auth);
    }
	
	event.preventDefault();
	
	// window.event.returnValue=false;
}

window.create_iframe_authorization_registration = create_iframe_authorization_registration;

function close_iframe() {
    window.parent.change_size_iframe(window.name, 0, 50);
    var iframe = document.getElementById(name_id_iframe);
    iframe.remove();
}

function change_size_iframe(name_iframe, width, height) {
    // Получение корневого элемента
    const root = document.querySelector(":root");

    // Изменение значения стиля для корневого элемента
    root.style.setProperty("--iframeHeight", `${height}vh`);
}

function logout(path) {
    $.ajax({
        type: "POST",
        url: path,
        data: {
            action: "logout"
        },
        success: function (result) {
            let json_data = JSON.parse(result);

            if (json_data.hasOwnProperty('url')) { // && json_data.hasOwnProperty('error_code')
                window.top.location.href = json_data['url'];
            }
        }
    });
}

window.logout = logout;

function createElementFromHTML(htmlString) {
    var div = document.createElement('div');
    div.innerHTML = htmlString.trim();
    // Change this to div.childNodes to support multiple top-level nodes.
    return div.children; //childNodes
}

function loadProjets(path) {
    // можно зphp определить кол.во макс страниц и заблокировать запрос при достижении последней страницы.

    window.page_load_projects++; // Инкремент на следующую страницу; // Размер (объём) одной страницы определен в ...

    query_projects(path);
}

function query_projects(path) {
    $.ajax({
        type: "POST",
        url: path,
        data: {
            page_load_projects: window.page_load_projects,
            action: "load_projects"
        },
        success: function (result) {
            print_projects(result);
        }
    });
}

function removeAllChildren(parent) {
    while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
    }
}

function print_projects(result) {
    console.log(result);
    console.log(result['data']);
    let json_data = JSON.parse(result);

    if (json_data.hasOwnProperty('data')) {
        var container_projects = document.getElementById('projects');
        /*removeAllChildren(container_projects);*/
        var divs = createElementFromHTML(json_data['data']);
        if (divs.length > 0)
            [...divs].forEach((div_elem) => {

                //console.log(div_elem.getElementsByClassName('projectTitle')[0].textContent);
                container_projects.insertBefore(div_elem, container_projects.childNodes[container_projects.childNodes.length - 2]);
            });
        else {                     // Закончились элементы;
            // load_project_button; // Можно сделать не onckick;


            var svg = document.getElementById('load_project_svg');
            svg.style.transform = "rotate(180deg)";
            var p = document.getElementById('load_project_p');

            $('#load_project_button').attr('onclick', "topFunction()");
            p.style.display = "block";
        }
    }
}

function deleteElem(is_save, is_local_edit, path){
    var formData = new FormData();
    
    var contentProperties = (is_local_edit ? this : document).getElementsByClassName('contentProperty');
    
    var func_page = function (result) { };

    if (!is_save) {
		// TODO
    }

    var currentPage = window.location.href.split('/').pop().split('.')[0];
}

function updateTypeInput(){
	const value = this.value.trim();
	
	// Проверка на email (содержит @ и домен)
	if (/^\S+@\S+\.\S+$/.test(value)) {
		this.type = 'email';
	} 
	// Проверка на URL (начинается с http://, https:// или содержит домен)
	else if (/^(https?:\/\/|www\.)\S+$/.test(value)) {
		this.type = 'url';
	} 
	// Проверка на телефон (содержит цифры и телефонные символы)
	else if (/^[+]?[0-9\s\-()]+$/.test(value)) {
		this.type = 'tel';
	} 
	// По умолчанию обычное текстовое поле
	else {
		this.type = 'text';
	}
}

export function editPage(is_local_edit, is_readonly, is_save, is_delete, path) {
    // this.innerHTML =  (is_save ? "сохранить" : "редактировать");          // this -> "Это кнопка вызвавшая данное событие";
    
    if(!is_local_edit) { this.onclick = function () { editPage.call(this, is_local_edit, !is_readonly, !is_save, is_delete, path); }; }

	// hide // show;
    var contentProperties = (is_local_edit ? this.parentNode : document).getElementsByClassName('contentProperty');

    var formData = new FormData();
    var func_page = function (result) { };

    var currentPage = window.location.href.split('/').pop().split('.')[0];
    [...contentProperties].forEach((property) => {
        switch (property.id) {
            case 'duties':
                /*[...property.getElementsByClassName('cardDuty')].forEach((cardDuty) => {
                    cardDuty.parentNode.style.listStyleType = (is_save ? 'none' : 'disc');
                    cardDuty.style.columnGap = (is_save ? '10px' : '0');
                    [...cardDuty.getElementsByClassName('buttonDuty')][0].style.display = (is_save ? 'block' : 'none');// ???
                });*/
                break;
            default:
				property.readOnly = is_readonly;
                break;
        }
    });

	const elements_show_hide = Array.from((is_local_edit ? this : document).getElementsByClassName((is_save ? 'show': 'hide'))); // Array::from() - Фиксация на момент вызова.
	const elements_hide_show = Array.from((is_local_edit ? this : document).getElementsByClassName((is_save ? 'hide': 'show')));
	
	elements_show_hide.forEach((elem) => {
		elem.classList.toggle('show', !is_save);
		elem.classList.toggle('hide', is_save);

		if(elem.classList.contains('basket') && elem.classList.contains('hide')){
			elem.onclick();
		} // 
	});

	elements_hide_show.forEach((elem) => {
		elem.classList.toggle('show', is_save);
		elem.classList.toggle('hide', !is_save);
	});


	var selects = (!is_local_edit ? document : this.parentNode).getElementsByTagName('select');
	[...selects].forEach((select) => {
		if(select.classList.contains('contentProperty')){ 
		    select.classList.toggle('static-mode', is_save); // !is_save; // ? mode : // (!is_local_edit ? is_save : !is_save)
		}
	});

    if(is_local_edit){
        // var button_edit = this.parentNode.getElementsByClassName('edit')[0];
        if(this.classList.contains('edit')){
            this.textContent = (!is_save ? "завершить редактирование" : "Редактировать");
            this.onclick = function () { editPage.call(this, is_local_edit, !is_readonly, !is_save, is_delete, path); }; 
        } else if(this.classList.contains('delete')) {
            this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);
        }
    }

	switch(currentPage){
		case 'project':
		case 'profile':
			if(is_save){ 
				const refs = Array.from((is_local_edit ? this : document).getElementsByTagName('cstm-reference'));
				refs.forEach((elem) => {
					// elem.url = elem.firstElementChild.value;
					if(elem.attributes.url.nodeValue !==  elem.firstElementChild.value){
						elem.setAttribute('url', elem.firstElementChild.value);	
					}
					
					// elem.href = elem.parentNode.previousElementSibling.value;
				});

				const socials = Array.from((is_local_edit ? this : document).getElementsByTagName('cstm-social-network'));
				socials.forEach((elem) => {
					// elem.url = elem.firstElementChild.value;
					if(elem.attributes.url.nodeValue !==  elem.firstElementChild.firstElementChild.value){
						elem.setAttribute('url', elem.firstElementChild.firstElementChild.value);	
					}
					
					// elem.href = elem.parentNode.previousElementSibling.value;
				});
			}
			break;
	}
    
    switch (currentPage) {
        case 'profile':
            if (!is_save) { // Сохранить
                func_page = function (json_data) {
                    if (json_data.hasOwnProperty('error_code') && !json_data['error_code']) { // Очистка после успешной загрузки;
                        var avatar = document.getElementById('avatar');
                        avatar.value = null;
                        avatar.textContent = null;
                    }
                };
            }
            break;
        case 'project':
            //this.innerHTML += " проект";
            if (!is_save) { // Сохранить
                func_page = function (json_data) {
                    console.log(json_data);
                    // TODO
                };
            }
            break;
        case 'vacancy':
            //this.innerHTML += " вакансию";
            if (!is_save) { // Сохранить
                func_page = function (json_data) {
                    console.log(json_data);
                    // TODO
                };
            }
            break;
    }
    
    if (is_save) { // редактирование и нередактирование
        var type_changed = ( is_delete ?  "delete" : "save");
        
        formData.append('action',  type_changed + "_data_" + currentPage);
        // Set() позволяет учесть одинаковые элементы в кретических случаях.
        var emails = [];
        var phones = [];
        var sites = [];
		var socials = new Set();
		var stack = [];
		var skills = [];
		var tags = [];
		var screenshots = [];
        var contacts = {};
		var references = [];
		var feedbacks = new Set();
        var feedback = {"0": [0, ""]};
        var participant = {"1": [2, 3, "4"]}; // 1 - id участника, 2- год начала участия, 3 - год завершения участия, 4 - роль в проекте.
        var context = this;
		var goals = [];
		var duties = [];
		[...contentProperties].forEach((property) => {
            if(!is_local_edit){ 
				switch (property.name) {
					case 'project':
						// formData.append("name", property.value);
						break;
					case 'status':
						// formData.append(property.name, property.value);
						break;
					case 'premier':
						// formData.append(property.name, property.value);
						break;
				}
            }

            switch (property.name) {
				case 'vacancy':
					break; // Игнорируем!
				case 'project':
					formData.append("name", property.value);
					break;
				case 'profile':
					var flp = property.value.split(' ');
					
					var fname      = (flp.length > 0 ? flp[0] : null);
					var lname      = (flp.length > 1 ? flp[1] : null);
					var patronomic = (flp.length > 2 ? flp[2] : null);

					if(fname)      formData.append("firstname" , fname);
					if(lname)      formData.append("lastname"  , lname);
					if(patronomic) formData.append("patronomic", patronomic);
					break;
                case 'feedback-msg':
                    if (property.value && is_local_edit){
                        let [key, value] = Object.entries(feedback)[0];
                        
                        delete feedback[key];

                        let idd = property.id.split('-')[1].toString();

                        value[1] = property.value.trim();

                        feedback[idd] = value;

                        formData.append("feedback", JSON.stringify(feedback));

						// feedbacks.add(JSON.stringify(feedback));
                    }
                    break;
                case 'stars':
                    var inputs = property.getElementsByTagName("input");
                    [...inputs].forEach((star) => {
                        if(star.checked){
                            let [key, value] = Object.entries(feedback)[0];
                            
                            var array = feedback[key];
                            array[0] = star.value;
                            feedback[key] = array;
                        }
                    });

					 // property.parentNode.nextElementSibling

                    break;
                case 'from':
                        var [key, value] = Object.entries(participant)[0];

                        var array = participant[key];
                        array[0] = property.value;
                        participant[key] = array;
                    break;
                case 'to':
                    var [key, value] = Object.entries(participant)[0];
                    var array = participant[key];
                    
                    // Если год последний меньше или равен текущему, то ничего не делать!
                    var from = parseInt(array[0], 10);
                    var to   = parseInt(property.value, 10);

                    if(to < from) { // Допустимо совпадение!
                        console.log(from, to);
                        for (var member in participant) delete participant[member];
                        
                        // TODO : Реализовать оповещение об ошибках!
                    } else {
                        array[1] = property.value;
                        
                        participant[key] = array;
                    }
                    break;
                case 'role':
                    var entries = Object.entries(participant);
                    
                    if(entries.length > 0 && is_local_edit) {
                        var [key, value] = entries[0];
                        delete participant[key];

                        let idd = property.id.split('-')[1].toString();

                        value[2] = property.value.trim();

                        participant[idd] = value;

                        formData.append("team", JSON.stringify(participant));
                    }
                    break;
				case 'artefact': /* Удаление артефакта */
					break;
				case 'artefacts':
				case 'screenshots':
					if(property.files.length > 0){ 
						// screenshots.push(property.files);

						var files = property.files;
						for (var x = 0; x < files.length; x++) {
						    formData.append(property.name + "[]", files[x]);
						}

						// formData.append(property.name, property.src.split('/').slice(-1));
						
						context = this.parentNode.parentNode.parentNode;
						func_page = function(json_data){
							console.log(json_data);
						};
					}
					break;
                case 'screenshot':
					if(is_local_edit){ // ???
						// screenshots.push(property.src.split('/').slice(-1));

						formData.append(property.name, property.src.split('/').slice(-1));
					}
					
                    // formData.append(property.name, property.src.split('/').slice(-1));

                   if(is_local_edit && is_delete){
                       // TODO

                       /// property.parentNode.parentNode.removeChild(property.parentNode);
                   }
                    
                    break;
                case 'files':
                    if(!property.files) console.log(property.parentNode.ondrop.arguments[0].dataTransfer.files);
                    else console.log(property.files);
                    break;
				case 'contact':
					if(! (is_local_edit && is_delete)){
						updateTypeInput.call(property);
					}

					switch(property.type){
					case 'tel':
						phones.push(property.value);
						break;
					case 'email':
						emails.push(property.value);
						break;
					case 'url':
						sites.push(property.value);
						break;
					}

					if(is_local_edit && is_delete){
						property.parentNode.parentNode.parentNode.removeChild(property.parentNode.parentNode);
					}

					break;
				case 'social':
					console.log(property.type, property.value);
					// socials.push(property.href);
					var url = property.href.split('/').slice(-1)[0];

					if(url != "null"){
						// TODO
						socials.add(property.href);
					}

					if(is_delete){
						property.parentNode.parentNode.parentNode.parentNode.removeChild(property.parentNode.parentNode.parentNode);
					}
					
					break;
				case 'reference':
					if(property.href !== window.reference_default){
						references.push(property.href);
					}
						
					if(is_delete){
						property.parentNode.parentNode.parentNode.removeChild(property.parentNode.parentNode);
					}

					break;
				case 'tag':
					if(property.textContent.trim() !== ''){
						tags.push(property.textContent.trim().split('#')[1]);
					} else if(property.value !== '') {
						tags.push(property.value);
					}
					
					if(is_delete){
						property.parentNode.parentNode.removeChild(property.parentNode);
					}
					break;
				case 'duty':
					duties.push(property.value);

					if(is_delete){
						property.parentNode.parentNode.parentNode.removeChild(property.parentNode.parentNode);
					}
					break;
				case 'goal':
					goals.push(property.value);

					if(is_delete){
						property.parentNode.parentNode.parentNode.removeChild(property.parentNode.parentNode);
					}
					break;
				case 'skill':
					skills.push(property.value);

					if(is_delete){
						property.parentNode.parentNode.parentNode.removeChild(property.parentNode.parentNode);
					}
					break;
				case 'stack':
					if(property.textContent !== ''){
						stack.push(property.parentNode.textContent.trim());
					}

					if(is_delete){
						property.parentNode.parentNode.parentNode.removeChild(property.parentNode.parentNode);
					}
					break;
				case 'icon':
					if(is_local_edit){ 
						var cstm_header = property.parentNode.parentNode.parentNode.parentNode.parentNode;
						if(is_delete){
		                    if (property.value.trim() !== "") { formData.append(property.name.split('_')[0], property.value.split('/').pop().trim()); property.textContent = null; }; // отправляем url на аватарку по умолчанию;
							cstm_header.setAttribute('url', '');
						} else {
							if (property.value.trim() !== "") formData.append(property.name, property.files[0]); // property.value.trim() // Загрузка новой аватарки, отличной от аватарки по умолчанию;

							context = cstm_header;                                                        // Определение контекста
							func_page = function(json_data){                                              // Определение обработчика загрузки;
								if (json_data.hasOwnProperty('error_code') && json_data['error_code']) { // Очистка после успешной загрузки;
			                        this.setAttribute('url', '');
									window.notice.setAttribute('value', `Не удалось сохранить изображения на сервере! Код ошибки: ${json_data['error_code']} `);
			                    } else if (json_data.hasOwnProperty('icon')) {
									this.setAttribute('url', json_data['icon']);
									if(currentPage == 'profile'){
										var elem = document.getElementsByClassName('avatar')[0];
										elem.setAttribute('src', json_data['icon']);
									}
				                } else {
									// TODO
								}
							};
						}
					}
					break;
				default:
					if(property.name){ 
						formData.append(property.name, property.value);
					} else {
						if(property.hasAttribute('name')){
							/*if(property.hasAttribute('value')) {
								formData.append(property.attributes.name.nodeValue, property.value);
							} else {
								formData.append(property.attributes.name.nodeValue, property.textContent.trim()); // trim() ???
							}*/

							switch(property.attributes.name.nodeValue){
								case 'goal':
									goals.push((property.hasAttribute('value') ? property.value : property.textContent.trim() ));
									break;
								case 'duty':
									duties.push((property.hasAttribute('value') ? property.value : property.textContent.trim() ));
									break;
							}
							
						} else {
							console.log(property.name, property.value);
						}
					}
					break;
            }
        });

		if (emails.length > 0) contacts['emails'] = emails;
		if (phones.length > 0) contacts['phones'] = phones;
		if ( sites.length > 0) contacts['sites']  = sites;

		if (    socials.size > 0) formData.append('socials', JSON.stringify(Array.from(socials)));
		if ( references.length > 0) formData.append('refs',           JSON.stringify(references));
		if (screenshots.length > 0) formData.append('screenshots',    screenshots); // JSON.stringify(screenshots)

		if (  tags.length > 0)  formData.append('tags',   JSON.stringify(tags));
		if ( stack.length > 0)  formData.append('stack',  JSON.stringify(stack));
		if (skills.length > 0)  formData.append('skills', JSON.stringify(skills));
		if ( goals.length > 0)  
		{ 
			formData.append('goals',  JSON.stringify(goals));
		}
		if (duties.length > 0)  formData.append('duties', JSON.stringify(duties));
			
		if (Object.keys(contacts).length > 0) formData.append('contacts', JSON.stringify(contacts));

		// if(feedbacks.size > 0) formData.append("feedback", JSON.stringify(Array.from(feedbacks)));
		
		var formDataLength = Array.from(formData.keys()).length;
		
		console.log('formData.count: ', formDataLength);
		
		if(formDataLength > 1) { 
	        formData.entries().forEach((entry) => { // For Debug;
	            console.log(entry);

				// add console.log for Files
	        });

	        ajax_formData(formData, func_page, path, context); // this -> context;
		}
    }
}

window.editPage = editPage;

export function deletePage(path){
	var currentPage = getCurrentPage();

	var formData = new FormData();
	
	var context   = this; // Для возможности использования в `func_page` как от имени объекта, вызвавшего данную функцию.
    var func_page = function (result) { }; // Финкция обработки результатов запроса.

	formData.append('action',  "delete_page");
	formData.append('page',  currentPage);

	var formDataLength = Array.from(formData.keys()).length;

	// For Debug;
	if(formDataLength > 1) { 
		formData.entries().forEach((entry) => { 
			console.log(entry);
		});

		ajax_formData(formData, func_page, path, context); // this -> context;
	}
}

window.deletePage = deletePage;

function selectTypeContact() {
    var value = '';
    var type = '';
    var name = '';
    var maxlength = '';
    var placeholder = '';
    var mask = function (params) { };
    switch (this.value) {
        case 'Телефон':
            value = "+7(___)___-__-__";
            placeholder = value;

            type = 'tel';
            name = 'phone';

            maxlength = '17';

            mask = mask_phone;
            break;
        case 'Почта':
            value = "___@___.__";
            placeholder = value;

            type = 'email';
            name = 'email';

            mask = mask_email;
            break;
        case 'Сайт':
            value = "http://...";
            placeholder = value;

            type = 'url';
            name = 'site';

            mask = mask_site;
            break;
    }

    //input.removeEventListener('input');

    //input.addEventListener("input", mask_phone, false);
    var input = this.nextElementSibling;
    input.name = name;
    input.id = name; // временно;
    input.type = type;
    input.value = value;
    input.maxlength = maxlength;
    input.placeholder = placeholder;

    input.setAttribute('oninput', mask_phone);

    input.setAttribute('value', value);
    input.setAttribute('maxlength', maxlength);
    input.setAttribute('placeholder', placeholder);
}

function accum(array) { // contentProperties.tags.childNodes
    /*var elems = '[';
    for (var i = 0; i < this.length - 1; i++) elems += '"' + this[i].textContent.trim() + '", ';
    elems += '"' + this[this.length - 1].textContent.trim() + '"]';*/

    var elems = [];
    for (var i = 0; i < this.length; i++)
        elems.push(this[i].textContent.trim());

    /*elems += '"' + this[i].textContent.trim() + '", ';
    elems += '"' + this[this.length - 1].textContent.trim() + '"]';*/

    return elems;
}

function ajax_formData(data, func, path, obj) {
    $.ajax({
        context: obj,
        type: "POST",
        url: path,
        cache: false,
        data: data,
        dataType: 'json',
        // отключаем обработку передаваемых данных, пусть передаются как есть
        processData: false,
        // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
        contentType: false,
        success: func
    });
}

function ajax_img(data, path, class_name) {
    $.ajax({
        type: "POST",
        url: path,
        cache: false,
        data: data,
        dataType: 'json',
        // отключаем обработку передаваемых данных, пусть передаются как есть
        processData: false,
        // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
        contentType: false,
        success: function (json_data) {                                  /* let json_data = result;*/
            if (json_data.hasOwnProperty('icon'))                        /* var elements = document.getElementsByClassName('avatar-img'); */
                [...document.getElementsByClassName(class_name)]
                    .forEach((element) => { element.src = json_data['icon']; });
        }
    });
}

function ajax_data(data, func, path) { // function(result) { let json_data = JSON.parse(result); }
    $.ajax({
        type: "POST",
        url: path,
        data: data,
        success: func
    });
}

function resultSearch(value) {

    var result_container = document.getElementById('result');

    console.log(result_container.childNodes.length);

    if (result_container.childNodes.length > 2) result_container.removeChild(result_container.lastChild);

    var elem = document.createElement('button');

    elem.textContent = value;
    elem.setAttribute('onclick', 'this.remove();');
    //elem.onclick='remove(this)';

    result_container.append(elem);

    var input = document.getElementById('myInput');
    input.value = '';

    var ul = document.getElementById("myUL");
    ul.setAttribute('hidden', true);

    //input.textContent = "";

    //result_container.appendChild(elem);

    console.log("resultSearch");
}

function resultSearchTags(value) {

    var result_container = document.getElementById('result');

    var labels = result_container.getElementsByClassName('labelTag');

    //console.log(labels, value);

    /*for (const label of labels) // ограничение на повторения
        if(label.textContent === value) 
            label.remove();*/

    /*labels.forEach(label => {
        if(label.textContent === value) 
            label.remove();
    });*/

    //if(result_container.childNodes.length > 2) result_container.removeChild(result_container.lastChild);

    var label = document.createElement('label');

    label.textContent = value;
    label.setAttribute('class', 'labelTag');

    var button = document.createElement('button');


    button.setAttribute('onclick', 'this.parentNode.remove();');
    button.setAttribute('class', 'buttonTag');

    button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="7 10 20 20"><path stroke="#F6F6F6" stroke-linecap="round" d="M10.903 14.904 15.5 19.5m0 0 4.597 4.596M15.499 19.5l4.597-4.596M15.499 19.5l-4.596 4.596"/></svg>';

    //elem.onclick='remove(this)'; // width="31" height="39"

    label.append(button);

    result_container.append(label);

    var input = document.getElementById('myInput');
    input.value = '';

    var ul = document.getElementById("myUL");
    ul.setAttribute('hidden', true);

    //input.textContent = "";

    //result_container.appendChild(elem);

    //console.log("resultSearch");
}

//let currentIndex = 2;

function loadMetaStars(elem) {
    const carouselItems = document.getElementsByClassName('item-of-stars'); //querySelectorAll

    //var elem = carouselItems[2];
    var metaData = elem.title.split(',');

    var art = document.getElementById('article-item');
    var elem_center = art.getElementsByClassName('HelveticaMain2')[0];
    var elem_left = art.getElementsByClassName('VasekMain2')[0];
    var elem_right = art.getElementsByClassName('VasekMain2')[1];

    elem_left.textContent = metaData[0];
    elem_center.textContent = metaData[1];
    elem_right.textContent = metaData[2];

    // console.log(elem.title);
}

function setPattern() {
    var tels = document.getElementsByName('phone');

    tels.forEach((tel) => {
        //tel.pattern = "\\+7\\s?[\\(]{0,1}9[0-9]{2}[\\)]{0,1}\\s?\\d{3}[-]{0,1}\\d{2}[-]{0,1}\\d{2}";
        //console.log(tel);
    });
}

function setCursorPosition(pos, e) {
    e.focus();
    if (e.setSelectionRange) e.setSelectionRange(pos, pos);
    else if (e.createTextRange) {
        var range = e.createTextRange();
        range.collapse(true);
        range.moveEnd("character", pos);
        range.moveStart("character", pos);
        range.select()
    }
}

function mask_phone(e) {
    var matrix = this.placeholder,// .defaultValue
        i = 0,
        def = matrix.replace(/\D/g, ""),
        val = this.value.replace(/\D/g, "");
    def.length >= val.length && (val = def);
    matrix = matrix.replace(/[_\d]/g, function (a) {
        return val.charAt(i++) || "_"
    });
    this.value = matrix;
    i = matrix.lastIndexOf(val.substr(-1));
    i < matrix.length && matrix != this.placeholder ? i++ : i = matrix.indexOf("_");
    setCursorPosition(i, this);
}

function mask_email(e) {

}

window.mask_email = mask_email;

function mask_site(e) {

}

window.mask_site = mask_site;

function updateTextAreaResize() {
    var textareas = document.getElementsByTagName('textarea');
    [...textareas].forEach((elem) => { // Недостаток `textarea` исправляем таким образом. // div c contentEdit='true'.
        //console.log(elem);

        //console.log(elem.offsetHeight, elem.cols, elem.rows, elem.textLength, elem.clientHeight);
        var data = elem.innerHTML;
        elem.innerHTML = '';
        elem.style.height = 0 + 'px';

        // console.log(elem.scrollHeight, elem.offsetHeight); // data, 

        elem.innerHTML = data;

        // console.log(elem.scrollHeight, elem.offsetHeight); // data, 

        elem.style.height = (elem.scrollHeight > 0 ? elem.scrollHeight : 40) + 'px';

        // elem.style.height = elem.innerHTML. + 'px';
    });
    //document.getElementById("aboutProjTextarea").autosize();
}

window.addEventListener('load', function () { // - выполняется после полной загрузки
    window.addEventListener('resize', function (event) {
        updateTextAreaResize();
    }, true);

    window.dispatchEvent(new Event('resize'));

	window.notice = document.getElementsByTagName('cstm-notice')[0];
});

class Carousel {
  constructor(container) {
    this.carousel = container.querySelector('.carousel');
    this.items = Array.from(this.carousel.children);
    this.currentIndex = 2;
    this.itemWidth = this.items[0].offsetWidth + 30; // width + margin
    
    this.init();
    this.addEventListeners();
  }

  init() {
    this.items.forEach((item, index) => {
      item.classList.toggle('active', index === this.currentIndex);
    });
    this.centerCarousel();
  }

  centerCarousel() {
    const scrollPosition = this.currentIndex * this.itemWidth - 
      (this.carousel.offsetWidth / 2 - this.itemWidth / 2);
    
    this.carousel.style.transform = `translateX(-${scrollPosition}px)`;
  }

  next() {
    if (this.currentIndex < this.items.length - 1) {
      this.currentIndex++;
      this.updateCarousel();
    }
  }

  prev() {
    if (this.currentIndex > 0) {
      this.currentIndex--;
      this.updateCarousel();
    }
  }

  updateCarousel() {
    this.items.forEach(item => item.classList.remove('active'));
    this.items[this.currentIndex].classList.add('active');
    this.centerCarousel();
  }

  addEventListeners() {
    document.querySelector('.next').addEventListener('click', () => this.next());
    document.querySelector('.prev').addEventListener('click', () => this.prev());
    
    // Добавляем обработчик для свайпов
    let touchStartX = 0;
    this.carousel.addEventListener('touchstart', e => {
      touchStartX = e.touches[0].clientX;
    });
    
    this.carousel.addEventListener('touchend', e => {
      const touchEndX = e.changedTouches[0].clientX;
      const diff = touchStartX - touchEndX;
      
      if (Math.abs(diff) > 50) {
        diff > 0 ? this.next() : this.prev();
      }
    });
  }
}

window.addEventListener('DOMContentLoaded', function () {
    //loadMetaStars();
    //goToNextSlide();

    console.log('DOMContentLoaded');

    setPattern();

    //var input = document.querySelector("#phone");
    //if (input) input.addEventListener("input", mask_phone, false);

    var list = document.getElementById("dragAndDrop");

    var sortableList = document.getElementsByClassName('dragAndDrop');

    [...sortableList].forEach((container) => {
        var dragTag = '';
        var remId = '';
        switch (container.id) {
            case 'contacts':
                dragTag = 'span';
                remId = 'contact';
                break;
            case 'urls':
                dragTag = 'span';
                remId = 'url';
                break;
            default:
                break;
        }

        /*
        draggable: dragTag,
        */
        new Sortable(container, {
            draggable: dragTag,
            animation: 150,
            axis: "y",
            filter: 'input', // Исключаем из сортировки возможность брать за input и перетаскивать
            preventOnFilter: false, // Позволяем передовать внешнему обработчику собития на фокус.
            onEnd: function (event) {
                var elem = event.originalEvent.target;
                if (elem.classList.contains('remove') && elem.id === remId) event.item.remove();
            }// filter: 'input',
        });
    });

	var currentPage = getCurrentPage();

	if(currentPage === 'index' || currentPage===''){
		// Инициализация карусели
		new Carousel(document.querySelector('.carousel-container'));
	}
	
/*
	switch(currentPage){
		case '':
			// Инициализация карусели
			new Carousel(document.querySelector('.carousel-container'));
			break;
	}
*/



/*document.querySelectorAll('.starBtn').forEach(button => {
button.addEventListener('click', () => {
    const carousel = button.parentElement.querySelector('.carousel-inner');
    const scrollWidth = carousel.scrollWidth;
    const itemWidth = carousel.querySelector('cstm-star').offsetWidth;
    const scrollPosition = carousel.scrollLeft;
    
    button.classList.contains('prev') 
      ? carousel.scrollBy({ left: -itemWidth, behavior: 'smooth' })
      : carousel.scrollBy({ left: itemWidth, behavior: 'smooth' });
  });
});*/

    // window.onresize = updateTextAreaResize;
    //setInterval(goToNextSlide, 2000);
}, false);

/*window.addEventListener("DOMContentLoaded", function() {
    var input = document.querySelector("#online_phone");
    input.addEventListener("input", mask, false);
    input.focus();
    setCursorPosition(3, input);
});*/

function goToSlide2(index) {
    const carouselItems = document.getElementsByClassName('item-of-stars'); //querySelectorAll

    if (carouselItems.length > 0) {
        //console.log(carouselItems[currentIndex]);
        //carouselItems[currentIndex].style.visibility = 'hidden';
        //carouselItems[currentIndex].style.transform = `scale(0.5)`;

        /*if (index < 0) {
        index = carouselItems.length - 1;
        } else if (index >= carouselItems.length) {
        index = 0;
        }*/

        localIndex = index % carouselItems.length;
        currentIndex = index;


        ///carouselItems[currentIndex].style.visibility = 'visible';

        //document.querySelector('.carousel-inner').style.transform = `translateX(-${currentIndex * 25}%)`;

        var elem = carouselItems[localIndex];

        if (carouselItems.length > 5) {

            if (elem.previousElementSibling.previousElementSibling.previousElementSibling) {
                elem.remove();
            }

            var elem = carouselItems[localIndex];

            var l2 = elem.previousElementSibling.previousElementSibling;
            var l1 = elem.previousElementSibling;
            var c = elem;
            var r1 = elem.nextElementSibling;
            var r2 = elem.nextElementSibling.nextElementSibling;

            var buff = r2.style.transform;
            r2.style.transform = r1.style.transform;
            r1.style.transform = c.style.transform;
            c.style.transform = l1.style.transform;
            l1.style.transform = l2.style.transform;
            l2.style.transform = buff;

            elem.parentNode.style.transform = `translateX(-${currentIndex * 5}%)`;
            elem.parentNode.append(l2.cloneNode(true)); // Добавление скытого в конец;

        } else if (carouselItems.length == 5) {


            var l2 = elem.previousElementSibling.previousElementSibling;
            var l1 = elem.previousElementSibling;
            var c = elem;
            var r1 = elem.nextElementSibling;
            var r2 = elem.nextElementSibling.nextElementSibling;

            var buff = r2.style.transform;
            r2.style.transform = r1.style.transform;
            r1.style.transform = c.style.transform;
            c.style.transform = l1.style.transform;
            l1.style.transform = l2.style.transform;
            l2.style.transform = buff;

            elem.parentNode.style.transform = `translateX(-${currentIndex * 100} %)`;

            loadMetaStars(c);
            // elem.parentNode.append(l2.cloneNode(true)); // Добавление скытого в конец;

            //elem.parentNode.style.transform = `translateX(+${currentIndex * 0}%)`;
            //currentIndex--;
            //if(currentIndex > );



        } else {

        }

        console.log(elem.previousElementSibling.id - 1, elem.previousElementSibling.style.transform);
        console.log(currentIndex, elem.style.transform); // scale // transform: scale(...);

        //elem.style.transform = `scale(1.5)`;
        // document.querySelector('.carousel-inner').style.transform = `translateX(-${currentIndex * 100}%)`;
        //carouselItems[prevIndex].parentNode.append(carouselItems[prevIndex]); // добавление в конец


        if (elem.nextElementSibling) console.log(elem.nextElementSibling.id);
    }
}

let currentIndex = 0;
const carouselItems = document.getElementsByClassName('item-of-stars');

var buff_transform = [];

function goToSlide(index) {
    if (index < 0) {
        index = carouselItems.length - 1;
    } else if (index >= carouselItems.length) {
        index = 0;
    }
    currentIndex = index;

    var elem = carouselItems[currentIndex];

    console.log(elem.id);

    if (currentIndex === 0) {
        var l2 = elem.previousElementSibling.previousElementSibling;
        var l1 = elem.previousElementSibling;
        var c = elem;

        buff_transform.push(l2.style.transform);
        buff_transform.push(l1.style.transform);
        buff_transform.push(c.style.transform);
    }

    var l2 = elem.previousElementSibling.previousElementSibling;
    var l1 = elem.previousElementSibling;
    var c = elem;
    var r1 = elem.nextElementSibling;
    var r2 = elem.nextElementSibling.nextElementSibling;

    var buff = r2.style.transform;
    r2.style.transform = r1.style.transform;
    r1.style.transform = c.style.transform;
    c.style.transform = l1.style.transform;
    l1.style.transform = l2.style.transform;
    l2.style.transform = buff;

    var inner = elem.parentNode;

    var width_inner = elem.parentNode.offsetWidth;

    document.querySelector('.carousel-inner').style.transform = `translateX(-${(currentIndex + 1) * width_inner / (carouselItems.length)}px)`;
}


function goToNextSlide() {
    //carouselItems[currentIndex].style.display = "none";
    goToSlide(currentIndex + 1);
    //loadMetaStars();
    //carouselItems[currentIndex].style.display = "block";
}

function goToPrevSlide() {
    goToSlide(currentIndex - 1);
}

//setInterval(goToNextSlide, 2000); // автоматическая прокрутка каждые 3 секунды

function inputSugToolTip(path) {

    let inputValue = document.getElementById("inputSearch").value;
    //document.getElementsByClassName('inputSug')[0].style.display = 'flex';

    $.ajax({
        type: "POST",
        url: path,
        data: {
            search: inputValue,
            action: "show_input_suggestion"
        },
        success: function (result) {
            //console.log(result);
            //print_projects(result);
            //document.getElementsByClassName('buttonRef')

            let section = document.getElementById('sctn-1');
            let curWidth = section.offsetWidth;
            console.log(curWidth);
            section.style.setProperty('min-width', curWidth + 'px');

            document.getElementById('projects').innerHTML = '';

            if (document.getElementById('inputLi'))
                document.getElementById('inputLi').remove();

            print_projects(result);
            // let projectTitle = document.getElementById('projectTitle').innerHTML;
            //$('#inputSugUi').append('<li id="inputLi"><button class="inputLiBtn">' + projectTitle + '</button></li>');
        }
    });

}

window.inputSugToolTip = inputSugToolTip;

function hideInputSugToolTip() {

    document.getElementsByClassName('inputSug')[0].style.display = 'none';

    if (document.getElementById('inputLi'))
        document.getElementById('inputLi').remove();
}

function orderByNewest(path) {
    $.ajax({
        type: "POST",
        url: path,
        data: {
            // search: inputValue,
            type: 'new', // 'old' // 'rel';
            action: "order_project"
        },
        success: function (result) {
            console.log(result);
            document.getElementById('projects').innerHTML = '';
            print_projects(result);

        }
    });
}

function order_sort(type, path) {
    var currentPage = window.location.href.split('/').pop().split('.')[0];

    if (this.style.background === '') {
        this.style.background = 'red';

        $.ajax({
            type: "POST",
            url: path,
            data: {
                // search: inputValue,
                type: type, // 'old' // 'relevant';
                page: currentPage,
                action: "order_sort"
            },
            success: function (result) {
                console.log(result);

                document.getElementById('projects').innerHTML = '';

                print_projects(result);

            }
        });

    } else {
        this.style.background = '';

        query_projects(path);
    }
}

function resizeTextarea() {
    this.style.height = '1px';
    this.style.height = (this.scrollHeight + 6) + 'px';
}

window.resizeTextarea = resizeTextarea;

function changeStars() {
    console.log(this, this.style.fill);

    if (this.hasAttribute('stroke')) {
        console.log('stroke');
    } else {
        console.log('fill');
    }
}

function moveStar(diriction) {

    var itemListParent = document.querySelector('.carousel-inner');
    var itemList = document.querySelectorAll('.star');

    // hideNonShowStars(itemList);

    console.log(itemListParent);


    if (diriction === 0) {
        itemListParent.insertBefore(itemList[0], null)
    } else {
        itemListParent.insertBefore(itemList[9], itemList[0]);
    }
    // $(itemList[0]).hide().slideDown(2000);

    var itemList = document.querySelectorAll('.star');
    // setTimeout(() => {

    itemList[0].style.setProperty('transform', 'scale(0.3)');
    itemList[1].style.setProperty('transform', 'scale(0.7)');
    itemList[2].style.setProperty('transform', 'scale(1)');
    itemList[3].style.setProperty('transform', 'scale(0.7)');
    itemList[4].style.setProperty('transform', 'scale(0.3)');
    // }, 100);

    let nextTitle = itemList[2].title.split(',');

    let curTitle = document.getElementById('bestPeople');

    curTitle.childNodes[0].innerHTML = nextTitle[0];
    curTitle.childNodes[1].innerHTML = nextTitle[1];
    curTitle.childNodes[2].innerHTML = nextTitle[2];

    $("#bestPeople").hide().fadeIn("slow");

}

export function arrowAnimationEnter(el) {
    console.log(el);
    if (el.type == "submit") {
        el.style.setProperty('padding-right', '4vw');
    } else {
        el.childNodes[3].style.setProperty('margin', '0 1rem 0 1rem');
    }
    //let arrow = document.getElementById("projArrow");
    // let arrowBtnDiv = document.getElementById('arrowBtnDiv');
    // arrowBtnDiv.style.setProperty()
    // arrow.style.setProperty('margin', '0 1rem 0 1rem');
}

window.arrowAnimationEnter = arrowAnimationEnter;

function arrowAnimationLeave(el) {
    // let arrow = document.getElementById("projArrow");
    // arrow.style.setProperty('margin', '0 3rem 0 1rem');
    if (el.type == "submit") {
        el.style.setProperty('padding-right', '5vw');
    } else {
        el.childNodes[3].style.setProperty('margin', '0 3rem 0 1rem');
    }
}

window.arrowAnimationLeave = arrowAnimationLeave;

// When the user clicks on the button, scroll to the top of the document
function topFunction() {

    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera

    $('#load_project_button').attr('onclick', "loadProjets('/assets/frontend/pages/action.php');");

    var svg = document.getElementById('load_project_svg');
    svg.style.transform = "rotate(0deg)";
    var p = document.getElementById('load_project_p');
    p.style.display = "none";
}

function like(project_id, path) {
    var formData = new FormData();
    var func_page = function (result) {
        let json_data = result; // JSON.parse(result)

        if (json_data.hasOwnProperty('check_like_project')) { // && json_data.hasOwnProperty('error_code')
            if (json_data['check_like_project'] === 'success') {

				var is_like_project = false;
				if(json_data.hasOwnProperty('is_like'));
				 is_like_project = json_data['is_like'];

				// Отметка успешности.
				this.previousElementSibling.classList.toggle('like-svg', is_like_project);
				this.previousElementSibling.classList.toggle('not-like-svg', !is_like_project);

				// Обновление счётчика лайков.
				this.textContent = json_data['like']; 
            }
        }
    };

    formData.append('project_id', project_id);
    formData.append('action', "check_like_project");

	// For Debug;
    /*
	formData.entries().forEach((entry) => { 
        console.log(entry);
    });
	*/

    ajax_formData(formData, func_page, path, this);
}

window.like = like;