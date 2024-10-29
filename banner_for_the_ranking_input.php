<?php
/*
Plugin Name: banner for the ranking input
Plugin URI: http://www.uribozu.net/plugin
Description: ランキングバナー簡単入力ツール
Version: 0.1
Author: uribozu
Author URI: http://www.uribozu.net/
*/

$wp_root = dirname(dirname(dirname(dirname(__FILE__)))) . '/';

$plugin_root_for_banner= $wp_root."wp-content/plugins/banner-for-the-ranking-input/";
$banner_path=$plugin_root_for_banner."lib/banner_list.txt";

require_once($plugin_root_for_banner."lib/co.php");
require_once($plugin_root_for_banner."lib/banner_calss.php");
$banner_calssObj=new banner_calss();
$formDataRanking=$banner_calssObj->makeForm($banner_path);

add_action('admin_menu', 'banner_ranking_input');
add_action('admin_menu', 'banner_add_custom_box');
//add_action('save_post', 'myplugin_save_postdata');
function banner_add_custom_box() {
  if( function_exists( 'add_meta_box' )) {
    add_meta_box( 'banner_ranking_sectionid', __( 'ランキングバナー選択', 'banner_textdomain' ), 
                'banner_inner_custom_box', 'post', 'advanced' );
   }
}
function banner_inner_custom_box() {
  echo '<input type="hidden" name="banner_ranking_input" id="banner_ranking_input" value="' . 
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
  echo 'バナーを選択してください';
  echo $GLOBALS['formDataRanking'];
}
function banner_ranking_input() {
	add_options_page('ランキングバナー簡単入力', 'ランキングバナー簡単入力', 8, 'banner_ranking_input', 'banner_start');
}
?>
