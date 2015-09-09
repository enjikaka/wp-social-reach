class Social_Reach_Plugin_Updater {
	protected $file;
	protected $plugin;
	protected $basename;
	protected $active;

	private $username;
	private $repository;
	private $authorize_token;
	private $github_response;

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

	public function set_username($username) {
		$this->username = $username;
	}

	public function set_repository($repository) {
		$this->repository  = $repository;
	}

	public function authorize($token) {
		$this->authorize_token = $token;
	}
}