<?php
/* Smarty version 5.4.3, created on 2025-05-11 11:34:20
  from 'file:C:\projects\portfolio_serg\portfolio\public/assets/frontend/mains/main_for_vacancy.php' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.3',
  'unifunc' => 'content_6820610c9288a2_43824918',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '67ec70a16e98e9c1a0cc40944667e3371483e028' => 
    array (
      0 => 'C:\\projects\\portfolio_serg\\portfolio\\public/assets/frontend/mains/main_for_vacancy.php',
      1 => 1746952333,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6820610c9288a2_43824918 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\projects\\portfolio_serg\\portfolio\\public\\assets\\frontend\\mains';
?><section class="section_1">
	<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_header_page')->handle(array('data'=>"Вакансия, на проект"), $_smarty_tpl);?>

	<div class="container pro_1">
		<cstm-container class="speciality" article="Специальность">
			<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_vacancy')->handle(array('for'=>"speciality"), $_smarty_tpl);?>

	    </cstm-container>
		<cstm-container class="about" article="Описание">
			<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_vacancy')->handle(array('for'=>"about"), $_smarty_tpl);?>

	    </cstm-container>
		<cstm-container class="tags" article="Теги">
			<div name="tags" class="container contentProperty tgs">
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_vacancy')->handle(array('for'=>"tags"), $_smarty_tpl);?>

			</div>
			<?php if ((($tmp = $_smarty_tpl->getValue('access') ?? null)===null||$tmp==='' ? '' ?? null : $tmp)) {?>
				<div class="container tgs2">
					<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_input')->handle(array('for'=>"tags",'type'=>"span"), $_smarty_tpl);?>

				</div>
			<?php }?>
	    </cstm-container>
		<cstm-container class="dutys" article="Обязанности">
			<div name="duties" class="container contentProperty dts">
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_properties_vacancy')->handle(array('for'=>"duties"), $_smarty_tpl);?>

			</div>
			<?php if ((($tmp = $_smarty_tpl->getValue('access') ?? null)===null||$tmp==='' ? '' ?? null : $tmp)) {?>
				<div class="container dts2">
					<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_input')->handle(array('for'=>"duties",'type'=>"text"), $_smarty_tpl);?>

				</div>
			<?php }?>
	    </cstm-container>
	</div>
</section><?php }
}
