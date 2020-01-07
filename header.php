<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title('|', true, 'right'); ?></title>	
	<?php wp_head(); ?>
	<link rel="shortcut icon" 
		href="<?php echo OL_THEME_URL; ?>/images/favicon.png" 
		type="image/x-icon" />
</head>
<body>
<div class="layout">	
	<header id="header">
		<div class="container">
			<div class="logo">
				<h1>
					<a href="<?php echo home_url('/'); ?>" class="site_title"><?php bloginfo('name') ?></a>
				</h1>
	 		</div>
		</div>
	</header><!-- /header -->
	<nav id="nav">
		<div class="container">
				<?php echo theme_front_menu('primary'); ?>				
		</div>								
	</nav>
	<main id="main">