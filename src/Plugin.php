<?php


class urcr_Plugin {

	/**
	 * @var self
	 */
	protected static $instance;

	/**
	 * @var string Absolute path to the plugin main file.
	 */
	public $root_file;

	/**
	 * @var string Absolute path to the plugin main directory.
	 */
	public $root_dir;

	/**
	 * @var string URL to the plugin main directory.
	 */
	public $root_url;

	/**
	 * @var string The user role restriction taxonomy name.
	 */
	public $taxonomy_name = 'urcr_user_roles';

	/**
	 * @var
	 */
	public $added_terms_option = 'urcr_added_terms';

	public static function instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public static function activate() {
		if ( ! ( class_exists( 'trc_Core_Plugin' ) && class_exists( 'CMB2' ) ) ) {
			return;
		}
		wp_schedule_event( time(), 'hourly', 'urcr_worker' );
		urcr_TermUpdater::instance()
		                ->update_terms();
	}

	public static function deactivate() {
		wp_clear_scheduled_hook( 'urcr_worker' );
	}

	public function hooks() {
		if ( ! ( class_exists( 'trc_Core_Plugin' ) && class_exists( 'CMB2' ) ) ) {
			return;
		}

		add_action( 'init', array( $this, 'localization_init' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );

		trc_Core_Plugin::instance()->post_types->add_restricted_post_type( $this->get_restricted_post_types() );
		trc_Core_Plugin::instance()->user->add_user_slug_provider( $this->taxonomy_name, urcr_User::instance( $this->taxonomy_name ) );
		trc_Core_Plugin::instance()->taxonomies->add( $this->taxonomy_name );

		add_action( 'urcr_worker', array( urcr_TermUpdater::instance(), 'update_terms' ) );
		add_action( 'cmb2_init', array( urcr_TermMetabox::instance(), 'add_metabox' ) );
	}

	public function localization_init() {
		$path = $this->root_dir . '/languages/';
		load_plugin_textdomain( 'urcr', false, $path );
	}

	public function register_taxonomy() {
		register_taxonomy( $this->taxonomy_name, $this->get_restricted_post_types(), array( 'show_ui' => false ) );
	}

	public function get_restricted_post_types() {
		return apply_filters( 'urcr_restricted_post_types', array( 'post', 'page' ) );
	}
}