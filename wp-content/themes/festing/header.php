<!DOCTYPE html>
<!--[if IE 7]><html class="ie7 no-js"  <?php language_attributes(); ?><![endif]-->
<!--[if lte IE 8]><html class="ie8 no-js"  <?php language_attributes(); ?><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="not-ie no-js" <?php language_attributes(); ?>><!--<![endif]-->

<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	
	<!-- Meta responsive compatible mode on IE and chrome, and zooming 1 by kentooz themes -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<!-- mobile optimized meta by kentooz themes -->
	<meta name="HandheldFriendly" content="True" />
	<meta name="MobileOptimized" content="320" />

	<!-- Title by kentooz themes -->
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	
	<?php wp_head(); ?>

</head>
<body <?php body_class('kentooz'); ?> id="top">
	
	<div class="ktz-allwrap">
	<header class="ktz-mainheader">
	<div class="header-wrap">
		<div class="container">
			<div class="clearfix">	
			<?php hook_ktz_logo(); //Logo hook system ?>
			</div>
		</div>	
	</div>
	</header>
	
	<nav class="navbar navbar-default ktz-mainmenu" role="navigation">
	<div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<?php hook_ktz_menu_header(); //Kentooz_hook_system ?>
    </div>
	</div>
	</nav>
			<?php hook_ktz_after_header(); //Kentooz_hook_system ?>
	<div class="ktz-inner-content">
		<div class="container">
			<?php //hook_ktz_aftermenubanner(); ?>
		</div>	
		<div class="container">
			<div class="row">