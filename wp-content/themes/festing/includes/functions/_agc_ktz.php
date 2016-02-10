<?php
/*
/*-----------------------------------------------*/
/* KENTOOZ THEMES FUNCTION
/* Website    : http://www.kentooz.com
/* The Author : Gian Mokhammad Ramadhan (http://www.gianmr.com)
/* Twitter    : http://www.twitter.com/g14nnakal 
/* Facebook   : http://www.facebook.com/gianmr
/*-----------------------------------------------*/

/*
* ALL AGC FUNGTIONS GOOGLE
*/
function pete_curl_get($url, $params){
	$post_params = array();
	foreach ($params as $key => &$val) {
		if (is_array($val)) $val = implode(',', $val);
		$post_params[] = $key.'='.urlencode($val);
	}
	$post_string = implode('&', $post_params);
	$fullurl = $url."?".$post_string;
	$ch = curl_init();curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);curl_setopt($ch, CURLOPT_URL, $fullurl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7) Gecko/20040608');
	$result = curl_exec($ch);curl_close($ch);
	return $result;
}

function perform_google_web_search($termstring){
	$start = 0;
	$get_google_API = ot_get_option('ktz_googleapi_key');
	$result = array();
	while($start<10)
	{
		$searchurl = 'http://ajax.googleapis.com/ajax/services/search/web?v=1.0'; 
		$searchurl .= '&key='.$get_google_API;
		$searchurl .= '&start='.$start;
		$searchurl .= '&rsz=large';
		$searchurl .= '&filter=0';
		$searchurl .= '&q='.urlencode($termstring);
		$response = pete_curl_get($searchurl, array());
		$responseobject = json_decode($response, true);
	if (count(isset($responseobject['responseData']['results'])) == 0 )
	break;
	$allresponseresults = $responseobject['responseData']['results'];
	if (is_array($allresponseresults))
	{
	foreach ($allresponseresults as $responseresult)
	{
		$result[] = array(
		'url' => $responseresult['url'],
		'title' => $responseresult['title'],
		'abstract' => $responseresult['content'],
		'Oriurl' => $responseresult['url'],);
		}
	} else {
		echo 'No internet connection ';
	}
	$start += 8;
	}
	return $result;
}

function perform_google_web_search_single($termstring){
	$start = 0;
	$get_google_API = ot_get_option('ktz_googleapi_key');
	$result = array();
	while($start<4)
	{
		$searchurl = 'http://ajax.googleapis.com/ajax/services/search/images?v=1.0'; 
		$searchurl .= '&key='.$get_google_API;
		$searchurl .= '&start='.$start;
		$searchurl .= '&rsz=large';
		$searchurl .= '&filter=0';
		$searchurl .= '&q='.urlencode($termstring);
		$response = pete_curl_get($searchurl, array());
		$responseobject = json_decode($response, true);
	if (count(isset($responseobject['responseData']['results'])) == 0 )
	break;
	$allresponseresults = $responseobject['responseData']['results'];
	if (is_array($allresponseresults))
	{
	foreach ($allresponseresults as $responseresult)
	{
		$result[] = array(
		'url' => $responseresult['url'],
		'title' => $responseresult['title'],
		'thumbnail' => $responseresult['tbUrl'],
		'height' => $responseresult['tbHeight'],
		'width' => $responseresult['tbWidth'],
		'abstract' => $responseresult['content'],
		'Oriurl' => $responseresult['url']);
		}
	} else {
		echo '';
	}
	$start += 2;
	}
	return $result;
}
// Filter keyword
function CleanFileNameBan($result){
	$badword = ot_get_option('ktz_bad_keyword');
	$bannedkey = array($badword);
	$result = str_ireplace($bannedkey, 'sensor',$result);
	return $result;
}
// Delete all special character
function hilangkan_spesial_karakter($result) { 
	$result = strip_tags($result);
	$result = preg_replace('/&.+?;/', '', $result); 
	$result = preg_replace('/\s+/', ' ', $result);
        $result = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', ' ', $result);
	$result = preg_replace('|-+|', ' ', $result);
        $result = preg_replace('/&#?[a-z0-9]+;/i','',$result);
        $result = preg_replace('/[^%A-Za-z0-9 _-]/', ' ', $result);
	$result = trim($result, ' ');
	return $result;
}
// Get AGC in search
function ktz_get_AGC() {
if (ot_get_option('ktz_agc_activated') == 'yes') {
$s=$_GET['s'];
	if (isset($_REQUEST['s'])) {
	$termstring = urldecode($_REQUEST['s']);
	} else {
	$termstring = '';
	}
$termstring = $s;
if ($s!='') {
	$googleresults = perform_google_web_search($termstring);
	if (is_array($googleresults))
	{
	foreach ($googleresults as $result) {
	$link = urldecode(CleanFileNameBan(strip_tags($result['Oriurl'])));
		print '<div class="entry-search">';
		print '<h3 class="entry-title"><a href="'.get_search_link(CleanFileNameBan(hilangkan_spesial_karakter($result['title']))).'">'.CleanFileNameBan(hilangkan_spesial_karakter($result['title'])).'</a></h3>';
		print '<p>'.CleanFileNameBan(hilangkan_spesial_karakter($result['abstract'])).'</p>';
		print '<hr class="hr-dotted" />';
		print '</div>';
		}
	}
	}
	} else {
	ktz_post_notfound();
	}
}
// Get AGC in single
function ktz_get_AGC_single() {
	if (ot_get_option('ktz_agc_activated') =="yes") {
	$orititle = get_the_title();
	$orititle = trim($orititle);
$termstring = $orititle;
if ($orititle!='') {
	echo '<div class="box-post single relpost">';
	echo '<h4 class="ktz-agc-title"><span class="ktz-blocktitle">' . __( 'Related Search',ktz_theme_textdomain) . '</span></h4>';
	echo '<ul class="ktz-agc-single">';
	$googleresults = perform_google_web_search_single($termstring);
	if (is_array($googleresults))
	{
	$i = 0;
	foreach ($googleresults as $result) {
	$link = urldecode(CleanFileNameBan(strip_tags($result['Oriurl'])));
	$i++;
	if($i < 5){
		echo '<li class="clearfix">';
		echo '<div class="content-related">';
		echo '<a title="'.CleanFileNameBan(hilangkan_spesial_karakter($result['title'])).'" href="'.get_search_link(CleanFileNameBan(hilangkan_spesial_karakter($result['title']))).'">'.CleanFileNameBan(hilangkan_spesial_karakter($result['title'])).'</a>';
		echo '</div></li>';
		}
		}
	}
	echo '</ul>';
	echo '</div>';
	}
	}
}

?>