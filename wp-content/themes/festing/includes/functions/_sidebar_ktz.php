<?php
/*
/*-----------------------------------------------*/
/* KENTOOZ SIDEBAR FRAMEWORK
/* Website: kentooz.com
/* The Author: Gian Mokhammad Ramadhan 
/* Social network :twitter.com/g14nnakal facebook.com/gianmr
/* Version :1.0
/*-----------------------------------------------*/

/*******************************************
# Register sidebar on hook system ~ post
*******************************************/
function sidebar_widget_init() {
	register_sidebar(array('name' => __( 'Default Sidebar', ktz_theme_textdomain ),'id' => 'sidebar_default','description' => 'sidebar','before_widget' => '<aside id="%1$s" class="widget %2$s">','after_widget' => '</aside>','before_title' => '<h4 class="widget-title"><span class="ktz-blocktitle">','after_title' => '</span></h4>', ));
	if (class_exists('bbPress')):
	register_sidebar(array('name' => __( 'BBPress Sidebar', ktz_theme_textdomain ),'id' => 'sidebar_forum','description' => 'sidebar','before_widget' => '<aside id="%1$s" class="widget %2$s">','after_widget' => '</aside>','before_title' => '<h4 class="widget-title"><span class="ktz-blocktitle">','after_title' => '</span></h4>', ));
	endif;
    register_sidebar(array('name' => __( 'Footer 1', ktz_theme_textdomain ),'id' => 'widget_fot1','before_widget' => '<aside id="%1$s" class="widget %2$s">','after_widget' => '</aside>','before_title' => '<h4 class="widget-title"><span class="ktz-blocktitle">','after_title' => '</span></h4>', ));
    register_sidebar(array('name' => __( 'Footer 2', ktz_theme_textdomain ),'id' => 'widget_fot2','before_widget' => '<aside id="%1$s" class="widget %2$s">','after_widget' => '</aside>','before_title' => '<h4 class="widget-title"><span class="ktz-blocktitle">','after_title' => '</span></h4>', ));
    register_sidebar(array('name' => __( 'Footer 3', ktz_theme_textdomain ),'id' => 'widget_fot3','before_widget' => '<aside id="%1$s" class="widget %2$s">','after_widget' => '</aside>','before_title' => '<h4 class="widget-title"><span class="ktz-blocktitle">','after_title' => '</span></h4>', ));
    register_sidebar(array('name' => __( 'Footer 4', ktz_theme_textdomain ),'id' => 'widget_fot4','before_widget' => '<aside id="%1$s" class="widget %2$s">','after_widget' => '</aside>','before_title' => '<h4 class="widget-title"><span class="ktz-blocktitle">','after_title' => '</span></h4>', ));
    register_sidebar(array('name' => __( 'Footer 5', ktz_theme_textdomain ),'id' => 'widget_fot5','before_widget' => '<aside id="%1$s" class="widget %2$s">','after_widget' => '</aside>','before_title' => '<h4 class="widget-title"><span class="ktz-blocktitle">','after_title' => '</span></h4>', ));
    register_sidebar(array('name' => __( 'Footer 6', ktz_theme_textdomain ),'id' => 'widget_fot6','before_widget' => '<aside id="%1$s" class="widget %2$s">','after_widget' => '</aside>','before_title' => '<h4 class="widget-title"><span class="ktz-blocktitle">','after_title' => '</span></h4>', ));
	/* Register new sidebar via admin panel and display in post single or page */
	$sidebars_new = ot_get_option( 'ktz_sidebars', array() );

    if ($sidebars_new){
        foreach ($sidebars_new as $sidebar_new) {
            register_sidebar(array(
                'name' => $sidebar_new["title"],
                'id' => $sidebar_new["slug"],
                'description' => 'Kentooz custom sidebars.',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h4 class="widget-title"><span class="ktz-blocktitle">',
                'after_title' => '</span></h4>',
            ));
        }
    }
}

?>