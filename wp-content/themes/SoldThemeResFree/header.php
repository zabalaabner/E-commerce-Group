<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '-', true, 'right' ); ?></title>
	<?php wp_head(); ?>
</head>
<?php $body_class = array('woocommerce'); ?>
<body <?php body_class($body_class); ?>>
	<header id="head">
		<div class="head-nav">
			<div class="container">
				<?php wp_nav_menu(array('theme_location' => 'header-menu', 'container_class' => 'main-nav' )); ?>
			</div><!-- container -->
		</div><!-- head-nav -->
		<div class="logo-area">
			<div class="container">
				<div class="logo">
					<?php echo (dess_setting('dess_logo') != '' ? '<a href="'.home_url().'"><img src="'.dess_setting('dess_logo').'" class="logo" alt="logo" /></a>': '<a href="'.home_url().'"><img src="'.esc_url( get_stylesheet_directory_uri() ).'/images/logo.png" class="logo" alt="logo" /></a>'); ?>	
				</div><!-- logo -->
			</div><!-- float-header -->
		</div><!-- logo-area -->
	</header>