<?php
/**
 * @package jbl_y2k
 */
/*
Plugin Name: Y2K Bug Simulator
Plugin URI: http://sp.uconn.edu/~jbl00001/jbl-y2k.zip
Description: Renders the year as if a Y2K bug were present
Author: James Luberda
Version: 1.1
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

// verify plugin is not being called directly
if ( !function_exists( 'add_action' ) ) {
        echo "This is a plugin and only functions when called by WordPress\n";
        exit;
}

// list of filters
$jbl_y2k_filters = array(
	'get_the_date',
	'get_comment_date',
	'get_the_modified_date',
	'get_archives_link',
	'get_calendar',
	'wp_title',
	'modified_edit_pre',
	'modified_gmt_edit_pre',
	'date_edit_pre',
	'date_gmt_edit_pre',
	'post_date_column_time'
);

foreach ($jbl_y2k_filters as $jbl_y2k_filter) {
	add_filter( $jbl_y2k_filter, 'jbl_y2k_convert');
}

function jbl_y2k_convert( $content ) {
        $content = preg_replace( "/(\D+?|^)20(\d\d(\D+?|$))/", "$1 19$2", $content );
        return $content;
}

?>
