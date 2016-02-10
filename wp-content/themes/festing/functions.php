<?php
/*-----------------------------------------------*/
/* KENTOOZ FRAMEWORK
/* Version :1.01
/* You can add your own function here! 
/* But don't change anything in this file!
/*-----------------------------------------------*/

// Get theme name
$themename = "fasthink";
$themeversion = "v 1.03";
$shortname = str_replace(' ', '_', strtolower($themename));

// Load kentooz framework
require_once (TEMPLATEPATH . '/includes/init.php');
$kentooz_declare = new KENTOOZ();
$kentooz_declare->init();

?>