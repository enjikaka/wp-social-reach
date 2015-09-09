class Social_Reach_Plugin_Updater {
	protected $file;

	public function __construct($file) {
		$this->file = $file;

		add_action('admin_init', array($this, 'set_plugin_properties'));

		return $this;
	}

	public function set_plugin_properties() {
		$this->plugin = get_plugin_data($this->file);
		$this->basename = plugin_basename($this->file);;
		$this->active = is_plugin_active($->basename);
	}
}