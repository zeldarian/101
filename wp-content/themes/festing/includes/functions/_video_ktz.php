<?php
/*
/*-----------------------------------------------*/
/* KENTOOZ THEMES FUNCTION
/* Website    : http://www.kentooz.com
/* The Author : Gian Mokhammad Ramadhan (http://www.gianmr.com)
/* Twitter    : http://www.twitter.com/g14nnakal 
/* Facebook   : http://www.facebook.com/gianmr
/*-----------------------------------------------*/

function ktz_video_wrapper() {
global $post;
	if ( has_post_format('video') ) :
		$ktz_other_video_mt = get_post_custom_values('ktz_other_video', $post->ID); 
		$ktz_other_video = $ktz_other_video_mt[0];
		if (empty($ktz_other_video_mt)) :
			$ktz_self_video_mp4_mt = get_post_custom_values('ktz_self_video_mp4', $post->ID); 
			$ktz_self_video_webm_mt = get_post_custom_values('ktz_self_video_webm', $post->ID); 
			$ktz_self_video_ogg_mt = get_post_custom_values('ktz_self_video_ogg', $post->ID); 
			$ktz_self_video_youtube_mt = get_post_custom_values('ktz_youtube_id', $post->ID); 
			$ktz_self_video_vimeo_mt = get_post_custom_values('ktz_vimeo_id', $post->ID); 
			$ktz_self_video_dailymotion_mt = get_post_custom_values('ktz_dailymotion_url', $post->ID); 
			$ktz_self_video_mp4 = $ktz_self_video_mp4_mt[0];
			$ktz_self_video_webm = $ktz_self_video_webm_mt[0];
			$ktz_self_video_ogg = $ktz_self_video_ogg_mt[0];
			$ktz_self_video_youtube = $ktz_self_video_youtube_mt[0];
			$ktz_self_video_vimeo = $ktz_self_video_vimeo_mt[0];
			$ktz_self_video_dailymotion = $ktz_self_video_dailymotion_mt[0];
				echo '<video id="ktz_video_box" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" width="" height=""';
			if ( $ktz_self_video_mp4_mt ) :
				echo ' poster="';
				echo ktz_featured_just_img_link('634', '357');
				echo '"';
			elseif ( $ktz_self_video_webm_mt ) :
				echo ' poster="';
				echo ktz_featured_just_img_link('634', '357');
				echo '"';
			elseif ( $ktz_self_video_ogg_mt ) :
				echo ' poster="';
				echo ktz_featured_just_img_link('634', '357');
				echo '"';
			else :
				echo '';
			endif;
				echo ' data-setup=\'{';
			if ( $ktz_self_video_youtube_mt ) :
				echo '"techOrder": ["youtube"], "src": "http://www.youtube.com/watch?v='.$ktz_self_video_youtube.'", "ytcontrols": true';
			elseif ( $ktz_self_video_vimeo_mt ) :
				echo '"techOrder": ["vimeo"], "src": "https://vimeo.com/'.$ktz_self_video_vimeo.'"';
			elseif ( $ktz_self_video_dailymotion_mt ) :
				echo '"techOrder": ["dailymotion"], "src": "'.$ktz_self_video_dailymotion.'"';
			endif;
				echo '}\'>';
			if ( $ktz_self_video_mp4_mt ) :
				echo '<source src="' . $ktz_self_video_mp4 . '" type=\'video/mp4\' />';
			elseif ( $ktz_self_video_webm_mt ) :
				echo '<source src="' . $ktz_self_video_webm . '" type=\'video/webm\' />';
			elseif ( $ktz_self_video_ogg_mt ) :
				echo '<source src="' . $ktz_self_video_ogg . '" type=\'video/ogg\' />';
			elseif ( $ktz_self_video_youtube_mt ) :
				echo '';
			elseif ( $ktz_self_video_vimeo_mt ) :
				echo '';
			elseif ( $ktz_self_video_dailymotion_mt ) :
				echo '';
			else :
				echo '<source src="http://video-js.zencoder.com/oceans-clip.mp4" type=\'video/mp4\' />';
			endif;
				echo '</video>';
		endif;
		if ( !empty($ktz_other_video_mt) ) :
			echo '<div class="ktz-videowrapper">';
			echo $ktz_other_video;
			echo '</div>';
		endif;
	endif;
}

?>