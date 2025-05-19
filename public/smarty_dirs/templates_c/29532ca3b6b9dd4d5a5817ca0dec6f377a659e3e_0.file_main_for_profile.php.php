<?php
/* Smarty version 5.5.0, created on 2025-05-18 12:00:34
  from 'file:C:\xampp\htdocs\portfolio\public/assets/frontend/mains/main_for_profile.php' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.0',
  'unifunc' => 'content_6829afc2e1e7e0_40676944',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '29532ca3b6b9dd4d5a5817ca0dec6f377a659e3e' => 
    array (
      0 => 'C:\\xampp\\htdocs\\portfolio\\public/assets/frontend/mains/main_for_profile.php',
      1 => 1747562432,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6829afc2e1e7e0_40676944 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\portfolio\\public\\assets\\frontend\\mains';
?><section class="section_1">
	<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_header_page')->handle(array(), $_smarty_tpl);?>

	<div class="container pro_1">
		<cstm-container class="base_info" article="Основная информация">
			<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_profile')->handle(array('for'=>"base_properties"), $_smarty_tpl);?>

		</cstm-container>
		<cstm-container class="contacts" article="Контакты">
			<div name="contacts" class="contacts">
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_profile')->handle(array('for'=>"contacts"), $_smarty_tpl);?>

				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_add')->handle(array('for'=>"contacts"), $_smarty_tpl);?>

			</div>
			<div name="socials" class="icons">
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_profile')->handle(array('for'=>"socials"), $_smarty_tpl);?>

				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_add')->handle(array('for'=>"socials"), $_smarty_tpl);?>

			</div>
		</cstm-container>
		<cstm-container class="about" article="О себе">
			<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_profile')->handle(array('for'=>"about"), $_smarty_tpl);?>

		</cstm-container>
		<cstm-container class="skills" article="Навыки">
			<div name="skills" class="skills">
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_profile')->handle(array('for'=>"skills"), $_smarty_tpl);?>

			</div>
			<div class="inp1 show">
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_input')->handle(array('for'=>"skills"), $_smarty_tpl);?>

			</div>
		</cstm-container>
		<cstm-container class="goals" article="Цели">
			<div name="goals  " class="con4">
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_profile')->handle(array('for'=>"goals"), $_smarty_tpl);?>

			</div>
			<div class="inp1 show">
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_input')->handle(array('for'=>"goals",'type'=>"textarea"), $_smarty_tpl);?>

			</div>
		</cstm-container>
		<cstm-container class="materials" article="Мои работы">
			<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_profile')->handle(array('for'=>"references"), $_smarty_tpl);?>

			<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_add')->handle(array('for'=>"references"), $_smarty_tpl);?>

		</cstm-container>
		<cstm-container class="projects" article="Участие в проектах">
			<div name="projects" class="projects"> <!-- Для отделения от заголовка (limit="3" offset="0") -->
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_projects')->handle(array('for'=>"profile",'select'=>"*",'from'=>((string)$_smarty_tpl->getValue('tab_projects')),'orderby'=>"id",'where'=>"author",'author'=>((string)$_smarty_tpl->getValue('id_author'))), $_smarty_tpl);?>

				<?php if ((($tmp = $_smarty_tpl->getValue('access') ?? null)===null||$tmp==='' ? '' ?? null : $tmp)) {?>
					<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_add')->handle(array('for'=>"projects"), $_smarty_tpl);?>

				<?php }?>
			</div>
		</cstm-container>
	</div>
</section><?php }
}
