<?php


class urcr_TermUpdater {

	/**
	 * @var self
	 */
	protected static $instance;

	/**
	 * @var array An array of term slugs that must be removed.
	 */
	protected $to_remove = array();

	/**
	 * @var array An array of term slugs that must be added.
	 */
	protected $to_add = array();

	public static function instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function update_terms() {
		$tax    = urcr_Plugin::instance()->taxonomy_name;
		$option = urcr_Plugin::instance()->added_terms_option;

		$user_roles = get_option( 'wp_user_roles', array() );

		if ( empty( $user_roles ) ) {
			return;
		}

		$user_roles_slugs = array_keys( $user_roles );

		$added_terms = get_option( $option, array() );

		$should_add_or_remove_terms = $this->should_add_or_remove_terms( $added_terms, $user_roles_slugs );

		if ( ! $should_add_or_remove_terms ) {
			return;
		}


		foreach ( $this->get_slugs_to_remove() as $role_slug ) {
			$term = get_term_by( 'slug', $role_slug, $tax );
			wp_delete_term( $term->term_id, $tax );
		}

		foreach ( $this->get_slugs_to_add() as $role_slug ) {
			$role_name = $user_roles[ $role_slug ]['name'];
			wp_insert_term( $role_name, $tax, array( 'slug' => $role_slug ) );
			$added_terms[] = $role_slug;
		}

		update_option( $option, $added_terms );
	}

	protected function should_add_or_remove_terms( $added_terms, $user_roles_slugs ) {
		$this->to_remove = array_diff( $added_terms, $user_roles_slugs );
		$this->to_add    = array_diff( $user_roles_slugs, $added_terms );

		return count( $this->to_remove ) || count( $this->to_add );
	}

	private function get_slugs_to_remove() {
		return $this->to_remove;
	}

	private function get_slugs_to_add() {
		return $this->to_add;
	}

}