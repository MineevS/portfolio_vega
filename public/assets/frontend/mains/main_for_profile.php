<section class="section_1">
	{query_header_page}
	<div class="container pro_1">
		<cstm-container class="base_info" article="Основная информация">
			{query_properties_profile for="base_properties"}
		</cstm-container>
		<cstm-container class="contacts" article="Контакты">
			<div name="contacts" class="contacts">
				{query_properties_profile for="contacts"}
				{query_properties_add     for="contacts"}
			</div>
			<div name="socials" class="icons">
				{query_properties_profile for="socials"}
				{query_properties_add     for="socials"}
			</div>
		</cstm-container>
		<cstm-container class="about" article="О себе">
			{query_properties_profile for="about"}
		</cstm-container>
		<cstm-container class="skills" article="Навыки">
			<div name="skills" class="skills">
				{query_properties_profile for="skills"}
			</div>
			<div class="inp1 show">
				{query_input for="skills"}
			</div>
		</cstm-container>
		<cstm-container class="goals" article="Цели">
			<div name="goals  " class="con4">
				{query_properties_profile for="goals"}
			</div>
			<div class="inp1 show">
				{query_input for="goals" type="textarea"}
			</div>
		</cstm-container>
		<cstm-container class="materials" article="Мои работы">
			{query_properties_profile for="references"}
			{query_properties_add     for="references"}
		</cstm-container>
		<cstm-container class="projects" article="Участие в проектах">
			<div name="projects" class="projects"> <!-- Для отделения от заголовка (limit="3" offset="0") -->
				{query_projects for="profile" select="*" from="$tab_projects" orderby="id" where="author" author="$id_author"}
				{if $access|default}
					{query_properties_add for="projects"}
				{/if}
			</div>
		</cstm-container>
	</div>
</section>