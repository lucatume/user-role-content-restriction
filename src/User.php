<?php


class urcr_User implements trc_Public_UserSlugProviderInterface {

	/**
	 * @var string
	 */
	protected $taxonomy_name;

	public static function instance( $taxonomy_name ) {
		$instance = new self;

		$instance->taxonomy_name = $taxonomy_name;

		return $instance;
	}

	/**
	 * @return string The name of the taxonomy the class will provide user slugs for.
	 */
	public function get_taxonomy_name() {
		return $this->taxonomy_name;
	}

	/**
	 * @return string[] An array of term slugs the user can access for the taxonomy.
	 */
	public function get_user_slugs() {
		$user = get_user_by( 'id', get_current_user_id() );
		return $user->roles;
	}

	/**
	 * @param string $taxonomy_name
	 */
	public function set_taxonomy_name( $taxonomy_name ) {
		$this->taxonomy_name = $taxonomy_name;
	}
}