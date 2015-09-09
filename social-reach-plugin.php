<?php

/*
  Plugin Name: WP Social Reach
  Plugin URI: https://github.com/enjikaka/wp-social-reach
  Description: Get likes and shares count from Social Networks
  Version: 0.0.4
  Author: Jeremy Karlsson
  Author URI: http://jeremy.se
*/

// Include updater-class
if (!class_exists('GitHub_Plugin_Updater')) {
  include_once(plugin_dir_path( __FILE__ ).'github-plugin-updater.php');
}

if (!class_exists('Social_Reach')) {
  include_once(plugin_dir_path( __FILE__ ).'social-reach.php');
}

$plugin_updater = new GitHub_Plugin_Updater(__FILE__);
$plugin_updater->set_username('enjikaka');
$plugin_updater->set_repository('wp-social-reach');
/*
  $plugin_updater->authorize( 'abcdefghijk1234567890' ); // Your auth code goes here for private repos
*/
$plugin_updater->initialize();

function reach_data($id) {
  $url = get_permalink($id);

  $social_reach = new Social_Reach($url);

  echo '<div class="social-reach">';
    $input_style = "background-color:white;color:black;";
    $dashicon_style = "display:inline-block;vertical-align:middle;padding-right:0.5rem;";
    $label_style = $dashicon_style . "width:110px;padding:0.4rem 0;";
    echo '<label for="social-reach-twitter" style="'.$label_style.'"><span class="dashicons dashicons-twitter" style="'.$dashicon_style.'"></span><span>Twitter</span></label><input name="social-reach-twitter" value="'.$social_reach->tweet_count().'" disabled type="number" class="twitter-count" style="'.$input_style.'"><br>';
    echo '<label for="social-reach-facebook" style="'.$label_style.'"><span class="dashicons dashicons-facebook" style="'.$dashicon_style.'"></span><span>Facebook</span></label><input name="social-reach-facebook" value="'.$social_reach->facebook_likes_count().'" disabled type="number" class="facebook-count" style="'.$input_style.'"><br>';
    echo '<label for="social-reach-google-plus" style="'.$label_style.'"><span class="dashicons dashicons-googleplus" style="'.$dashicon_style.'"></span><span>Google Plus</span></label><input name="social-reach-google-plus value="'.$social_reach->oogle_plus_one_count().'"" disabled type="number" class="google-plus-count" style="'.$input_style.'"><br>';
    echo '<label for="social-reach-total" style="'.$label_style.'"><span class="dashicons dashicons-awards" style="'.$dashicon_style.'"></span><span>Total shares</span></label><input name="social-reach-total" disabled type="number"class="total-count" style="'.$input_style.'">';
  echo '</div>';
}

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function social_reach_add_meta_box() {
  $screens = array('post', 'page');
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
  //wp_nonce_field('social_reach_meta_box', 'social_reach_meta_box_nonce');
  //echo "Hejsan";

  /*
   * Use get_post_meta() to retrieve an existing value
   * from the database and use the value for the form.
   
  $value = get_post_meta($post->ID, '_my_meta_value_key', true);*/
  echo reach_data($post->ID);

}

?>