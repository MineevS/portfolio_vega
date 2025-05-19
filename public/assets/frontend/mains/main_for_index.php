<section id="sctn-1">
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
		{query_article head1="Представляем вам" head2="лучшие проекты" head3="базовой кафедры № 536" style="display: grid"}
		<div class="pallet-projects">
			{query_projects select="*" from="$tab_projects" orderby="id" limit="$SIZE_PAGE_PROJECTS" offset="0"}
		</div>
	</div>
	<div class="footer-section">
		<div id="arrowBtnDiv" class="arrowBtn" onclick="window.location.href='{$PROJECTS}'" onmouseenter="arrowAnimationEnter(this)" onmouseleave="arrowAnimationLeave(this)">
			<p id="projArrowP" class="ref">Посмотрите все наши проекты</p>
			<svg id="projArrow" class="bi bi-arrow-right" style="color: #F6F6F6; margin: 0 3rem 0 1rem;" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
				<path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
			</svg>
		</div>
	</div>
</section>
<section id="sctn-3" data-aos="fade-up">
	{query_article head1="А это основные" svg="1" head3="исследований и разработки" class="HelveticaMainWhite" style="display: grid; width: 85%;"}
	<div class="interestDiv">
		{query_interests}
	</div>
</section>
<section class="stars_user" id="sctn-4" data-aos="fade-up">
	{query_article head1="Наши звёзды с" svg="2" head3="сияют ярче, чем в Голливуде" class="HelveticaMain" style="display: grid; width: 70%;"}
	<div class="container stars">
		<svg class="starBtn prev" onclick="moveStar()">
			<use xlink:href="#prev"></use>
		</svg>
		<div class="carousel-container">
			<div class="carousel">
				{query_stars select="*" from="$tag_awesome" orderby="id"}
			</div>
		</div>
		<svg class="starBtn next" onclick="moveStar()">
			<use xlink:href="#next"></use>
		</svg>
	</div>
	{query_article head1="Лучший" head2="дизайнер" head3="месяца" id="article-item" class="VasekMain2" class2="VasekMainStarAnim" style="width: 35%; display: grid;" id="bestPeople"}
</section>
<section id="sctn-5" data-aos="fade-up">
	<div class="headVacancy2">
		<div class="container headVacancy">
			{query_article head1="Наши открытые" head2="вакансии в команды" head3="лучших разработчиков" class="HelveticaMain" style="display: grid; width: 70%;"}
		</div>
		<div class="container vacancies-container" style="display: grid;">
			{query_vacancies style="grid" select="*" from="$tab_vacancies" orderby="id" limit="$limit_vacancies" offset="0"}
		</div>
	</div>
	<div style="background: #202020; width: 100%;">
		<div class="footerSection">
			<div id="arrowBtnDiv" class="arrowBtn" onclick="window.location.href='{$PROJECTS}'" onmouseenter="arrowAnimationEnter(this)" onmouseleave="arrowAnimationLeave(this)">
				<p class="VasekMainWhiteP">Больше вакансий тут</p>
				<svg onclick="window.location.href='{$VACANCIES}'" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-right" style="color: #F6F6F6; margin: 0 1rem 0 1rem;" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
				</svg>
			</div>
		</div>
	</div>
</section>