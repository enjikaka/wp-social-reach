// Include updater-class
include_once(plugin_dir_path( __FILE__ ).'social-reach-plugin-updater.php');

$plugin_updater = new Social_Reach_Plugin_Updater(__FILE__);
$plugin_updater->set_username('enjikaka');
$plugin_updater->set_repository('wp-social-reach');