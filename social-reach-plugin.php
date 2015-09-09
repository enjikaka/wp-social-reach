<?php

/**
 * @package WP_Social_Reach
 * @version 0.1
 */

/*
  Plugin Name: WP Social Reach
  Plugin URI: https://github.com/enjikaka/wp-social-reach
  Description: Get likes and shares count from Social Networks
  Version: 0.1
  Author: Jeremy Karlsson
  Author URI: http://jeremy.se
*/

// Include updater-class
if (!class_exists('Social_Reach_Plugin_Updater')) {
  include_once(plugin_dir_path( __FILE__ ).'social-reach-plugin-updater.php');
}

$plugin_updater = new Social_Reach_Plugin_Updater(__FILE__);
$plugin_updater->set_username('enjikaka');
$plugin_updater->set_repository('wp-social-reach');
/*
  $plugin_updater->authorize( 'abcdefghijk1234567890' ); // Your auth code goes here for private repos
*/
$plugin_updater->initialize();

function reach_data($id) {
  $url = get_permalink($id);
  echo '<script>function JSONHttpRequest(){function f(b){try{if(typeof a[b]=="function"){d[b]=function(){if(b=="setRequestHeader")c=arguments[0].toLowerCase()=="content-type";return a[b].apply(a,Array.prototype.slice.apply(arguments))}}else{e.get=function(){return a[b]};e.set=function(c){a[b]=c};Object.defineProperty(d,b,e)}}catch(f){}}var a=new XMLHttpRequest;var b=null;var c=false;var d=this;var e={get:function(){try{b=a.responseText?!b?JSON.parse(a.responseText):b:null}catch(c){if(d.strictJSON)throw c}return b},enumerable:true,configurable:true};d.strictJSON=true;Object.defineProperty(d,"responseJSON",e);d.sendJSON=function(e){try{e=JSON.stringify(e);b=null;if(!c)a.setRequestHeader("Content-Type","application/json;charset=encoding");c=false}catch(f){if(d.strictJSON)throw f}a.send(e)};f("onreadystatechange");for(n in a)f(n)}var SocialReach={url:null,tmp:0,sucessCallback:null,errorCallback:null,results:{total:0,tweets:null,facebook:{total:0,comments:null,likes:null,shares:null},plusOnes:null},fetch:{twitter:function(){if(null===SocialReach.url)console.error("No url.");else{var e="http://urls.api.twitter.com/1/urls/count.json?url="+SocialReach.url,l="jsonp_callback_"+Math.round(1e5*Math.random());window[l]=function(e){delete window[l],document.body.removeChild(a),SocialReach.results.tweets=parseInt(e.count),SocialReach.initCallback()};var a=document.createElement("script");a.src=e+(e.indexOf("?")>=0?"&":"?")+"callback="+l,document.body.appendChild(a)}},facebook:function(){if(null===SocialReach.url)console.error("No url.");else{var e=new JSONHttpRequest;e.onreadystatechange=function(){if(4===e.readyState&&null!=e.responseJSON){var l=e.responseJSON[0] === undefined ? {total_count:0} : e.responseJSON[0],a={total:parseInt(l.total_count),comments:parseInt(l.comment_count),shares:parseInt(l.share_count),likes:parseInt(l.like_count)};SocialReach.results.facebook=a,SocialReach.initCallback()}},e.onerror=function(){throw new Error("Error occured while fetching data from Facebook.")},e.open("GET","https://api.facebook.com/method/links.getStats?urls="+SocialReach.url+"&format=json",!0),e.send()}},googlePlus:function(){if(null===SocialReach.url)console.error("No url.");else{var e=new JSONHttpRequest;e.onreadystatechange=function(){if(4===e.readyState&&null!=e.responseJSON){var l=e.responseJSON.ones;l=null==l?0:l,SocialReach.results.plusOnes=parseInt(l),SocialReach.initCallback()}},e.onerror=function(){throw new Error("Error occured while fetching data from Google Plus.")},e.open("GET","http://labs.enji.se/share-reach/?url="+SocialReach.url,!0),e.send()}}},initCallback:function(){SocialReach.tmp+=1,3===SocialReach.tmp&&(SocialReach.results.total=SocialReach.results.facebook.total+SocialReach.results.plusOnes+SocialReach.results.tweets,SocialReach.successCallback(SocialReach.results),SocialReach.tmp=0)},get:function(e,l,a){null!==l&&(SocialReach.successCallback=l),null!==a&&(SocialReach.errorCallback=a),null===SocialReach.successCallback&&console.error("No success callback function."),SocialReach.url=encodeURIComponent(e),SocialReach.results={total:0,tweets:null,facebook:{total:0,comments:null,likes:null,shares:null},plusOnes:null};try{SocialReach.fetch.facebook(),SocialReach.fetch.twitter(),SocialReach.fetch.googlePlus()}catch(c){SocialReach.errorCallback(c)}}};</script>';
  //echo '<p>Results for ' . $url;
  echo '<div class="social-reach">';
    $input_style = "background-color:white;color:black;";
    $dashicon_style = "display:inline-block;vertical-align:middle;padding-right:0.5rem;";
    $label_style = $dashicon_style . "width:110px;padding:0.4rem 0;";
    echo '<label for="social-reach-twitter" style="'.$label_style.'"><span class="dashicons dashicons-twitter" style="'.$dashicon_style.'"></span><span>Twitter</span></label><input name="social-reach-twitter" disabled type="number" class="twitter-count" style="'.$input_style.'"><br>';
    echo '<label for="social-reach-facebook" style="'.$label_style.'"><span class="dashicons dashicons-facebook" style="'.$dashicon_style.'"></span><span>Facebook</span></label><input name="social-reach-facebook" disabled type="number" class="facebook-count" style="'.$input_style.'"><br>';
    echo '<label for="social-reach-google-plus" style="'.$label_style.'"><span class="dashicons dashicons-googleplus" style="'.$dashicon_style.'"></span><span>Google Plus</span></label><input name="social-reach-google-plus" disabled type="number" class="google-plus-count" style="'.$input_style.'"><br>';
    echo '<label for="social-reach-total" style="'.$label_style.'"><span class="dashicons dashicons-awards" style="'.$dashicon_style.'"></span><span>Total shares</span></label><input name="social-reach-total" disabled type="number"class="total-count" style="'.$input_style.'">';
  echo '</div>';

  echo '<script>SocialReach.get("'.$url.'", function(data) {
        var sr = document;
        sr.querySelector(".twitter-count").value = data.tweets;
        sr.querySelector(".facebook-count").value = data.facebook.total;
        sr.querySelector(".google-plus-count").value = data.plusOnes;
        sr.querySelector(".total-count").value = data.total;
    }, function(error) {
        console.log(error.message);
    });</script>';
}

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function social_reach_add_meta_box() {
  $screens = array( 'post', 'page' );
  foreach ($screens as $screen) {
    add_meta_box(
      'social_reach_sectionid',
      __( '<span class="dashicons dashicons-groups"></span> Social Reach', 'social_reach_textdomain' ),
      'social_reach_meta_box_callback',
      $screen
    );
  }
}
add_action('add_meta_boxes', 'social_reach_add_meta_box');

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function social_reach_meta_box_callback($post) {
  // Add an nonce field so we can check for it later.
  wp_nonce_field('social_reach_meta_box', 'social_reach_meta_box_nonce');

  /*
   * Use get_post_meta() to retrieve an existing value
   * from the database and use the value for the form.
   */
  $value = get_post_meta($post->ID, '_my_meta_value_key', true);
  echo reach_data($post->ID);
}

?>