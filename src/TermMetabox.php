<?php


class urcr_TermMetabox {

	public static function instance() {
		return new self;
	}

	public function add_metabox() {
		$prefix = '_urcr_';

		$tax_box = new_cmb2_box( array(
			'id'           => $prefix . 'role_taxonomy',
			'title'        => __( 'Content Restriction', 'urcr' ),
			'object_types' => urcr_Plugin::instance()
			                             ->get_restricted_post_types(),
			'context'      => 'side',
			'priority'     => 'high',
			'show_names'   => true,
			'cmb_styles'   => false
		) );
		$tax_box->add_field( array(
			'name'     => __( 'User Roles', 'urcr' ),
			'desc'     => __( 'Select the user roles that will be able to access the content', 'urcr' ),
			'id'       => $prefix . 'taxonomy_terms',
			'taxonomy' => urcr_Plugin::instance()->taxonomy_name,
			'type'     => 'taxonomy_multicheck'
		) );
	}
}