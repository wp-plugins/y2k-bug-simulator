<?php
/**
 * @package jbl_y2k
 */
/*
Plugin Name: Y2K Bug Simulator
Plugin URI: http://sp.uconn.edu/~jbl00001/jbl-y2k.zip
Description: Renders the year as if a Y2K bug were present
Author: James Luberda
Version: 1.2
Author URI: http://sp.uconn.edu/~jbl00001
License: GPLv2 or later
*/

/* Copyright 2014 James Luberda (email: james.luberda@gmail.com)

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

define( 'DEBUG', false );

// verify plugin is not being called directly
if ( !function_exists( 'add_action' ) ) {
        echo "This is a plugin and only functions when called by WordPress\n";
        exit;
}

// set up plugin default option
register_activation_hook( __FILE__, 'jbl_y2k_activate' );

function jbl_y2k_activate() {
	add_option( 'jbl_y2k_adminonly', 'Yes' );
}

add_action( 'admin_menu', 'jbl_y2k_add_page' );
add_action( 'admin_init', 'jbl_y2k_admin_init' );

function jbl_y2k_add_page() {
        add_options_page( 'Y2K Bug Simulator', 'Y2K', 'manage_options', 'jbl_y2k', 'jbl_y2k_option_page' );
}

function jbl_y2k_option_page() {
	?>
	<div class="wrap">
	<h2>Y2k Bug Simulator</h2>
	<form action="options.php" method="post">
	<?php settings_fields( 'jbl_y2k_options' ); ?>
	<?php do_settings_sections( 'jbl_y2k' ); ?>
	<input name="Submit" type="submit" value="Save Changes" />
	</form>
	</div>
        <?php
}

function jbl_y2k_admin_init() {
	register_setting( 'jbl_y2k_options', 'jbl_y2k_adminonly' );
	add_settings_section( 'jbl_y2k_main', 'Configuration Settings', 'jbl_y2k_section_text', 'jbl_y2k' );
	add_settings_field( 'jbl_y2k_adminonly', 'Y2K Effect Admin-Only ', 'jbl_y2k_setting_input', 'jbl_y2k', 'jbl_y2k_main' );
}

// Draw the section header
function jbl_y2k_section_text() {
	echo "The following option determines which users see the Y2K date change. If checked, only admin-level users will see, i.e. '2014' rendered as '1914'";
}

// Display and fill the form field
function jbl_y2k_setting_input() {
	// get jbl_y2k_adminonly from the database
	$jbl_y2k_adminonly = get_option( 'jbl_y2k_adminonly' );
	$checked = $jbl_y2k_adminonly ? 'checked' : '';
	// echo the field
	echo "<input id='jbl_y2k_adminonly' name='jbl_y2k_adminonly' type='checkbox' value='Yes' $checked/>";
}

// list of filters
$jbl_y2k_filters = array(
	'get_the_date',
	'get_comment_date',
	'get_the_modified_date',
	'wp_title',
	'modified_edit_pre',
	'modified_gmt_edit_pre',
	'date_edit_pre',
	'date_gmt_edit_pre',
	'post_date_column_time'
);

//list of archive filters
$jbl_y2k_archive_filters = array(
	'get_archives_link',
	'get_calendar',
);

foreach ( $jbl_y2k_filters as $jbl_y2k_filter ) {
	add_filter( $jbl_y2k_filter, 'jbl_y2k_convert' );
}

foreach ( $jbl_y2k_archive_filters as $jbl_y2k_archive_filter ) {
	add_filter( $jbl_y2k_archive_filter, 'jbl_y2k_archive_convert' );
}

function jbl_y2k_convert( $content ) {
	if ( DEBUG ) {
		$r_content_string = print_r ($content, true);
		file_put_contents ( '/tmp/y2k-wp.log', $r_content_string, FILE_APPEND );
	}
	$jbl_y2k_adminonly = get_option( 'jbl_y2k_adminonly' );
	if ( current_user_can( 'manage_options' ) || !$jbl_y2k_adminonly ) {
	        $content = preg_replace( "/(\D+?|^)20(\d\d(\D+?|$))/", "$1 19$2", $content );
	}
        return $content;
}

function jbl_y2k_archive_convert( $content ) {
	if ( DEBUG ) {
		$r_content_string = print_r ($content, true);
		file_put_contents ( '/tmp/y2k-wp.log', $r_content_string, FILE_APPEND );
	}
	//kludgy change, just added a space before 20
	if ( current_user_can( 'manage_options' ) || !$jbl_y2k_adminonly ) {
	        $content = preg_replace( "/(\D+?|^) 20(\d\d(\D+?|$))/", "$1 19$2", $content );
	}
	return $content;
}

?>
