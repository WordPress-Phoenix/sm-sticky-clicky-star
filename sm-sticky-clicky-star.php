<?php
/**
 * SM Sticky Clicky Star
 *
 * @wordpress-plugin
 * @package        WordPress
 * @subpackage     Sm_sticky_clicky_star
 * @author         Seth Carstens - WordPress Phoenix
 * @license        GNU GPL v2.0+
 * @link           https://wordpress.org/plugins/sm-sticky-clicky-star
 *
 * Built with WP PHX WordPress Development Toolkit v3.1.0 on Friday 12th of April 2019 04:15:38 AM
 * @link           https://github.com/WordPress-Phoenix/wordpress-development-toolkit
 *
 * Plugin Name: SM Sticky Clicky Star
 * Plugin URI: https://wordpress.org/plugins/sm-sticky-clicky-star
 * Description: Turn sticky (featured) posts on and off with 1 easy click! Control permissions with “User Role Editor”.
 * Version: 2.0.1
 * Author: Seth Carstens
 * Author URI: https://sethcarstens.com
 * Text Domain: sm-sticky-clicky-star
 * License: GNU GPL v2.0+
 */

defined( 'ABSPATH' ) || die(); // WordPress must exist.

$current_dir = trailingslashit( dirname( __FILE__ ) );

/**
 * 3RD PARTY DEPENDENCIES
 * (manually include_once dependencies installed via composer for safety)
 */
if ( ! class_exists( 'WPAZ_Plugin_Base\\V_2_6\\Abstract_Plugin' ) ) {
	include_once $current_dir . 'lib/wordpress-phoenix/abstract-plugin-base/src/abstract-plugin.php';
}

/**
 * INTERNAL DEPENDENCIES (autoloader defined in main plugin class)
 */
require_once $current_dir . 'app/class-plugin.php';

SM\Sticky_Clicky_Star\Plugin::run( __FILE__ );
