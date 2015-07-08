# User Role Content Restriction

*An extension of theAverageDev Restricted Content plugin to restrict content on a user role base.*

## Requirements

TL;DR
* [Custom Meta Boxes 2](https://github.com/webdevstudios/CMB)
* [theAverageDev Restricted Content plugin](https://github.com/lucatume/tad-content-restriction)

This plugin is an extension of the [theAverageDev Restricted Content plugin](https://github.com/lucatume/tad-content-restriction) and to render the content restriction meta box the plugin will use [Custom Meta Boxes 2](https://github.com/webdevstudios/CMB2) so that's another requirement.

## Installing
Download the `.zip` file and place it in the plugins folder, activate.

## Configuring
The plugin is meant for developers and does not come with a management UI users can use (beside the one for restricting the access).
By default the plugin will apply user role based content restriction to posts and pages (`post` and `page` post types); to extend the plugin to more post types use the filter:

	add_filter( 'urcr_restricted_post_types', 'myplugin_restricted_post_types' );
	function myplugin_restricted_post_types(array $restricted_post_types){
		$restricted_post_types[] = 'custom_post_type_1';
		$restricted_post_types[] = 'custom_post_type_2';
		
		return $restricted_post_types;
	}
	
Anyone able to edit a post type will be able to set which user roles will be able to access it.
