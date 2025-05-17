<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>Портфолио - ВЕГА</title>
		
		<link type="image/x-icon" rel="icon" href="{$FCN}">

		<link type="text/css" rel="stylesheet" href="{$CSS_TOTAL}">
		<link type="text/css" rel="stylesheet" href="{$CSS_MAIN}"> 
		<link type="text/css" rel="stylesheet" href="{$CSS_AOS}">
		<link type="text/css" rel="stylesheet" href="{$CSS_SELECT2}"/>

		<script type="text/javascript" src="{$SJS}"></script>
		<script type="module" src="{$JSX}" ></script> 
		<script type="text/javascript" src="{$JQR}"></script>
		<script type="text/javascript" src="{$AOS}"></script>
		<script type="text/javascript" src="{$SELECT2}"></script>

		<!--<script type="text/javascript" src="{$JSREACT}"></script>-->
		<script type="text/javascript" src="{$JSAPP}"></script>

		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
			<!-- For edit button -->
			<symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" fill="none" id="editor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 26.47h12.353M21.176 4.356a2.948 2.948 0 0 1 2.057-.826 2.95 2.95 0 0 1 2.054.833 2.81 2.81 0 0 1 .853 2.006 2.81 2.81 0 0 1-.846 2.008L8.137 25.13l-5.49 1.34 1.373-5.36L21.176 4.354Z"/>
			</symbol>
			
			<symbol xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16" id="for_screenshot">
				<path fill="#ffffff" d="M13 6.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3m-5 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3m-5 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3"></path>
			</symbol>
			<symbol xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" id="basket">
				<path fill-rule="evenodd" d="M6.837 4H2.75a.75.75 0 0 0 0 1.5h.545l.907 9.248c.051.523.094.96.157 1.314.066.37.163.711.353 1.028a2.9 2.9 0 0 0 1.247 1.131c.334.158.682.222 1.058.25.36.029.797.029 1.323.029h3.32c.526 0 .964 0 1.323-.028.376-.03.724-.093 1.058-.25a2.9 2.9 0 0 0 1.247-1.132c.19-.317.287-.657.353-1.028.063-.355.106-.79.157-1.314l.907-9.248h.545a.75.75 0 0 0 0-1.5h-4.087a3.25 3.25 0 0 0-6.326 0m1.581 0h3.164a1.751 1.751 0 0 0-3.164 0m6.78 1.5H4.802l.89 9.072c.054.56.091.938.143 1.228.05.281.104.422.162.52a1.4 1.4 0 0 0 .603.546c.102.048.248.088.533.11.294.024.673.024 1.235.024h3.262c.562 0 .941 0 1.235-.023.285-.023.43-.063.533-.111a1.4 1.4 0 0 0 .603-.547c.058-.097.112-.238.162-.52.052-.29.09-.667.144-1.226l.89-9.073Zm-2.886 2.002a.75.75 0 0 1 .685.81l-.5 6.003a.75.75 0 0 1-1.494-.124l.5-6.003a.75.75 0 0 1 .81-.686Zm-4.624 0a.75.75 0 0 1 .81.686l.5 6.002a.75.75 0 0 1-1.495.125l-.5-6.003a.75.75 0 0 1 .685-.81" clip-rule="evenodd"></path>
			</symbol>
			<symbol xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" id="share">
				<path fill="currentColor" fill-rule="evenodd" d="M9.764 4.753a.25.25 0 0 1 .402-.198l6.742 5.247a.25.25 0 0 1 0 .395l-6.747 5.25a.25.25 0 0 1-.402-.198v-3.136a.75.75 0 0 0-.75-.75c-2.456 0-4.342.913-5.832 2.197.266-1.454.824-2.577 1.57-3.426 1.066-1.212 2.58-1.941 4.385-2.228a.75.75 0 0 0 .632-.741zm1.324-1.381c-1.15-.895-2.824-.075-2.824 1.38v1.791c-1.81.394-3.434 1.225-4.643 2.6-1.352 1.538-2.117 3.68-2.117 6.445a.75.75 0 0 0 1.329.477c1.362-1.655 3.059-2.942 5.426-3.167v2.35c0 1.456 1.674 2.277 2.823 1.382l6.747-5.25c.9-.7.9-2.061 0-2.762z" clip-rule="evenodd"></path>
			</symbol>
			<symbol xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" id="check_circle">
				<path fill="currentColor" fill-rule="evenodd" d="M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0m1.5 0a8.5 8.5 0 1 1-17 0 8.5 8.5 0 0 1 17 0m-5.22-1.22a.75.75 0 0 0-1.06-1.06L9 10.94 7.78 9.72a.75.75 0 0 0-1.06 1.06l1.75 1.75a.75.75 0 0 0 1.06 0z" clip-rule="evenodd"></path>
			</symbol>
			<symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" id="fix">
				<g fill="none" fill-rule="evenodd">
					<path d="M0 0h20v20H0z"></path>
					<path fill="currentColor" fill-rule="nonzero" d="M11.332 2.604a.75.75 0 0 1 1.266-.384l5.182 5.183a.75.75 0 0 1-.383 1.265l-1.54.308a.3.3 0 0 0-.152.082l-2.463 2.463a.3.3 0 0 0-.086.187l-.297 3.858a1.012 1.012 0 0 1-1.724.638l-3.139-3.139-4.716 4.716a.75.75 0 0 1-1.133-.977l.073-.084 4.715-4.716-3.139-3.138a1.01 1.01 0 0 1-.084-1.336l.084-.095c.171-.171.397-.275.638-.294l3.859-.296a.3.3 0 0 0 .187-.086l2.463-2.464a.3.3 0 0 0 .081-.151Zm1.196 1.668-.033.166c-.07.348-.24.667-.491.918L9.54 7.819a1.8 1.8 0 0 1-1.133.521l-2.801.216 5.837 5.837.216-2.8c.03-.374.174-.729.413-1.015l.108-.118 2.464-2.463c.25-.251.57-.422.918-.492l.165-.033z"></path>
				</g>
			</symbol>

			<!--For project form-->
			<symbol xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16" id="completed">
				<path stroke="#0E7B43" stroke-linecap="round" d="M5 8.5 7.5 11 12 6.5m3 2a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0Z"/>
			</symbol>
			<symbol xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16" id="archive">
				<path stroke="#858585" stroke-linecap="round" stroke-linejoin="round" d="M16 13.556c0 .383-.158.75-.44 1.02A1.53 1.53 0 0 1 14.5 15h-12a1.53 1.53 0 0 1-1.06-.423A1.418 1.418 0 0 1 1 13.556V3.444c0-.383.158-.75.44-1.02A1.53 1.53 0 0 1 2.5 2h3.75l1.5 2.167h6.75c.398 0 .78.152 1.06.423.282.27.44.638.44 1.021v7.945Z"/>
			</symbol>
			<symbol xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16" id="cancelled">
				<path stroke="#B61010" stroke-linecap="round" d="M.904.903 5.5 5.5m0 0 4.596 4.596M5.5 5.5 10.096.903M5.5 5.5.904 10.096"/>
			</symbol>
			<symbol xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16" id="in_development">
				<path stroke="#9747FF" stroke-linecap="round" stroke-linejoin="round" d="m13 11 3-2.5L13 6M4 6 1 8.5 4 11m3 1.729 3.078-8.458"/>
			</symbol>
			<symbol xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16" id="recruiting">
				<path stroke="#36F" stroke-linecap="round" d="M8.5 9.571c2.393 0 4.333-1.918 4.333-4.285S10.893 1 8.5 1C6.107 1 4.167 2.919 4.167 5.286c0 2.367 1.94 4.285 4.333 4.285Zm0 0C4.91 9.571 2 12.45 2 16m6.5-6.429c3.59 0 6.5 2.879 6.5 6.429"/>
			</symbol>
			
			<!--For project form right-->
			<symbol xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16" id="heart"></symbol>
			<symbol xmlns="http://www.w3.org/2000/svg" fill="black" viewBox="0 0 16 16" id="msg">
				<path d="M2 1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h9.586a2 2 0 0 1 1.414.586l2 2V2a1 1 0 0 0-1-1zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"></path>
                <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"></path>
			</symbol>
			<symbol xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16" id="user">
				<path stroke="#202020" stroke-linecap="round" d="M12 13.513c3.379 0 6.118-2.709 6.118-6.05 0-3.342-2.74-6.05-6.118-6.05-3.379 0-6.118 2.708-6.118 6.05 0 3.341 2.74 6.05 6.118 6.05Zm0 0c-5.068 0-9.176 4.063-9.176 9.076M12 13.513c5.068 0 9.177 4.063 9.177 9.076"/>
			</symbol>

			<symbol xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 32 32" id="add">
				<path stroke="#777777" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1.444 17h31.111M17 1v31.111"/>  
			</symbol>

			<symbol xmlns="http://www.w3.org/2000/svg" fill="black" viewBox="0 0 24 24" id="upload">
                  <path fill="none" d="M0 0h24v24H0z"/> 
                  <path d="M4 19h16v-7h2v8a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-8h2v7zM14 9v6h-4V9H5l7-7 7 7h-5z"/> 
			</symbol>

			<!-- For header -->
			<symbol xmlns="http://www.w3.org/2000/svg"  id="for_profile">
                <rect width="197.234" height="197.234" x="8.067" y="10.59" fill="url(#pattern_profile)" stroke="#EA5657" stroke-width="3" rx="98.617"/>
                <path stroke="#EA5657" stroke-linecap="round" stroke-width="3" d="M103.532 208.216C144.523 215.784 212 179.207 212 116.144c0-78.829-53.604-110.99-108.468-110.99C48.667 5.153 2 44.251 2 109.837s84.504 104.685 130.541 87.658"/>
                <path stroke="#EA5657" stroke-linecap="round" stroke-width="3" d="M2 109.838C7.045 49.298 33.532 16.505 72.63 2"/>
			</symbol>
			<symbol xmlns="http://www.w3.org/2000/svg" id="for_project">
                <rect width="210" height="210" x="5" y="6" fill="url(#pattern_project)" stroke="#EA5657" stroke-width="3" rx="10"/>
                <path stroke="#EA5657" stroke-linecap="round" stroke-width="3" d="M208 6s-45 13-106 1.5C61.992-.043 35.965 2.309 22.789 4.82c-6.537 1.246-11.113 6.559-12.323 13.102C7.064 36.318.713 75.31 1.999 104c1.88 41.926 7 103.999 7 103.999M20 218.5s66-16 106-6c38.463 9.616 65.84 6.023 79.215 2.83 5.967-1.425 10.208-6.292 11.468-12.297 3.749-17.87 10.32-57.642 2.817-89.533-9.612-40.852 0-94.5 0-94.5"/>
			</symbol>

			<!-- For contacts -->
			<symbol xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" id="basket">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m25.582 43.93 5.542 33.334a8.334 8.334 0 0 0 8.334 6.958H60.79a8.334 8.334 0 0 0 8.333-6.958l5.542-33.334a8.334 8.334 0 0 0-8.334-9.708h-32.54a8.333 8.333 0 0 0-8.208 9.708Z"></path>
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M39.999 38.389V27.555a10.042 10.042 0 0 1 10-10 10.042 10.042 0 0 1 10 10V38.39m-4.125 14.957-11.75 11.75m11.75 0-11.75-11.75"></path>
			</symbol>

			<symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="none" id="basket_2">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="m25.582 43.93 5.542 33.334a8.334 8.334 0 0 0 8.334 6.958H60.79a8.334 8.334 0 0 0 8.333-6.958l5.542-33.334a8.334 8.334 0 0 0-8.334-9.708h-32.54a8.333 8.333 0 0 0-8.208 9.708Z"/>
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M39.999 38.389V27.555a10.042 10.042 0 0 1 10-10 10.042 10.042 0 0 1 10 10V38.39m-4.125 14.957-11.75 11.75m11.75 0-11.75-11.75"/>
			</symbol>
			
			<symbol xmlns="http://www.w3.org/2000/svg" viewBox="6 9 20 20" fill="none" id="tag">
				<path stroke="#777777" stroke-linecap="round" d="M10.903 14.904 15.5 19.5m0 0 4.597 4.596M15.499 19.5l4.597-4.596M15.499 19.5l-4.596 4.596"></path>
			</symbol>

			<symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15" fill="none" id="search">
				<path stroke="#858585" stroke-linecap="round" d="M10.698 10.59 14 14m-1.91-7.274c0 3.163-2.483 5.727-5.545 5.727C3.482 12.453 1 9.889 1 6.726 1 3.564 3.482 1 6.545 1c3.062 0 5.544 2.564 5.544 5.726Z"/>
			</symbol>
			<symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15" fill="none" id="add2">
				<path stroke="#858585" stroke-linecap="round" d="M10.698 10.59 14 14m-1.91-7.274c0 3.163-2.483 5.727-5.545 5.727C3.482 12.453 1 9.889 1 6.726 1 3.564 3.482 1 6.545 1c3.062 0 5.544 2.564 5.544 5.726Z"/>
			</symbol>

			<symbol xmlns="http://www.w3.org/2000/svg" viewBox="7 10 20 20" fill="none" id="remove">
				 <path stroke="#F6F6F6" stroke-linecap="round" d="M10.903 14.904 15.5 19.5m0 0 4.597 4.596M15.499 19.5l4.597-4.596M15.499 19.5l-4.596 4.596"></path>
			</symbol>

			<!-- For index.php-->
			<symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="%23fff" id="prev">
				<path d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
			</symbol>

			<symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="%23fff" id="next">
				<path d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
			</symbol>
		</svg>
	</head>
	<body>
		<div class="layout">
			<header>
				<a class="logo" href="{$INDEX}">
					<h1 class="font-logo">ПОРТФОЛИО</h1>
				</a>
				<div class="menu">
					<nav class="nav">
						<ul>
							<li>
								<a href="{$PROJECTS}">Проекты</a>
							</li>
							<li>
								<a href="{$TEAMS}">Команды</a>
							</li>
							<li>
								<a href="{$VACANCIES}">Вакансии</a>
							</li>
						</ul>
					</nav>
					<div>
						{if isset($icon)|default}
							<div class="dropdownProfile">
							<a href="" class="dropbtnProfile">
								<img id="profile" class="avatar" src="{$icon}" />
							</a>
								<div class="dropdown-content">
									<a href="#" onclick="window.location.href='{$PROFILE}'">Мой профиль</a>
									<a href="#" onclick="logout('{$ACTION}');">Выход</a>
								</div>
							</div>
						{else}
							<div>
								<a target="iframe-auth-reg" onclick="create_iframe_authorization_registration();" href="{$HFR}" >Вход</a> <!-- <?php echo AUTH::PATH->value; ?> href="./frames/authorization.html" -->
							</div>
						{/if}
					</div> 						<!--{date_now}-->
				</div>
			</header>
			<main>
				{include file="$MAIN"}
			</main>
			<footer>
				<a href="index.html" class="logo d-flex align-items-center">
					<span class="sitename" style="text-align: start; font-family: 'Lack', arial; font-size: 28px; color:rgb(255, 255, 255); margin: 0; font-weight: normal;">Контакты</span>
				</a>
				<p style="text-align: start;font-family: 'Helvetica', arial;font-size: 16px;color:rgb(240, 240, 240);/* margin: 0 0 3rem 1rem; */font-weight: 100;">
					+7 (499) 215-65-65 доб. 2404  
				</p>
				<a style="color: white;"> vega@mirea.ru </a>
			</footer>
			
			<cstm-notice type="warning"></cstm-notice> <!-- For notice -->
		</div>
	</body>
	<!-- script's code -->
	<script>
		AOS.init();
	</script>
</html>