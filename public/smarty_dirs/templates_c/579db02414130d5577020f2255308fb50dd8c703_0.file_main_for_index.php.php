<?php
/* Smarty version 5.5.0, created on 2025-05-19 13:55:18
  from 'file:C:\projects\project_portfolio\portfolioSerg_3\public/assets/frontend/mains/main_for_index.php' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.0',
  'unifunc' => 'content_682b0e167ab2c4_04182520',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '579db02414130d5577020f2255308fb50dd8c703' => 
    array (
      0 => 'C:\\projects\\project_portfolio\\portfolioSerg_3\\public/assets/frontend/mains/main_for_index.php',
      1 => 1747652114,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_682b0e167ab2c4_04182520 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\projects\\project_portfolio\\portfolioSerg_3\\public\\assets\\frontend\\mains';
?><section id="sctn-1">
	<div class="corners">
		<p class="corner" id="crnr-1">∟</p>
		<p class="corner" id="crnr-2">∟</p>
		<p class="corner" id="crnr-3">∟</p>
		<p class="corner" id="crnr-4">∟</p>
	</div>
	<p class="background">БК 536</p>
	<h2 class="logotype">ПОРТФОЛИО</h2>
	<div id="info-1">
		<p>Здесь представлены лучшие проекты наших талантливых студентов</p>
		<p>↓</p>
	</div>
</section>
<section id="sctn-2" data-aos="fade-up">
	<div class="container-projects">
		<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_article')->handle(array('head1'=>"Представляем вам",'head2'=>"лучшие проекты",'head3'=>"базовой кафедры № 536",'style'=>"display: grid"), $_smarty_tpl);?>

		<div class="pallet-projects">
			<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_projects')->handle(array('select'=>"*",'from'=>((string)$_smarty_tpl->getValue('tab_projects')),'orderby'=>"id",'limit'=>((string)$_smarty_tpl->getValue('SIZE_PAGE_PROJECTS')),'offset'=>"0"), $_smarty_tpl);?>

		</div>
	</div>
	<div class="footer-section">
		<div id="arrowBtnDiv" class="arrowBtn" onclick="window.location.href='<?php echo $_smarty_tpl->getValue('PROJECTS');?>
'" onmouseenter="arrowAnimationEnter(this)" onmouseleave="arrowAnimationLeave(this)">
			<p id="projArrowP" class="ref">Посмотрите все наши проекты</p>
			<svg id="projArrow" class="bi bi-arrow-right" style="color: #F6F6F6; margin: 0 3rem 0 1rem;" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
				<path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
			</svg>
		</div>
	</div>
</section>
<section id="sctn-3" data-aos="fade-up">
	<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_article')->handle(array('head1'=>"А это основные",'svg'=>"1",'head3'=>"исследований и разработки",'class'=>"HelveticaMainWhite",'style'=>"display: grid; width: 85%;"), $_smarty_tpl);?>

	<div class="interestDiv">
		<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_interests')->handle(array(), $_smarty_tpl);?>

	</div>
</section>
<section class="stars_user" id="sctn-4" data-aos="fade-up">
	<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_article')->handle(array('head1'=>"Наши звёзды с",'svg'=>"2",'head3'=>"сияют ярче, чем в Голливуде",'class'=>"HelveticaMain",'style'=>"display: grid; width: 70%;"), $_smarty_tpl);?>

	<div class="container stars">
		<svg class="starBtn prev" onclick="moveStar()">
			<use xlink:href="#prev"></use>
		</svg>
		<div class="carousel-container">
			<div class="carousel">
				<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_stars')->handle(array('select'=>"*",'from'=>((string)$_smarty_tpl->getValue('tag_awesome')),'orderby'=>"id"), $_smarty_tpl);?>

			</div>
		</div>
		<svg class="starBtn next" onclick="moveStar()">
			<use xlink:href="#next"></use>
		</svg>
	</div>
	<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_article')->handle(array('head1'=>"Лучший",'head2'=>"дизайнер",'head3'=>"месяца",'id'=>"bestPeople",'class'=>"VasekMain2",'class2'=>"VasekMainStarAnim",'style'=>"width: 35%; display: grid;"), $_smarty_tpl);?>

</section>
<section id="sctn-5" data-aos="fade-up">
	<div class="headVacancy2">
		<div class="container headVacancy">
			<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_article')->handle(array('head1'=>"Наши открытые",'head2'=>"вакансии в команды",'head3'=>"лучших разработчиков",'class'=>"HelveticaMain",'style'=>"display: grid; width: 70%;"), $_smarty_tpl);?>

		</div>
		<div class="container vacancies-container" style="display: grid;">
			<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_vacancies')->handle(array('style'=>"grid",'select'=>"*",'from'=>((string)$_smarty_tpl->getValue('tab_vacancies')),'orderby'=>"id",'limit'=>((string)$_smarty_tpl->getValue('limit_vacancies')),'offset'=>"0"), $_smarty_tpl);?>

		</div>
	</div>
	<div style="background: #202020; width: 100%;">
		<div class="footerSection">
			<div id="arrowBtnDiv" class="arrowBtn" onclick="window.location.href='<?php echo $_smarty_tpl->getValue('PROJECTS');?>
'" onmouseenter="arrowAnimationEnter(this)" onmouseleave="arrowAnimationLeave(this)">
				<p class="VasekMainWhiteP">Больше вакансий тут</p>
				<svg onclick="window.location.href='<?php echo $_smarty_tpl->getValue('VACANCIES');?>
'" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-right" style="color: #F6F6F6; margin: 0 1rem 0 1rem;" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
				</svg>
			</div>
		</div>
	</div>
</section><?php }
}
