<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!--Обязательно указываем размеры, иначе не будет смены @media -->
		
		<!--{0} Название сайта -->
		<title>Портфолио - ВЕГА</title>
		
		<!--{1} Иконка сайта -->
		<link  href="<?php echo TOTAL::FCN->value; ?>" type="image/x-icon" 	rel="icon">
		
		<!--{2} Стили-->
		<link  href="<?php echo INDEX::CSS->value; ?>" type="text/css" 	rel="stylesheet">
		
		<!--{3} Скрипты -->
		<script src="<?php echo INDEX::JSX->value; ?>" type="text/javascript"></script>
		<script src="<?php echo TOTAL::JQR->value; ?>" type="text/javascript"></script>
	</head>
	<body>
		<div class="layout">
			<header>
				<a class="logo"><h1 class="font-logo">ПОРТФОЛИО</h1></a>
				<div class="menu">
					<nav class="nav">
						<ul>
							<li>
								<a href="">Проекты</a>
							</li>
							<li>
								<a href="">Команды</a>
							</li>
							<li>
								<a href="">Вакансии</a>
							</li>
						</ul>
					</nav>
					<div>
						<div>
							<a target="iframe-auth-reg" onclick="create_iframe_authorization_registration();" href="<?php echo AUTH::PATH->value; ?>" >Вход</a>
						</div>
					</div>
				</div>
			</header>
			<main>

			</main>
			<footer>
			
			</footer>
		</div>
	</body>
	<!-- script's code -->
	<script>
		AOS.init();
	</script>
</html>