<!doctype html>
<html lang='en'>
<head>
	<meta charset='utf-8' />
	<title><?=$title?></title>
	<link rel='stylesheet' href='<?=$stylesheet?>' />
</head>
<body>
	<div id='wrap-header'>
		<header id='header'>
			<div id='login-menu'>
				<?=login_menu()?>
			</div>
			<div id='banner'>
				<a href='<?=base_url()?>'>site-logo</a>
				<p class='site-title'><?=$header?></p>
				<p class='site-slogan'><?=$slogan?></p>
			</div>	
		</header>
	</div>	
	<div id='wrap-main'>
		<div id='main' role='main'>
			<?=get_messages_from_session()?>
			<?=@$main?>
			<?=render_views()?>
		</div>
	</div>
	<div id='wrap-footer'>
		<footer id='footer'>
			<?=$footer?>
			<?=get_debug()?>
		</footer>
	</div>
</body>
</html>