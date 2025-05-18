<?php
/* Smarty version 5.4.3, created on 2025-05-17 13:42:37
  from 'file:C:\projects\portfolio_serg\portfolio\public/assets/frontend/mains/main_for_project.php' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.3',
  'unifunc' => 'content_6828681d50aab6_67123323',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8e3baa76ecf4a0c6e5f314552c3400fb740a99dc' => 
    array (
      0 => 'C:\\projects\\portfolio_serg\\portfolio\\public/assets/frontend/mains/main_for_project.php',
      1 => 1747478347,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6828681d50aab6_67123323 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\projects\\portfolio_serg\\portfolio\\public\\assets\\frontend\\mains';
?><section class="section_1">
	<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_header_page')->handle(array(), $_smarty_tpl);?>

	<div class="container pro_1">
		<cstm-container class="properties" article="Основная информация">
			<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_project')->handle(array('for'=>"properties"), $_smarty_tpl);?>

		</cstm-container>
		<cstm-container class="references" article="Ссылки">
			<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_project')->handle(array('for'=>"references"), $_smarty_tpl);?>

			<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_add')->handle(array('for'=>"references"), $_smarty_tpl);?>

		</cstm-container>
		<cstm-container class="about" article="О проекте">
			<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_project')->handle(array('for'=>"description"), $_smarty_tpl);?>

		</cstm-container>
		<cstm-container class="tags" article="Теги">
			<div name="tags" class="container contentProperty tgs">
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_project')->handle(array('for'=>"tags"), $_smarty_tpl);?>

			</div>
			<div class="container tgs2">
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_input')->handle(array('for'=>"tags",'type'=>"span"), $_smarty_tpl);?>

			</div>
		</cstm-container>
		<cstm-container class="stack" article="Стек технологий">
			<div name="stack "  class="contentProperty container stck">
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_project')->handle(array('for'=>"stack"), $_smarty_tpl);?>

			</div>
			<div class="stck2 hide">
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_input')->handle(array('for'=>"stack"), $_smarty_tpl);?>

			</div>
		</cstm-container>
		<cstm-container class="team" article="Команда проекта">
			<div class="container team">
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_project')->handle(array('for'=>"team"), $_smarty_tpl);?>

			</div>
			<div class="display team2">
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_input')->handle(array('for'=>"team"), $_smarty_tpl);?>

			</div>
		</cstm-container>
		<cstm-container class="screenshots" article="Скриншоты">
			<div class="container screenshots1">
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_project')->handle(array('for'=>"screenshots"), $_smarty_tpl);?>

				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_add')->handle(array('for'=>"screenshots"), $_smarty_tpl);?>

			</div>
			<div class="overlay" onclick="closeZoom()"></div> <!-- For zoom screenshots -->
		</cstm-container>
		<cstm-container class="feedbacks " article="Отзывы">
			<div class="container feedbacks1 scroll-container">
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_project')->handle(array('for'=>"feedback"), $_smarty_tpl);?>

			</div>
			<?php if ((($tmp = $_smarty_tpl->getValue('access') ?? null)===null||$tmp==='' ? '' ?? null : $tmp)) {?>
				<div class="container feedbacks2">
					<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_add')->handle(array('for'=>"feedbacks"), $_smarty_tpl);?>

				</div>
			<?php }?>
		</cstm-container>
		<cstm-container class="artefacts" article="Артефакты">
			<div class="container artefacts1">
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_project')->handle(array('for'=>"artefacts"), $_smarty_tpl);?>

			</div>
			<div class="container artefacts2">
				<?php if ((($tmp = $_smarty_tpl->getValue('access') ?? null)===null||$tmp==='' ? '' ?? null : $tmp)) {?>
					<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_add')->handle(array('for'=>"artefacts"), $_smarty_tpl);?>

				<?php }?>
			</div>
		</cstm-container>
		<cstm-container class="vacancy" article="Вакансии" add='<?php echo $_smarty_tpl->getValue('access') ? "true" : "false";?>
' delete="false" action_add="/assets/frontend/pages/vacancy.php">
			<?php if ((($tmp = $_smarty_tpl->getValue('project_id') ?? null)===null||$tmp==='' ? '' ?? null : $tmp)) {?>
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_vacancies')->handle(array('select'=>"*",'from'=>((string)$_smarty_tpl->getValue('tab_vacancies')),'orderby'=>"id",'where'=>"project_id",'project_id'=>((string)$_smarty_tpl->getValue('project_id'))), $_smarty_tpl);?>

			<?php }?>
		</cstm-container>
	</div>
</section><?php }
}
