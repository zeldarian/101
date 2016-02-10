<?php 
/**
 * KENTOOZ SEARCH PAGE TEMPLATE
**/
if (isset($_REQUEST['s'])) {
$termstring = urldecode($_REQUEST['s']);
} else {
$termstring = '';}
get_header(); ?>
	<section class="col-md-12">
	<div class="row">
	<?php if ( ot_get_option('ktz_sb_layout') == 'left' ) : get_sidebar(); endif; ?>
		<div role="main" class="main col-md-9">
		<section class="new-content">
		<h1><?php printf( '<h1>' . __( '%s', ktz_theme_textdomain ), '' . get_search_query() . '</h1>' ); ?></h1>
		<div class="metasingle-aftertitle">
			<div class="ktz-inner-metasingle">
	<span class="byline">by <span class="author vcard">
	<a class="url fn n" href="">

	<script language="JavaScript">
	var r_text = new Array ();
	r_text[0] = "Jackie Evancho";
	r_text[1] = "Taylor Hardick";
	r_text[2] = "Owen Dempsey";
	r_text[3] = "Lucas Till";
	r_text[4] = "Madison Pettis";
	r_text[5] = "Yara Shahidi";
	r_text[6] = "Alexandria DeBerry";
	r_text[7] = "Frank Lebouf"
	r_text[8] = "De Bozz"
	r_text[9] = "Telkomnyet"
	var i = Math.floor(7*Math.random())
	document.write(r_text[i]);
	</script>

	</a></span></span>

<span class="posted-on">on <a href="" rel="">
	<time class="entry-date published updated">

	<script type="text/javascript"> 
	var d=new Date()
	var weekday=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday")
 	var monthname=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec")
 	document.write(weekday[d.getDay()] + " ")
 	document.write(d.getDate() + ". ")
 	document.write(monthname[d.getMonth()] + " ")
 	document.write(d.getFullYear())
 	</script>
	</time>
	</a>
	</span>
</div></div>
<?php
$keyword = get_search_query();
$template = 'wiki.html'; // jeut gantoe dengan nama fle yg laen, lage games, homedesign, car, dan socmed. Tergantung niche.
$hack = '';
echo spp($keyword, $template, $hack);
?>
		<?php if ( have_posts() ) : 
		while ( have_posts() ) : the_post();
			if ( ot_get_option('ktz_content_layout') == 'layout_blog' ) :
			get_template_part( 'content', 'mini' );
			else :
			get_template_part( 'content', get_post_format() );
			endif;
		endwhile; ?>
		<nav id="nav-index">
			<?php ktz_navigation(); ?>
		</nav>
		<?php else : $termstring = $s;
		if (ot_get_option('ktz_agc_activated') == "yes") {
	if ($s!='') {
	$googleresults = perform_google_web_search($termstring);
	if (is_array($googleresults))
	{
	foreach ($googleresults as $result) {
	$link = urldecode(CleanFileNameBan(strip_tags($result['Oriurl'])));
		print '<div class="box-post ktz-agc-search">';
		print '<h2><a href="'.get_search_link(CleanFileNameBan(hilangkan_spesial_karakter($result['title']))).'">'.CleanFileNameBan(hilangkan_spesial_karakter($result['title'])).'</a></h2>';
		print '<p>'.CleanFileNameBan(hilangkan_spesial_karakter($result['abstract'])).'</p>';
		print '<p>Sumber: '.$result['Oriurl'].'</p>';
		print '</div>';
		}
	}
	} 
	} else {
	//ktz_post_notfound();
	} 
	endif; ?>
		</section>
		</div>
	<?php get_sidebar(); ?>
	</div>
	</section>
<?php get_footer(); ?>
