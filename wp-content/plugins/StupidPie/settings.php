<?php
global $spp_settings;
$spp_settings = new stdClass;

// You can have more than one rewrite rule now
$spp_settings->url_rewrites = array(
'tag' => array('separator' => '-', 'rule' => 'archive/(.*).html', 'index' => 1, 'permalink' => 'archive/{{ term }}'.'.html' ), //0
'random' => array('separator' => '-', 'rule' => '(.*)/(.*)\.html', 'index' => 2, 'permalink' => '{{ random }}/{{ term }}.html' ), //1
'first_word' => array('separator' => '-', 'rule' => '(.*)/(.*)\.html', 'index' => 2, 'permalink' => '{{ first_word }}/{{ term }}.html' ), //2

'index_image' => array('separator' => '-', 'rule' => 'archive/(.*)', 'index' => 1, 'permalink' => 'archive/{{ term }}'.'.html' ),
'single_image' => array('separator' => '-', 'rule' => 'archive/(.*)', 'index' => 1, 'permalink' => 'archive/{{ term }}'.'.html' ), //3

'index_video' => array('separator' => '-', 'rule' => 'archive/(.*)', 'index' => 1, 'permalink' => 'archive/{{ term }}'.'.html' ), //5
'single_video' => array('separator' => '-', 'rule' => 'archive/(.*)', 'index' => 1, 'permalink' => 'archive/{{ term }}'.'.html' ),

// separator, rewrite, preg_index
);

// Default filters before displayed
$spp_settings->default_filters = array(
'remove' => array('Instantly connect to whats most important to you.', '...', '..'),
);

// if set to true, StupidPie will only store search terms if visitor is coming from specific country i.e: array('US','UK','DE')
$spp_settings->country_targeting = array();

// filter bad domains here
$spp_settings->bad_urls = array('youporn.com', 'facebook.com');

// this words will be automatically removed, and if the title contains these words, it will return 404 not found
$spp_settings->bad_words = 'Saathiya';
