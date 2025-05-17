<section class="section_1">
	{query_header_page data="Вакансия, на проект"}
	<div class="container pro_1">
		<cstm-container class="speciality" article="Специальность">
			{query_properties_vacancy for="speciality"}
	    </cstm-container>
		<cstm-container class="about" article="Описание">
			{query_properties_vacancy for="about"}
	    </cstm-container>
		<cstm-container class="tags" article="Теги">
			<div name="tags" class="container contentProperty tgs">
				{query_properties_vacancy for="tags"}
			</div>
			{if $access|default}
				<div class="container tgs2">
					{query_input for="tags" type="span"}
				</div>
			{/if}
	    </cstm-container>
		<cstm-container class="dutys" article="Обязанности">
			<div name="duties" class="container contentProperty dts">
				{query_properties_vacancy for="duties"}
			</div>
			{if $access|default}
				<div class="container dts2">
					{query_input for="duties" type="text"}
				</div>
			{/if}
	    </cstm-container>
	</div>
</section>