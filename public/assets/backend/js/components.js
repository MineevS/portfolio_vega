export function getCurrentPage(){
	return window.location.href.split('/').pop().split('.')[0];
}

window.getCurrentPage = getCurrentPage;

export class CustomLoadData extends HTMLElement {
	connectedCallback() {

		var action     = (this.hasAttribute('action')      ? this.getAttribute('action')      : '');
		
		this.innerHTML = `
		    <button class="loadB" id="load_project_button" type="submit" onclick="loadProjets('${action}');">
	            <svg id="load_project_svg" width="30" height="30" >
                    <use xlink:href="#load_scroll"></use>
	            </svg>
            </button>
            <p class="loadP" id="load_project_p">Кажется вы всё посмотрели</p>`;
	}
}

customElements.define('cstm-load-data', CustomLoadData);

export class CustomFormVacancy extends HTMLElement {
	connectedCallback() {
		var map_data = {
			'style1' : { 'background': '#BBEFD4', 'color' : '#0E7B43'} ,
			'style2' : { 'background': '#FFF3CD', 'color' : '#866906'}
		};

		var coincidence = (this.hasAttribute('coincidence') ? this.getAttribute('coincidence') : null);
		var speciality  = (this.hasAttribute('speciality')  ? this.getAttribute('speciality')  : '');
		var action      = (this.hasAttribute('action')      ? this.getAttribute('action')      : '');
		var tags        = (this.hasAttribute('tags')        ? this.getAttribute('tags')        : '');
		var duties      = (this.hasAttribute('duties')      ? this.getAttribute('duties')      : '');
		var experience  = (this.hasAttribute('experience')  ? this.getAttribute('experience')  : '');
		var id          = (this.hasAttribute('data-id')     ? this.getAttribute('data-id')     : '');
		var is_grid     = (this.hasAttribute('is-grid')     ? this.getAttribute('is-grid')     : '');
		
		var tags_html = '', duties_html = '', experience_html = '';

			if(tags.length < 1) tags_html = '<p class="tagV">Теги отсутствуют</p>';
			else {
				tags = JSON.parse(tags); // php: htmlspecialchars($tags, ENT_QUOTES, 'UTF-8');
				
				tags_html += `<div class="contentProperty tagsV" id="tags" class="resultTag">`;
				[...tags].forEach(tag => {                             // .split(',')
					tags_html += `<label class="tagV">${tag}</label>`; // .replace(' ', "_")
				});
				tags_html += '</div>';
			}

			if(duties.length < 1) duties_html = '<p class="duty">Обязанности отсутствуют</p> ';
			else {
				duties = JSON.parse(duties);
				
				duties_html = `<div><p class="cardDuties">Обязанности:</p><ul>`;
				[...duties].forEach(duty => {                            
					duties_html += `<li class="cardDuty">${duty}</li>`;
				});
				duties_html += `</ul></div>`;
			}

			if(experience.length < 1) experience_html = '<p class="duty">Tребуемый опыт отсутствуют</p> ';
			else {
				experience = JSON.parse(experience);
				
				experience_html = `<div><p class="cardDuties">Опыт:</p><ul>`;
				[...experience].forEach(exper => {                            
					experience_html += `<li class="cardDuty">${exper}</li>`;
				});
				experience_html += `</ul></div>`;
			}

		var description = (this.hasAttribute('description')  ? this.getAttribute('description')  : '');
		var is_coincidence = (this.hasAttribute('is-coincidence')  ? strToBool(this.getAttribute('is-coincidence')) : false);
		
		var input_coin = '';
		if(is_coincidence) {
			var coin_style = map_data[(coincidence > 50 ? 'style1': 'style2')];
			const styleString = (
				  Object.entries(coin_style).map(([k, v]) => `${k}:${v}`).join(';')
			);
			input_coin = `<input type="text" style="${styleString}" class="coincidenceVacancy" value="совпадение ${coincidence}%">`;
		}
		
		this.innerHTML = `
		<form class="formVacancy" method="POST"  action="${action}">
            <div class="divVacancy">
                <div class="vacancy2">
                    <h1 class="cardTitle">${speciality}</h1>
					${input_coin}
				</div>
				<p class="vacancieDescription">${description}</p>
				${tags_html}
				${duties_html}
				${experience_html}
			</div>
			<input type="hidden" name="id" id="id" value="${id}">
	        <button  class="clickVacancy" type="submit" > Откликнуться </button>
		</form>`;
	}
}

customElements.define('cstm-form-vacancy', CustomFormVacancy);

export class CustomStar extends HTMLElement {
	connectedCallback() {

		var id   =  (this.hasAttribute('id') ? this.getAttribute('id') : "");
		var icon =  (this.hasAttribute('icon') ? this.getAttribute('icon') : "");
		
		this.innerHTML = `
		<svg class="star" id="${id}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 470" fill="currentColor">
		    <defs>
                <pattern id="star-image-${id}" x="0%" y="0%" height="100%" width="100%" viewBox="0 0 512 512">
                    <image x="0%" y="0%" width="512" height="512" xlink:href="/assets/frontend/icons/avatars_profiles/${icon}"/>
                </pattern>
            </defs>

			<path d="M112.608 466.549c-12.038 6.175-25.698-4.647-23.266-18.463l25.886-147.517L5.355 195.904c-10.26-9.793-4.928-27.694 8.826-29.628l152.756-21.706L235.05 9.622c6.144-12.163 22.767-12.163 28.91 0l68.114 134.948 152.756 21.706c13.754 1.934 19.087 19.835 8.795 29.628L383.783 300.57l25.885 147.517c2.433 13.816-11.227 24.638-23.265 18.463l-136.944-70.36-136.882 70.36h.031z"/>
            <ellipse fill="url(#star-image-${id})" stroke="red" stroke-width="4" ry="120.22" rx="117" cy="262.22" cx="246" style="filter: grayscale(1);"/>
            <path fill="none" d="M262 380h10c1 0 2.027.23 3 0 2.176-.514 3-1 4-1s2-1 5-1c1 0 2-1 3-1s2.027.23 3 0c2.176-.514 3-1 5-1 1 0 2-1 3-1 2 0 4.293-.293 5-1a9.233 9.233 0 0 1 3-2c.924-.383 2.076.383 3 0 1.307-.541 2.186-.693 4-2 1.147-.827 2-1 3-1s2.076-.617 3-1c1.307-.541 1.824-2.486 4-3 1.946-.46 2.693-1.459 4-2 .924-.383 2.293-.293 3-1 .707-.707.293-1.293 1-2 .707-.707 2.15-.474 3-1 1.902-1.176 2.186-2.693 4-4 1.147-.827 1.293-1.293 2-2 .707-.707 1.076-.617 2-1 1.307-.541 1.293-1.293 2-2 .707-.707 1.459-.693 2-2 .383-.924 1.293-.293 2-1 .707-.707 1.293-2.293 2-3 .707-.707 1.293-.293 2-1 .707-.707.293-1.293 1-2 .707-.707 1.293-.293 2-1 .707-.707.459-1.693 1-3 .383-.924.293-1.293 1-2 .707-.707 1.293-.293 2-1 .707-.707.459-1.693 1-3 .383-.924 1.486-.824 2-3 .23-.973.293-1.293 1-2 .707-.707 1-1 1-2l2-2M140 207c0-1 1.77-3.027 2-4 .514-2.176-.072-5.611 2-8 1.465-1.69 2.293-2.293 3-3 .707-.707 1.419-.419 3-2s1.853-3.173 3-4c1.814-1.307 3.419-3.419 5-5s1-3 2-4c2-2 2.293-3.293 3-4l2-2c1-1 1.693-2.186 3-4 .827-1.147 1.186-1.693 3-3 1.147-.827 1.77-3.027 2-4 .514-2.176 1.693-3.186 3-5 .827-1.147 2.459-1.693 3-3 .383-.924.293-2.293 1-3 .707-.707 2.293-.293 3-1 .707-.707.853-2.173 2-3 1.814-1.307 2.853-2.173 4-3 1.814-1.307 3.293-2.293 4-3 .707-.707 2 0 3-1s3.293-1.293 4-2c.707-.707 2.293.707 3 0 .707-.707 1-1 2-1h2" stroke-width="4" stroke="red"/>
            <path fill="none" d="M142 194c0 1-.293 1.293-1 2-.707.707-.459 1.693-1 3-.383.924-.459 3.693-1 5-.383.924-1 2-1 3s-1 2-1 3-.459 1.693-1 3c-.765 1.848-.459 2.693-1 4-.765 1.848-1 4-1 5s-.459 1.693-1 3c-.383.924 0 2 0 3s-.459 1.693-1 3c-.383.924 0 2-1 3s-1.486 2.824-2 5c-.23.973-1 2-1 3s-.173 1.853-1 3c-1.307 1.814-.235 3.152-1 5-.541 1.307-1 2-1 3v6c0 1-1 2-1 3v21c0 2 1 3 1 5 0 1 1.459 1.693 2 3 .765 1.848-.46 3.054 0 5 .514 2.176 1 3 1 5 0 1-.23 4.027 0 5 .514 2.176 1 4 1 5v7c0 1 .54 2.054 1 4 .514 2.176 1 3 1 4s1 2 1 4c0 1 .459 1.693 1 3 .383.924 2 3 2 5 0 1 .293 2.293 1 3 .707.707 1.918 1.387 3 4 .383.924.459 1.693 1 3 .383.924-.051 1.299 1 3 1.176 1.902 3 3 4 4 2 2 3.415 4.189 4 5 1.849 2.565 6.889 4.194 12 7 3.92 2.152 6.797 4.256 8 5 2.69 1.663 6.868 2.289 11 4 2.922 1.21 4.647 2.973 9 4 3.893.919 7 1 11 1h25c1 0 2 1 4 1 1 0 3.022-.367 6 0 4.092.504 5.693 1.459 7 2 1.848.765 6.938.498 13 1 3.986.33 6 0 7 0s3.039-.48 6 0c3.121.507 7 1 9 1h16c1 0 2.076.383 3 0 1.307-.541 3.15-.474 4-1 1.902-1.176 2.693-2.459 4-3 .924-.383.419-1.419 2-3s4-2 5-3l4-4c1-1 1.076-1.617 2-2 1.307-.541 3-4 5-5s4.076-2.617 5-3c1.307-.541 1.293-1.293 2-2 .707-.707 1.076-.617 2-1 1.307-.541 1.853-1.173 3-2 1.814-1.307 3.076-2.617 4-3a9.233 9.233 0 0 0 3-2c.707-.707.293-2.293 1-3 .707-.707 1-1 2-1s.293-1.293 1-2c.707-.707 1.459-.693 2-2 .383-.924 2-2 2-3v-1M364 322v-3c0-1 .293-1.293 1-2 .707-.707-.707-2.293 0-3 .707-.707 1.459-.693 2-2 1.148-2.772.235-4.152 1-6 .541-1.307 1-2 1-3 0-2 1.486-3.824 2-6 .46-1.946-.148-4.228 1-7 .541-1.307.235-2.152 1-4 .541-1.307 2-4 2-5s.459-1.693 1-3c.765-1.848 0-3 0-4v-35c0-1-.617-3.076-1-4-.541-1.307-1.493-2.879-2-6-.32-1.974-.42-5.086-1-7-1.045-3.45-2.52-5.039-3-8-.507-3.121-2.459-3.693-3-5-.383-.924 0-2-1-3l-3-3c-1-1-2-3-4-5-1-1-1-3-2-4s-.293-2.293-1-3l-2-2c-1-1-.419-2.419-2-4l-3-3c-1-1-3.853-4.173-5-5-1.814-1.307-2-2-3-3s-1-2-2-2-1.293-1.293-2-2c-.707-.707-3-1-5-2s-3-2-5-3-4.293-.293-5-1c-.707-.707-.293-1.293-1-2-.707-.707-1.054-.54-3-1-2.176-.514-6.31-3.337-9-5-1.203-.744-1-2-2-2h-3c-1 0-1.293-.293-2-1-.707-.707-1-1-2-1s-1-1-2-1h-1v-1h-1" stroke-width="4" stroke="red"/>

			<use id="is_active"></use>
		</svg>`;
	}

	static get observedAttributes() {
	    return ['class']; // /* массив имён атрибутов для отслеживания их изменений */
	}

	attributeChangedCallback(name, oldValue, newValue) {
	    // вызывается при изменении одного из перечисленных выше атрибутов
		switch(name){
		  case 'class':
			if(this.lastElementChild) {
				var svg_active = this.lastElementChild.lastElementChild;
					
				if(this.classList.contains('active')){
					  svg_active.setAttribute('href', '#active_star');
				} else {
					  svg_active.removeAttribute('href');
				}
			}
			break;
		}
	}
}

customElements.define('cstm-star', CustomStar);

export class CustomDuty extends HTMLElement {
	connectedCallback() {

		var value =  (this.hasAttribute('value') ? this.getAttribute('value') : "");
		
		this.updateValue(value);
	}

	static get observedAttributes() {
	    return ['value']; // /* массив имён атрибутов для отслеживания их изменений */
	}

	attributeChangedCallback(name, oldValue, newValue) {
	    // вызывается при изменении одного из перечисленных выше атрибутов

		switch(name){
		  case 'value':
			  this.updateValue(newValue);
			  break;
		}
	}

	updateValue(value){
		if(value !== ''){ 
			this.classList.add('cardDuty');

			var class_button = (this.hasAttribute('button') ? this.getAttribute('button') : "hide");
	
			var is_edit = (class_button === 'show');
	
			var class_edit = ( is_edit ? 'contentProperty' : '');

			var name = (this.parentNode && this.parentNode.parentNode && this.parentNode.parentNode.hasAttribute('name') ? this.parentNode.parentNode.getAttribute('name') : 'elems'); 

			var map_data = {
				'goals  ' : '',
				'duties'  : 'y',
			};
			
			var new_name = name.slice(0, -3) + map_data[name]; // goals -> goal, duties -> duty;
	
			// duplicateСontrol.call(li, container, log);
			// this.parentNode.remove();
			this.innerHTML = `
			<li>
				<button class="buttonDuty ${class_button} ${class_edit}" onclick="editPage.call(this.parentNode.parentNode, true, true, true, true, '/assets/frontend/pages/action.php')"> 
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="9 13 12 12">
						<path stroke="#F6F6F6" stroke-linecap="round" d="M10.903 14.904 15.5 19.5m0 0 4.597 4.596M15.499 19.5l4.597-4.596M15.499 19.5l-4.596 4.596"></path>
					</svg>
				</button>
				<span class="contentProperty duty" name="${new_name}" onclick="loadDuty.call(this, this.parentNode.parentNode.parentNode.parentNode.nextElementSibling.firstElementChild);">${value}</span>
			</li>`;
			
			//this.firstElementChild.firstElementChild.value = value;
			//this.firstElementChild.firstElementChild.oninput(); // Обновление размеров
		}
	}
}

customElements.define('cstm-duty', CustomDuty);

export function loadDuty(textarea) {
    var duty = document.getElementById('duty');
    // textarea.value = this.textContent.trim();
	textarea.setAttribute('value', this.textContent.trim());
}

window.loadDuty = loadDuty;

export function duplicateСontrol(container, log) {
    var fsd = false; // fsd - flag_search_dublicap;
    for (const elem of container.children) {
        if (elem.textContent.trim() === this.textContent.trim()) {
            fsd = true;
            break;
        }
    }

    if (!fsd) container.append(this);
    else {
        log.textContent = 'Обнаружен дубликат!';

        var myTimer = setTimeout(function () {
            log.textContent = '';
            clearTimeout(myTimer);
        }, 1000);

        this.remove();
    }
}

export class CustomTextAreaWrapper extends HTMLElement { // HTMLTextAreaElement
	connectedCallback() {

		// $html .= '<textarea class="about contentProperty" oninput="resizeTextarea.call(this);" id="' . $params["for"] . '" style="width: 100%;" readonly>' . $data['about'] . '</textarea>';

		// this.classList.add("about contentProperty");
		// this.oninput = resizeTextarea.call(this);
		// this.readonly = true;
		// this.innerHTML = ``; //  id="' . $params["for"] . '";

		var name     = (this.hasAttribute('name')    ? this.getAttribute('name')    : "about");
		var is_save  = (this.hasAttribute('is_save') ? this.getAttribute('is_save') : false);

		var teg_property = ( is_save ? `name="${name}"`: '');

		// contentProperty;
		
		this.innerHTML = `<textarea class="contentProperty" ${teg_property} oninput="resizeTextarea.call(this);" readonly>${this.innerHTML}</textarea>`;

		// this.insertAdjacentHTML('afterbegin', article_html);

		var  data_html = `
		<svg class="clear-icon hide" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" onclick="this.previousElementSibling.value=''; this.previousElementSibling.oninput();">
		       <use xlink:href="#basket"></use>
		</svg>`;

		this.insertAdjacentHTML('beforeend', data_html);
		
		// this.insertAdjacentHTML('afterbegin', data_html)
	}
}

customElements.define('cstm-textarea-wrapper', CustomTextAreaWrapper); // {extends: 'textarea'}

export class CustomArtefact extends HTMLElement {
	connectedCallback() {
		this.classList.add('contentProperty');
		this.name = 'artefact';
		
		this.innerHTML = `
			<p> Исполняемый файл для Windows</p>
			<svg class="show" xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 17 17">
			  <g clip-path="url(#artifact_svg)">
			    <path fill="#555" d="M8.076 12.963a.6.6 0 0 0 .848 0l3.819-3.819a.6.6 0 1 0-.849-.848L8.5 11.69 5.106 8.296a.6.6 0 0 0-.849.848l3.819 3.819ZM9.1 1a.6.6 0 0 0-1.2 0h1.2Zm7.5 11.539a.6.6 0 1 0-1.2 0h1.2Zm-15 0a.6.6 0 1 0-1.2 0h1.2Zm7.5 0V1H7.9v11.539h1.2Zm6.3 0v2.307h1.2V12.54h-1.2Zm-.554 2.861H2.154v1.2h12.692v-1.2ZM1.6 14.846V12.54H.4v2.307h1.2Zm.554.554a.554.554 0 0 1-.554-.554H.4c0 .969.785 1.754 1.754 1.754v-1.2Zm13.246-.554a.554.554 0 0 1-.554.554v1.2c.969 0 1.754-.785 1.754-1.754h-1.2Z"/>
			  </g>
			  <defs>
			    <clipPath id="artifact_svg">
			      <path fill="#fff" d="M0 0h17v17H0z"/>
			    </clipPath>
			  </defs>
			</svg>
		    <svg class="artefact hide" xmlns="http://www.w3.org/2000/svg" width="25" height="25" onclick="editPage.call(this.parentNode, true, true, true, true, '/assets/frontend/pages/action.php')">
                <use xlink:href="#basket"></use>
            </svg>`;
	}
}

customElements.define('cstm-artefact', CustomArtefact);

export class CustomProperty extends HTMLElement {
	wrapperHtmlSelect(name, data, cur_val){
		// if(!data) data = map_data[name];
		var map_data = {
            "education" :     ["Бакалавриат",  "Магистратура", "Специалитет",  "Аспирантура"], 
            "course":         ["1", "2", "3", "4"],
            "institute":      ["ИИ - Искусственного интеллекта", "ИТ - Информационных технологий", "КБ - комплексной безопасности", "РИ - радиотехнических и телекоммуникационных систем", "..."],
            "division":       ["БК 536 РТУ МИРЭА", "..."],
            "specialization": ["Прикладная математика и информатика", "..."],
            "year":           ["2025", "..."],
            "status":         ["Запуск", "В разработке", "Завершен", "В Архиве", "Идёт набор"]
        };

		var data_map = (map_data.hasOwnProperty(name) ? map_data[name] : data);
		
        var html = `<select class="contentProperty static-mode" name="${name}">`;
            console.log(name);// Debug;
            [...data_map].forEach(value => {
                html += `<option value="${value}" ${( value === cur_val ? 'selected': '')}>${value}</option>`;
            });

            html += `</select>`;
        return html; 
    }
}

export class CustomPropertyProject extends CustomProperty {
	connectedCallback() {
		var text         = this.getAttribute('text');
        var name         = this.getAttribute('name');
        var value        = this.getAttribute('value');

        var data_attr    = this.getAttribute('data');

        var data         = ( data_attr !== null ? JSON.parse(data_attr) : null);
		
		var type         = (this.hasAttribute('type') ? this.getAttribute('type') : "");
		var value        = (this.hasAttribute('value') ? this.getAttribute('value') : "");
		var class_button = (this.hasAttribute('button') ? this.getAttribute('button') : "hide");

		var html_select = '';
		
		var html_data = '';
		var html_select = '';
		switch(type){
			case 'date':
				 html_data = `
				<string style="font-family: \'Helvetica-Light\'; font-weight: lighter; display: flex; align-items: center; font-size: 1vw;">Дата начала:
		            <div style="display: flex; width: fit-content; margin-left: 0.8rem; background-color: #E7E7E7; align-items: center; padding: 5px; border-radius: 6px;">
		                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16">
			                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
		                </svg>
		                <input style="background-color: #E7E7E7;" class="contentProperty" name="premier"      value="${value}"        type="date"         readonly />
		            </div>
		        </string>`;
				break;
			case 'select':
		        html_select = this.wrapperHtmlSelect(name, data, value);
        
		        html_data = `<string>${text}: ${html_select}</string>`;
				break;
		}

		this.innerHTML = `${html_data}`;

	}
}

customElements.define('cstm-property-project', CustomPropertyProject);

export class CustomElem extends HTMLElement {
	connectedCallback() {
		var value        = (this.hasAttribute('value') ? this.getAttribute('value') : "");
		var class_button = (this.hasAttribute('button') ? this.getAttribute('button') : "hide");

		// this.classList.add('contentProperty');

		var name = (this.parentNode.hasAttribute('name') ? this.parentNode.getAttribute('name') : 'elems'); 
		name = name.slice(0, -1); // skills -> skill, elems -> elem 
		
		// this.name = name;
		// this.value = value;
		
		this.innerHTML = `
		<label class="labelTag">${value}
            <button class="buttonTag ${class_button} contentProperty" name="${name}" value="${value}">
                <svg class="stack" xmlns="http://www.w3.org/2000/svg" width="25" height="25" onclick="editPage.call(this.parentNode.parentNode, true, true, true, true, '/assets/frontend/pages/action.php')">
                   <use xlink:href="#remove"></use>
                </svg>
            </button>
        </label>`;
	}
}

export class CustomStack extends CustomElem {
	connectedCallback() {
		super.connectedCallback();
	}
}

customElements.define('cstm-stack', CustomStack);

export class CustomTag extends CustomElem {
	connectedCallback() {
		var style = (this.hasAttribute('style') ? strToBool(this.getAttribute('style')) : false);

		if(style) {
			super.connectedCallback();
		} else {
			var value = (this.hasAttribute('value') ? this.getAttribute('value') : "...");
			var svg_class = (this.hasAttribute('svg') ? this.getAttribute('svg') : "hide");

			this.innerHTML = `
	        <button class="contentProperty tag " name="tag">#${value}
	           <svg class="tag ${svg_class}" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="black" onclick="editPage.call(this.parentNode, true, true, true, true, '/assets/frontend/pages/action.php')">
	                <use xlink:href="#tag"></use>
	            </svg>
	        </button>`;
		}
	}
}

customElements.define('cstm-tag', CustomTag);

export class CustomInput extends HTMLElement {
	connectedCallback() {
		var map_data_type = {
            "skills" :     {'placeholder': 'Поиск'   , 'type': 'input' }, 
            "search":      {'placeholder': 'Поиск'   , 'type': 'input' },
            "add":         {'placeholder': 'Дабавить', 'type': 'input' },
			"tags":        {'placeholder': 'Дабавить', 'type': 'input' },
			"stack":       {'placeholder': 'Дабавить', 'type': 'input' },
			"team":        {'placeholder': 'Поиск'   , 'type': 'input' },
			"screenshots": {'placeholder': 'Дабавить', 'type': 'input' },
			"skills":      {'placeholder': 'Дабавить', 'type': 'input' },
			"goals":       {'placeholder': 'Дабавить' , 'type': 'textarea' },
			"duties":      {'placeholder': 'Дабавить' , 'type': 'textarea' },
        };
		
		var data_for  = (this.hasAttribute('data-for') ? this.getAttribute('data-for') : "add");
		var placeholder = map_data_type[data_for].placeholder;

		this.classList.add('hide');

		var type_input_element = map_data_type[data_for].type;

		var input_elem_html = `<input class="hide" placeholder="${placeholder}" />`;

		var fech = '';
		switch(type_input_element){
			case 'textarea':
				input_elem_html = `<cstm-textarea-wrapper class="" name="${data_for}">...</cstm-textarea-wrapper>`;
				fech = '.firstElementChild';
				break;
		}

		this.innerHTML = `
		${input_elem_html}
		<svg class="${(placeholder === "Поиск" ? "search" : "add" )}" xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
			 onclick="addElement.call(this.parentNode.parentNode.previousElementSibling${fech} , \'${data_for}\', this.previousElementSibling${fech}.value);">
			<use xlink:href="#${(placeholder === "Поиск" ? "search" : "add" )}"></use>
		</svg>`; // href="#search" xlink:href="#search";
	}

	static get observedAttributes() {
	    return ['value']; // /* массив имён атрибутов для отслеживания их изменений */
	}

	attributeChangedCallback(name, oldValue, newValue) {
	    // вызывается при изменении одного из перечисленных выше атрибутов

		switch(name){
		  case 'value':
			  this.updateValue(newValue);
			  break;
		}
	}

	updateValue(value){
		if(value !== ''){ 
			this.firstElementChild.firstElementChild.value = value;
			this.firstElementChild.firstElementChild.oninput(); // Обновление размеров
		}
	}
}

customElements.define('cstm-input', CustomInput);

export class CustomContainer extends HTMLElement {
	connectedCallback() {
		var value     = (this.hasAttribute('value') ? this.getAttribute('value') : "Заголовок");
		var article   = (this.hasAttribute('article') ? this.getAttribute('article') : "Заголовок");

		var action_add  = (this.hasAttribute('action_add') ? this.getAttribute('action_add') : "");
		var action_del  = (this.hasAttribute('action_del') ? this.getAttribute('action_del') : "");

		var is_add    = (this.hasAttribute('add') ? strToBool(this.getAttribute('add')) : false);
		var is_delete = (this.hasAttribute('delete') ? strToBool(this.getAttribute('delete')) : false);;

		var article_html = `<cstm-article value="${article}" add="${is_add}" delete="${is_delete}"  action_add="${action_add}"  action_del="${action_del}"></cstm-article>`;
		
		this.insertAdjacentHTML('afterbegin', article_html);
	}
}

customElements.define('cstm-container', CustomContainer);

export class CustomArticle extends HTMLElement {
	
	connectedCallback() {
		// var type = (this.hasAttribute('type') ? this.getAttribute('type') : "warning");

		var value = (this.hasAttribute('value') ? this.getAttribute('value') : "Заголовок");

		var action_add = (this.hasAttribute('action_add') ? this.getAttribute('action_add') : "");
		var action_del = (this.hasAttribute('action_del') ? this.getAttribute('action_del') : "");

		const converted = value.slice(1, -1);

		var data = converted.split(',');

		var is_add = (this.hasAttribute('add') ? strToBool(this.getAttribute('add')) : false);
		var is_delete = (this.hasAttribute('delete') ? strToBool(this.getAttribute('delete')) : false);;

		var html_add = '';

		// <!--<button class="del-vacancy"  onclick="delElem('vacancy', '{$ACTION}');">удалить вакансию</button>-->
		if(is_add){
			html_add = `
			<div class="div-article">
				<button class="add-vacancy" onclick="window.location.href='${action_add}'">добавить вакансию</button>
			<div>`;
		}
		var html_delete = '';
		if (is_delete){
			html_delete = `
			<div class="div-article">
				<button class="del-vacancy" onclick="window.location.href='${action_del}'">Удалить вакансию</button>
			<div>`;
		}

		var html_head = `<h1><span>//</span> ${value} </h1>`;
		switch(data.length){
			case 1:
				// data = value;
				break;
			case 2:
				html_head = ``;
				break;
			case 3:
				html_head = ``;
				break;
		}
		
		this.innerHTML = `
		<article>
			${html_head}
			${html_delete}
			${html_add}
		</article>`;

	}
}

customElements.define('cstm-article', CustomArticle);

export class CustomNotice extends HTMLElement {
	updateValue(value){
		if(value !== ''){ 
			this.innerHTML = `<p>${value}</p>`;
			this.showAndHide();
		}
	}

	async showAndHide() {
	  const element = this;
  
	  // Показать через 1 секунды
	  // await new Promise(resolve => setTimeout(resolve, 1000));
	  element.style.display = "flex";
	  element.style.opacity = "1";
	
	  // Скрыть через 1 секунду
	  //
	  await new Promise(resolve => setTimeout(resolve, 1000));
	  element.style.opacity = "0";
	  setTimeout(() => element.style.display = "none", 500);
	  //
	}
	
	connectedCallback() {
		var map_data_type = {
            "warning" :  {'name': 'Ошибка',   'color': 'red', 'type': 'email', 'placeholder': '+7(___)___-__-__'}, 
            "note":      {'name': 'Заметка',    'mask': 'mask_site();',  'type': 'url',  'placeholder': '+7(___)___-__-__' },
            "info":      {'name': 'Информация', 'mask': 'mask_phone();', 'type': 'tel',   'placeholder': '+7(___)___-__-__'  }
        };

		var type = (this.hasAttribute('type') ? this.getAttribute('type') : "warning");
		
		var value = (this.hasAttribute('value') ? this.getAttribute('value') : ""); // Hello world!
		
		// this.innerHTML = `<p>${value}</p>`; // style="display: '+ display + ';"

		this.updateValue(value);
		/*
		<button onclick="this.parentNode.remove();" class="notice" type="${type}" > 
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="7 10 20 20">
                <path stroke="#F6F6F6" stroke-linecap="round" d="M10.903 14.904 15.5 19.5m0 0 4.597 4.596M15.499 19.5l4.597-4.596M15.499 19.5l-4.596 4.596"></path>
            </svg>
        </button>
		*/
	}

	static get observedAttributes() {
	    return ['value', 'type']; // /* массив имён атрибутов для отслеживания их изменений */
	}

	attributeChangedCallback(name, oldValue, newValue) {
    // вызывается при изменении одного из перечисленных выше атрибутов

		switch(name){
		  case 'value':
			  this.updateValue(newValue);
			  break;
		}
	}
}

customElements.define('cstm-notice', CustomNotice);



export class CustomSocialNetwork extends HTMLElement {
	connectedCallback() {
		// example get favicon for social site:
		// https://vk.com/favicon.ico;
		// https://telegram.org/favicon.ico;

		// var url_text = (this.hasAttribute('url')  ? this.getAttribute('url') : null);
		
		// this.updateUrl(url_text);
	}

	static get observedAttributes() {
	    return ['url']; // /* массив имён атрибутов для отслеживания их изменений */
	}

	attributeChangedCallback(name, oldValue, newValue) {
		// вызывается при изменении одного из перечисленных выше атрибутов
		
		switch(name){
		case 'url':
			this.updateUrl(newValue);
			break;
		}
	}

	updateUrl(url_text){
		var url      = (url_text ? new URL(url_text) : null) ;
		var origin   = (url_text ? url.origin + "/favicon.ico" : '');

		var is_readonly = (this.hasAttribute('readonly') ? strToBool(this.getAttribute('readonly')) : true);

		var hide_or_show = ( is_readonly ? 'hide' : 'show');
		var show_or_hide = ( is_readonly ? 'show' : 'hide');

		if(this.hasAttribute('readonly')) this.removeAttribute('readonly');
		
		this.innerHTML = `
		<div class="csn1">
			<input class="${hide_or_show}" type="url" value="${url_text}" />
			<div class="csn2">
				<a class="contentProperty ${show_or_hide}" name="social" href="${url_text}">
					<img src="${origin}" alt="social site" width="32" height="32">
				</a>
				<svg class="social ${hide_or_show}" onclick="editPage.call(this, true, true, true, '/assets/frontend/pages/action.php');" width="16" height="16" hidden="true"> 
					<use xlink:href="#basket"></use>
		        </svg>
			</div>
		</div>`;
	}
}

customElements.define('cstm-social-network', CustomSocialNetwork);

export class CustomContact extends HTMLElement {
    wrapperHtmlOption(type,  value){
        var html = `<select class="contentProperty static-mode" name="${name}">`;
            console.log(name);// Debug;
            data.forEach(value => {
                html += `<option value="${value}">${value}</option>`;
            });

            html += `</select>`;
        
        return `<option value="${value}">${value}</option>`; 
    }
    
    connectedCallback() {
        var map_data_type = {
            "email" :  {'name': 'Почта',   'mask': 'mask_email();', 'type': 'email', 'placeholder': 'https://___@___'}, 
            "site":    {'name': 'Сайт',    'mask': 'mask_site();',  'type': 'url',  'placeholder': '+7(___)___-__-__' },
            "phone":   {'name': 'Телефон', 'mask': 'mask_phone();', 'type': 'tel',   'placeholder': '+7(___)___-__-__'  }
        };

        var type        = (this.hasAttribute('type')        ? this.getAttribute('type')       : "email");
        var value       = (this.hasAttribute('value')       ? this.getAttribute('value')       : "...");
		var is_readOnly = (this.hasAttribute('readOnly') ? strToBool(this.getAttribute('readOnly')) : true);

        var name        = map_data_type[type].name;
        var mask        = map_data_type[type].mask;

        var type_input  = map_data_type[type].type;
        var placeholder = map_data_type[type].placeholder;

		// this.classList.add('contentProperty');
		
        this.innerHTML = `
        <span name="contact" class="contact">
			<label></label> 
            <input class="contact contentProperty" name="contact" type="${type_input}" oninput="${mask}"  value="${value}" placeholder="${placeholder}" ${(is_readOnly ? 'readOnly' : '')}/>
            <svg class="${( is_readOnly ? 'hide': 'show')}" onclick="editPage.call(this.parentNode, true, true, true, true, '/assets/frontend/pages/action.php');" width="16" height="16" > 
				<use xlink:href="#basket"></use>
            </svg>
        </span>`; // maxlength="17" // id="${type}" // <input class="head_content shower_hider" style="font-family: \'Helvetica\';" type="text" value="${name}" readOnly> // hidden="true" style="display: block;" // selectTypeContact.call(this); // id="pet-select" // hidden="false"
    }
}

customElements.define('cstm-contact', CustomContact);

export class CustomPropertyProfile extends CustomProperty {
    connectedCallback() {
        var text      = this.getAttribute('text');
        var name      = this.getAttribute('name');
        var value     = this.getAttribute('value');

        var data_attr = this.getAttribute('data');

        var data      = ( data_attr !== null ? JSON.parse(data_attr) : null);

        var map_data = {
            "education" :     ["Бакалавриат",  "Магистратура", "Специалитет",  "Аспирантура"], 
            "course":         ["1", "2", "3", "4"],
            "institute":      ["ИИ - Искусственного интеллекта", "ИТ - Информационных технологий", "КБ - комплексной безопасности", "РИ - радиотехнических и телекоммуникационных систем", "..."],
            "division":       ["БК 536 РТУ МИРЭА", "..."],
            "specialization": ["Прикладная математика и информатика", "..."],
            "year":           ["2025", "..."],
            "status":         ["Запуск", "В разработке", "Завершен", "В Архиве", "Идёт набор"]
        };

        if(!data) data = map_data[name];

        var html_select = this.wrapperHtmlSelect(name, data, value);
        
        this.innerHTML = `<string>${text}: ${html_select}</string>`;
     }
}

customElements.define('cstm-property-profile', CustomPropertyProfile);

export class CustomHeader extends HTMLElement {

	updateUrl(url) {
		var currentPage = window.location.href.split('/').pop().split('.')[0];

        var map_status_color = {
            "profile" : {'width': 214, 'height': 211 }, 
            "project" : {'width': 225, 'height': 221 },
			"vacancy" : {'width': 225, 'height': 221 },
			"projects": {'width': 225, 'height': 221 },
			"vacancies": {'width': 225, 'height': 221 },
			"teams"   : {'width': 225, 'height': 221 }
        };

        var width   = (map_status_color[currentPage].width ? map_status_color[currentPage].width : 225);
        var height  = (map_status_color[currentPage].height ? map_status_color[currentPage].height : 221);

        var url_img =  ( url !== '' ?  url : `href="` +  this.getAttribute('url_temp_img')  + `"`);
        var action  = (this.hasAttribute('action') ? this.getAttribute('action') : '');
		var name    = this.getAttribute('name');

		var data    = (this.hasAttribute('data') ? this.getAttribute('data') : '').split(',');

		var is_edit = this.hasAttribute('action');// (this.hasAttribute('action') ? true : false);

		var page_default = (this.hasAttribute('page-default') ? this.getAttribute('page-default') : '').split(',');

		// this.name = 'avatar';
		// this.classList.add('contentProperty');

		var basket_svg = (currentPage !== 'profile' && is_edit ?   `
			<svg class="editor" width="30" height="30" onclick="deletePage.call(this, \'${action}\'); window.location.href='${page_default}';" > 
		        <use xlink:href="#basket"></use>
		    </svg>`: '');

		var content = `
			<input class="contentProperty avatar" name="${currentPage}"  value="${name}" readonly/>
		` + (is_edit ? `	
				<svg class="editor" width="30" height="30" onclick="editPage.call(this, false, false, false, false, \'${action}\');" > 
			        <use xlink:href="#editor"></use>
			    </svg>
				${basket_svg}`
			: '');

		var context_menu = `
		<div id="1" name="contextMenu" class="contextMenu">
				<span class="contextMenu" >Изменить фотографию
					<input class="contentProperty" name="icon" type="file" accept="image/jpeg,image/png,image/gif" onchange="editPage.call(this, true, true, true, false, \'${action}\')" />
				</span class="contextMenu">
				<span>Удалить фотографию
					<input class="contentProperty for_delete" value="${url_img}" name="icon" type="submit" onclick="window.location.href='${window.page_profile}'" /> <!--editPage.call(this, true, true, true, true, \'${action}\')-->
				</span>
		</div>`; // changeAvatar.call(this, \'change\', \'${url_img}\'); // changeAvatar.call(document.getElementById(\'avatar\'), \'delete\', \'${url_img}\');

		var basket_svg = (url === '' | url === null ?  '': `
			<svg class="basket hide" xmlns="http://www.w3.org/2000/svg" fill="red" stroke="black" width="100" height="101" onclick="showContextMenu.call(this, this.nextElementSibling)">
				<use xlink:href="#basket_2"></use>
				${context_menu}
			</svg>`);

		var head_html = (data === '' || data == null ? '': `
			<article class="title">
				<h1 class="HelveticaProject left" >${data[0]}</h1>
				${( data.length > 1 ? '<p class="VasekProject center">' + data[1] + '</p>': '')}
	            ${( data.length > 2 ? '<h1 class="HelveticaProject right">' + data[2] + '</h1>': '')}
			</article>`);
		
        this.innerHTML = `
		${head_html}
        <article class="avatarTitle">
			<div class="avatarTitle">
				<svg class="avatar" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 ${width} ${height}" >
                    <defs>
                        <pattern id="pattern_${currentPage}" width="1" height="1" patternContentUnits="objectBoundingBox">
                            <use href="#img_${currentPage}" transform="translate(0 -.6) scale(.00174)" />
                        </pattern>
                        <image class="avatar" name="avatar_base" id="img_${currentPage}" width="576" height="1280" ${url_img} />
                    </defs>
                    <use xlink:href="#for_${currentPage}" ></use>
                </svg>
				${basket_svg}
			</div>
            ${content}
		</article>`;
	}
	
    connectedCallback() { 
		var url = this.getAttribute('url');

		this.updateUrl(url);
    }

	static get observedAttributes() {
	    return ['url']; // /* массив имён атрибутов для отслеживания их изменений */
	}

	attributeChangedCallback(name, oldValue, newValue) {
		// вызывается при изменении одного из перечисленных выше атрибутов
		
		switch(name){
		case 'url':
			this.updateUrl(newValue);
			break;
		}
	}
}

customElements.define('cstm-header', CustomHeader);

export function showContextMenu(context_menu) {
    // var contextMenus = document.getElementsByClassName('contextMenu');
    //[...contextMenus].forEach((menu) => {
	var menu = context_menu;
	switch (menu.id) {
		case "1":
			menu.style.display = (this.classList.contains('hide') ? 'none' : (menu.style.display === 'flex' ? 'none' : 'flex'));
			break;
	}
    // });
}

window.showContextMenu = showContextMenu;

export function changeAvatar($is_save, template_name_default_img) { // this - текушая кнопка с id='avatar';
    var currentPage = window.location.href.split('/').pop().split('.')[0];
    //var template_name_default_img = '';
    switch ($is_save) {
        case 'change':
            console.log("loadAvatar( 1 1 1)");
            console.log(this.value);
            break;
        case 'delete':
            console.log("loadAvatar( 1 2 1)");
            var elements = document.getElementsByClassName('avatar');
            var icon_url = (elements.profile.src.split('/').pop() !== template_name_default_img.split('/').pop()
                ? "/assets/frontend/icons/avatars_profiles/" + template_name_default_img.split('/').pop()
                : template_name_default_img);
            if (icon_url !== "") {
                //this.value = {icon_url};
                this.src = icon_url;
                this.textContent = icon_url;

                [...elements].forEach((element) => {
                    element.src = icon_url;
                });
            }
            break;
    }
}

// Добавление функции для озаглавлевания префикса ссылок
Object.defineProperty(String.prototype, 'capitalize', {
  value: function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
  },
  enumerable: false
});

export function getAnotherStatusHide(val){ return ((val.toLowerCase() === 'show') ? 'hide' : 'show') ; }

export class CustomReference extends HTMLElement {
    /*connectedCallback() {
		var url        = (this.hasAttribute('url') ? new URL(this.getAttribute('url')) : '');
		
		this.updateUrl(url);
    }*/

	static get observedAttributes() {
	    return ['url']; // /* массив имён атрибутов для отслеживания их изменений */
	}

	attributeChangedCallback(name, oldValue, newValue) {
		// вызывается при изменении одного из перечисленных выше атрибутов
		
		switch(name){
		case 'url':
			this.updateUrl(newValue);
			break;
		}
	}

	updateUrl(str_url) {

		var url = str_url;
		try {
			url = new URL(str_url);
		} catch (e) {
	        if (e instanceof TypeError) {
	            //error handling procedure...
	        } else {
	            throw e;//cause we dont know what it is or we want to only handle TypeError
	        }
	    }
		
		var data_class = (this.hasAttribute('data-class') ? this.getAttribute('data-class') : 'show');

		this.removeAttribute('data-class');
        
        var host       = ( (url !== '' || url !== null) && url.host ? url.host.split('.')[0].capitalize() : 'Хост');

		// <span  class="${data_class}" >${host}: <a class="contentProperty" name="reference" href="${url}">${url}</a></span>

		var another_class = getAnotherStatusHide(data_class);
        this.innerHTML = `
		<input class="${another_class}" type="url" value="${url}"/>
		<span class=" ${data_class}" >${host}: <a class="reference contentProperty" name="reference" href="${url}">${url}</a></span>
		<svg class="${another_class}" onclick="editPage.call(this, true, true, true, true, '/assets/frontend/pages/action.php');" width="16" height="16"> 
			<use xlink:href="#basket"></use>
        </svg>`; // ${another_class}
	}
}

customElements.define('cstm-reference', CustomReference);

export function strToBool(val){ return (val.toLowerCase() === 'true'); }

// profile:
export class CustomButtonAdd extends HTMLElement {
    connectedCallback() {
		var map_data = {
            "contacts" :   {'isDragDrop': false,  'height': '42px'}, 
            "projects":    {'isDragDrop': false,  'height': '99%' },
			"screenshots": {'isDragDrop': false,  'height': '19pc' },
            "references":  {'isDragDrop': false,  'height': '99%' },
            "feedbacks":   {'isDragDrop': false,  'height': '99%' },
			"socials":     {'isDragDrop': false,  'height': '50%' },
			"artefacts":   {'isDragDrop': false,  'height': '5pc' },
        };

		var data_for         = this.getAttribute('data-for');
		
        var data_click       = this.getAttribute('data-click');
        var is_drag_and_drop = map_data[data_for].isDragDrop; // strToBool(this.getAttribute('is_drag_and_drop'));
        var height           = map_data[data_for].height;

        var svg_bascket = "";

		switch(data_for){
			case 'artefacts':
			case 'screenshots':
				this.innerHTML = `
					<button class="for_load_files add" name="${data_for}" style="height: ${height};" >
						<svg class="add" width="48" height="48">
							<use xlink:href="#add"></use>
						</svg>
						<input class="contentProperty for_load_files" name="${data_for}" type="file" multiple accept="image/jpeg,image/png,image/gif" onchange="editPage.call(this, true, true, true, false, '/assets/frontend/pages/action.php')" />
					</button>`;
				break; // onclick="addElement.call(this.parentNode.parentNode, '${data_for}');"
			case 'references':
			case 'socials':
				this.innerHTML = `
					<button class="hide add" style="height: ${height};" onclick="addElement.call(this.parentNode.parentNode, '${data_for}');">
						<svg class="add" width="48" height="48">
							<use xlink:href="#add"></use>
						</svg>
					</button>`;
				break;
			case 'contacts':
				this.innerHTML = `
					<button class="hide add" style="height: ${height};" onclick="addElement.call(this.parentNode.parentNode, '${data_for}');"> 
						<svg class="add" width="48" height="48">
							<use xlink:href="#add"></use>
						</svg>
					</button>`;
				break;
			case 'feedbacks':
				var fname       = this.getAttribute('fname');
				var lname       = this.getAttribute('lname');
				var icon        = this.getAttribute('icon');

				// add 'previousElementSibling'
				this.innerHTML = `
					<button class="add" style="height: ${height};" onclick="addElement.call(this.parentNode.parentNode.previousElementSibling, '${data_for}', \'\', '${fname}', '${lname}', '${icon}');">
						<svg class="add" width="48" height="48">
							<use xlink:href="#add"></use>
						</svg>
					</button>`;
				break;
			default:
				if(is_drag_and_drop)
					this.innerHTML = ` 
					<div class="container" 
							ongradenter="this.classList.add('active');    window.event.returnValue=false;" 
							ondragleave="this.classList.remove('active'); window.event.returnValue=false;" 
							ondragover="this.classList.add('active');     window.event.returnValue=false;" 
							ondrop="editPage.call(this, true, true, true, false, '/assets/frontend/pages/action.php'); window.event.returnValue=false;"  ">
						<input class="contentProperty" name="files" type="file" id="upload-button" multiple accept="image/*" onchange="editPage.call(this, true, true, true, false, '/assets/frontend/pages/action.php'); window.event.returnValue=false;" />
						<label for="upload-button">
							<i class="fa-solid fa-upload"></i>&nbsp; Choose Or Drop Photos
						</label>
					</div>`;
				else
					this.innerHTML = `
					<form id="upload-container" method="POST" style="height: ${height};" action="/assets/frontend/pages/project.php">
						<button class="add" >
							<svg class="add" width="48" height="48">
								<use xlink:href="#add"></use>
							</svg>
						</button>
					</form>`;
				break;
		}
    }
}

customElements.define('cstm-button-add', CustomButtonAdd);

export class CustomForm  extends HTMLElement {
	 connectedCallback(left_html, right_html) {

		var action     = ( this.hasAttribute('action') ? this.getAttribute('action'): ''); // /assets/frontend/pages/project.php
		var icon       = ( this.hasAttribute('data-icon') ? this.getAttribute('data-icon') : '');
		var name       = ( this.hasAttribute('data-name') ? this.getAttribute('data-name') : '');

		 var id         = this.getAttribute('data-id');
		 var is_right   = (this.hasAttribute('data-is-right') ? this.getAttribute('data-is-right') : '');
		 var display    = ( is_right ? 'flex':  'grid');

		 var rhtml = '';
		 if(is_right === "true"){
			 rhtml += `			
			 <div class="div-right">
				<button class="buttonRefHeadline">
					<input type="hidden" name="id" value="${id}">${name}
				</button>
				${right_html}
			</div>`;
		 }
		 
		return `
		<form class="formProject" method="POST" action="${action}" style="display: ${display};">
			<div class="div-left">
				<button name="id" value="${id}" type="submit" class="image-2">
					<img src="/assets/frontend/icons/${icon}" alt="Submit">
				</button>
				${left_html}
			</div>
			${rhtml}
		</form>`;
	 }
}
export class CustomFormTeam extends CustomForm {
	connectedCallback() {
		var id         = (this.hasAttribute('data-id')       ? this.getAttribute('data-id')       : '');
		var is_right   = (this.hasAttribute('data-is-right') ? this.getAttribute('data-is-right') : '');

		var left_html = '', right_html = '';
		if(is_right === "true"){
			var skills        = this.getAttribute('data-skills');

            var skills_html = '';

			if(skills.length > 0){
				skills_html += `<p>Мои навыки:</p><div class="tgs">`;
				[...skills.split(',')].forEach(skill => {
	                skills_html += `<p>#${skill.replace(' ', "_")}</p>`;
	            });
				skills_html += '</div>';
			} else {
				skills_html += '<p>Навыки отсутствуют</p>';
			}

			var description = ( this.hasAttribute('data-description') ? this.getAttribute('data-description') : '');

			left_html += ``;

			right_html += `
				<p class="projectBody">${description}</p>
				${skills_html}
				<button class="buttonRef"><input type="hidden" name="id" value="${id}">Подробнее →</button>`;
		}

		this.setAttribute('data-icon', 'avatars_profiles/' + this.getAttribute('data-icon'));
		this.setAttribute('action', '/assets/frontend/pages/profile.php');
		
		this.innerHTML = super.connectedCallback(left_html, right_html);
	}
}

customElements.define('cstm-form-team', CustomFormTeam);

export class CustomFormProject extends CustomForm {
    connectedCallback() {
        var map_status_color = {
            "Завершен" :     {'svg_id': 'completed',      'color': 'green' ,                 'bgcolor': 'rgb(73 176 73 / 0.5)' }, 
            "В архиве":      {'svg_id': 'archive',        'color': 'rgba(133, 133, 133, 1)', 'bgcolor': 'rgba(246, 246, 246, 0.6)' },
            "Отменён":       {'svg_id': 'cancelled',      'color': 'rgba(182, 16, 16, 1)',   'bgcolor': 'rgba(255, 219, 222, 0.8)' },
            "В разработке":  {'svg_id': 'in_development', 'color': 'rgba(151, 71, 255, 1)',  'bgcolor': 'rgba(227, 211, 248, 0.8)' },
            "Идёт набор":    {'svg_id': 'recruiting',     'color': 'rgba(51, 102, 255, 1)',  'bgcolor': 'rgba(217, 228, 252, 0.5)' } 
        };

		this.setAttribute('data-icon', 'avatars_projects/' + this.getAttribute('data-icon'));
		this.setAttribute('action', '/assets/frontend/pages/project.php');
        
        var id         = this.getAttribute('data-id'); //
         
        var status     = this.getAttribute('data-status');
        var count_like = this.getAttribute('data-count-like');
		var is_like    = ( this.hasAttribute('data-is-like') ? strToBool(this.getAttribute('data-is-like')) : false) ;
        
		var is_right   = (this.hasAttribute('data-is-right') ? this.getAttribute('data-is-right') : '');

        var bgcolor    = '';
        var color      = '';
        var svg_id     = '';
        if(map_status_color.hasOwnProperty(status)){
            var data = map_status_color[status];
            color    = data.color;
            bgcolor  = data.bgcolor;
            svg_id   = data.svg_id;
        }

        var cls = ''; // ( count_like > 0 && is_like ? 'like-svg': 'not-like-svg'); // not-like-svg
		var elem_href = ( count_like > 0 && is_like ? 'like': 'dislike');
        
        var right_html = '', left_html = '';
        if(is_right === "true"){
            var name        = this.getAttribute('data-name');
            var description = this.getAttribute('data-description');
            var tags        = this.getAttribute('data-tags');

            var tags_html = '';
            [...tags.split(',')].forEach(tag => {
                tags_html += `<p>#${tag.replace(' ', "_")}</p>`;
            });

            var url              = this.getAttribute('data-url');
            var cnt_feedback     = this.getAttribute('data-cnt-feedback');
            var cnt_participants = this.getAttribute('data-cnt-participants');

			left_html = `
				<div class="statusProject" style="background: ${bgcolor};">
                    <svg class="" width="16" height="16" viewBox="0 0 16 16">
                        <use xlink:href="#${svg_id}"></use>
                    </svg>
                    <p class="projectStatus" style="color: ${color};">${status}</p>
                </div>`;

			// <use xlink:href="#heart"></use> // <!-- xlink:href="#heart" -->

            right_html += `
				<p class="projectBody" >${description}</p>
				<div class="tgs"> 
					${tags_html} 
				</div>
				<div class="projectLikeComms"> 
					<div style="display: flex; flex-direction: row; align-items: center;"> 
						<div style="margin-right: 1rem;">
							<svg class="${cls}" id="like-${id}" width="20" height="20" onclick="like.call(this.nextElementSibling, ${id} , \'${url}\')" >
								<use id="heart" href="#${elem_href}"></use>
							</svg>
							<small class="contentProperty" name="likee-${id}">${count_like}</small> 
						</div>
						<div style="margin-right: 1rem;"> 
							<svg class="" width="16" height="16" viewBox="0 0 16 16">
								<use xlink:href="#msg"></use>
							</svg>
							<small class="contentProperty" name="feedback">${cnt_participants}</small>
						</div>
						<div>
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 16 16">
								<use xlink:href="#user"></use>
							</svg>
							<small class="contentProperty" name="participants">${cnt_participants}</small>
						</div>
					</div>
					<button class="buttonRef"><input type="hidden" name="id" value="${id}">Подробнее →</button>
				</div>`;
        }

		this.innerHTML = super.connectedCallback(left_html, right_html);
    }
}

customElements.define('cstm-form-project', CustomFormProject);


// project:
export class CustomContextItem extends HTMLElement {
    connectedCallback() {
        this.innerHTML = ` 
          <button class="contextitem">
                <svg class="contextitem" width="16" height="16" viewBox="0 0 16 16">
                    <use xlink:href="#${this.getAttribute('href')}"></use>
                </svg>
                ${this.getAttribute('text')}
          </button>
        `;
    }
}

customElements.define('cstm-context-item', CustomContextItem);

export class CustomContext extends HTMLElement {

	/*
	<cstm-context-item text="Выделить несколько"  href="check_circle"></cstm-context-item>
    <cstm-context-item text="Закрепить"           href="fix"         ></cstm-context-item>
    <cstm-context-item text="Предоставить доступ" href="share"       ></cstm-context-item>
	*/
    connectedCallback() {
        this.innerHTML = ` 
          <div class="context-menu">
            <cstm-context-item text="Удалить"             href="basket" onclick="editPage.call(this.parentNode.parentNode.parentNode, true, true, true, true, '${window.base_url}')"></cstm-context-item>
          </div>`; // <cstm-context-item text="Сохранить"           href="for_screenshot"></cstm-context-item>
    }
}

customElements.define('cstm-context', CustomContext);

export class CustomScreenShot extends HTMLElement {
    connectedCallback() {
        var src = this.getAttribute('src');

        // this.classList.add('');
        // this.name = "screenshot";
        this.innerHTML = `
        <image name="screenshot" class="contentProperty screenshot image-container" src="${src}" onclick="toggleZoom(event)" />
        <div class="layer">
            <svg class="screenshot" width="24" height="24" viewBox="0 0 16 16">
                <use xlink:href="#for_screenshot"></use>
            </svg>
            <cstm-context></cstm-context>
        <div>`; // aria-hidden="false" display="block" // <button class="screenshot">...</button> // style="box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.08), 0 2px 4px 0 rgba(0, 0, 0, 0.12);"
    }
}

customElements.define('cstm-screenshot', CustomScreenShot);

export function toggleZoom(event) {
	const image = event.target;
	const overlay = document.querySelector('.overlay');
	
	if (!image.classList.contains('zoomed')) {
		// Увеличиваем изображение
		image.classList.add('zoomed');
		// overlay.chi
		overlay.classList.add('active');
		document.body.classList.add('no-scroll');
	} else {
		// Возвращаем в исходное состояние
		closeZoom();
	}
}

window.toggleZoom  = toggleZoom ;

export function closeZoom() {
	const image = document.querySelector('.zoomed');
	const overlay = document.querySelector('.overlay');
	
	if (image) {
		image.classList.remove('zoomed');
		overlay.classList.remove('active');
		document.body.classList.remove('no-scroll');
	}
}

export class Card extends HTMLElement {
  connectedCallback(html, is_btn_edit) {
    var is_readonly = (this.hasAttribute('readonly') ? strToBool(this.getAttribute('readonly')) : false);
    var is_edit     = strToBool(this.getAttribute('edit'));
    var id          = this.getAttribute('data-id');
    var id_num      = id.split('-').slice(-1);
      
    var button_edit = (is_edit && is_btn_edit ?    `<button class="edit show" onclick="editPage.call(this, true, ${!is_readonly}, ${!is_readonly}, false, '/assets/frontend/pages/action.php')">${(!is_readonly ? "завершить редактирование": "редактировать")}</button>` : ""); // onmousedown="console.log('onmousedown 1')" onmouseup="console.log('onmouseup 1')"
    var button_delete = (is_edit ? `<button class="delete" onclick="editPage.call(this, true, true, true, true, '/assets/frontend/pages/action.php')">Удалить</button>` : ""); // ${(is_readonly ? : "редактировать")} // && !is_readonly
    
    var readonly = ( is_readonly ? "readonly": "");

    return `
        <div class="${this.getAttribute('class')}-left"> \
            <svg class="avatar" xmlns="http://www.w3.org/2000/svg" width="128" height="105" fill="none" viewBox="0 0 214 211"> \
                <defs> \
                    <pattern id="${id}" width="1" height="1" patternContentUnits="objectBoundingBox"> \
                        <use href="#img-${id}" transform="translate(0 -.6) scale(.00174)"></use> \
                    </pattern> \
                    <image class="avatar" id="img-${id}" width="576" height="1280" data-name="image.png" href="${this.getAttribute('cur_url')}"></image> \
                </defs> \
                <rect width="197.234" height="197.234" x="8.067" y="10.59" fill="url(#${id})" stroke="#EA5657" stroke-width="3" rx="98.617"></rect> \
                <path stroke="#EA5657" stroke-linecap="round" stroke-width="3" d="M103.532 208.216C144.523 215.784 212 179.207 212 116.144c0-78.829-53.604-110.99-108.468-110.99C48.667 5.153 2 44.251 2 109.837s84.504 104.685 130.541 87.658"></path> \
                <path stroke="#EA5657" stroke-linecap="round" stroke-width="3" d="M2 109.838C7.045 49.298 33.532 16.505 72.63 2"></path> \
            </svg> \
        </div> \
        <div class="${this.getAttribute('class')}-right"> \
            <input class="projectTitle name" value="${this.getAttribute('data-firstname')} ${this.getAttribute('data-lastname')}" readonly> \
            ${html}
            ${button_edit}
            ${button_delete}
        </div>`;
  }
}

export class CustomFeedback extends Card {
  connectedCallback() {
        var is_readonly = (this.getAttribute('readonly') === "true");
        var is_edit = (this.getAttribute('edit') === "true");
        var id = this.getAttribute('data-id');
        var count_stars = this.getAttribute('data_stars');
        var readonly = ( is_readonly ? "readonly": "");
      
        var html = "";
        var html_stars = "";
        for(let i = 5; i > 0; i--){
            html_stars += `
                <input type="radio" id="star-${id}-${i}" name="rating_${id}" value="${i}" ${ ( i == count_stars ? "checked" : "") }>
                <label class="full" for="star-${id}-${i}" title="Awesome - ${i} stars" ${ ( i == count_stars ? "hover" : "") }></label>
            `; // class="${ ( i == count_stars && is_edit ? "contentProperty": "")}"
        }
        
        html = ` 
            <string class="stars">
                <fieldset name="stars" class="rating stars contentProperty" id="${id.split('-').slice(-1)}" disabled="true" onchange="editPage.call(this.parentNode, true, false, true, false, '${window.base_url}' )"> 
                    ${html_stars}
                </fieldset> 
            </string>
            <textarea name="feedback-msg" id="${id}" class="${(is_edit ? 'contentProperty': 'notContentProperty')}" ${readonly}>${this.getAttribute('data-msg')}</textarea>`;

	  // text_area_feedback
        this.innerHTML = super.connectedCallback(html, true);
  }
}

customElements.define('cstm-feedback', CustomFeedback);

export function generateYearSelect(range, title, value, id, is_edit) {
    // Подтвердить вводную цифру
    if (typeof range !== 'number' || range < 0) {
        throw new Error('Invalid digit');
    }
    
    const currentYear = new Date().getFullYear();
    const startYear = (currentYear - 1) - range; // Корректировать диапазон по мере необходимости
    const years = [];
    
    // Собирать годы, заканчивающиеся указанной цифрой
    for (let year = currentYear - 1; year >= startYear; year--) { years.push(year); }
    
    // Создать элемент HTML select
    let html = `<select class="${( is_edit ? 'contentProperty': '')} static-mode" name="${title}" id="${title}-${id}">`; // disabled // static-mode
    var status = ("н/в" == value ? "selected" : "");
    html += `<option value="н/в" ${status}>н/в</option>`;
    years.forEach(year => {
        status = (`${year}` == value ? "selected" : "");
        html += `<option value="${year}" ${status}>${year}</option>`;
    });
    html += '</select>';
    
    return html;
}

export class CustomParticipant extends Card {
    connectedCallback() {
        var from  = this.getAttribute('data_from');
        var to    = this.getAttribute('data_to');
        var role  = this.getAttribute('data_role');
        var id    = this.getAttribute('data-id').split('-')[1];

		var is_edit          = (this.hasAttribute('edit') ? strToBool(this.getAttribute('edit')) : false);
		
        var select_year_from = generateYearSelect(10, 'from', from, id, is_edit);
        var select_year_to   = generateYearSelect(10, 'to', to, id, is_edit);
        
        var html = ` 
        <div style="display: flex; column-gap: 10px; align-items: center;">
            <div style="display: flex; column-gap: 7px; align-items: center;">
                <string>c</string>
                    ${select_year_from}
                <string>по</string>
                    ${select_year_to}
            </div>
           <string styl="matgin-left: 1rem;">|</string>
		   <input class="${(is_edit ? 'contentProperty' : '')}" name="role" id="role-${id}"  type="text"  value="${role}" readOnly>
       </div>`; // old - class="user_data";
    
        this.innerHTML = super.connectedCallback(html, true);// html - содержимое для обёртки классом `Card`, true - наличие и видимость кнопки редактирования полей // false
    }
}
  
customElements.define('cstm-participant', CustomParticipant);