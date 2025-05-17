<section class="section_1">
	{query_header_page}
	<div class="container pro_1">
		<cstm-container class="properties" article="Основная информация">
			{query_properties_project for="properties"}
		</cstm-container>
		<cstm-container class="references" article="Ссылки">
			{query_properties_project for="references"}
			{query_properties_add     for="references"}
		</cstm-container>
		<cstm-container class="about" article="О проекте">
			{query_properties_project for="description"}
		</cstm-container>
		<cstm-container class="tags" article="Теги">
			<div name="tags" class="container contentProperty tgs">
				{query_properties_project for="tags"}
			</div>
			<div class="container tgs2">
				{query_input for="tags" type="span"}
			</div>
		</cstm-container>
		<cstm-container class="stack" article="Стек технологий">
			<div name="stack "  class="contentProperty container stck">
				{query_properties_project for="stack"}
			</div>
			<div class="stck2 hide">
				{query_input for="stack"}
			</div>
		</cstm-container>
		<cstm-container class="team" article="Команда проекта">
			<div class="container team">
				{query_properties_project for="team"}
			</div>
			<div class="display team2">
				{query_input for="team"}
			</div>
		</cstm-container>
		<cstm-container class="screenshots" article="Скриншоты">
			<div class="container screenshots1">
				{query_properties_project for="screenshots"}
				{query_properties_add     for="screenshots"}
			</div>
			<div class="overlay" onclick="closeZoom()"></div> <!-- For zoom screenshots -->
		</cstm-container>
		<cstm-container class="feedbacks " article="Отзывы">
			<div class="container feedbacks1 scroll-container">
				{query_properties_project for="feedback"}
			</div>
			{if $access|default}
				<div class="container feedbacks2">
					{query_properties_add for="feedbacks"}
				</div>
			{/if}
		</cstm-container>
		<cstm-container class="artefacts" article="Артефакты">
			<div class="container artefacts1">
				{query_properties_project for="artefacts"}
			</div>
			<div class="container artefacts2">
				{if $access|default}
					{query_properties_add for="artefacts"}
				{/if}
			</div>
		</cstm-container>
		<cstm-container class="vacancy" article="Вакансии" add='{$access ? "true" : "false" }' delete="false" action_add="/assets/frontend/pages/vacancy.php">
			{if $project_id|default}
				{query_vacancies select="*" from="$tab_vacancies" orderby="id" where="project_id" project_id="$project_id"}
			{/if}
		</cstm-container>
	</div>
</section>