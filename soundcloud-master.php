<?php
/**
Plugin Name: SoundCloud Master
Plugin URI: http://wordpress.techgasp.com/soundcloud-master/
Version: 4.0
Author: TechGasp
Author URI: http://wordpress.techgasp.com
Text Domain: soundcloud-master
Description: SoundCloud Master is a light weight and shiny clean code wordpress plugin WIDGET that you need to show off and sell your music.
License: GPL2 or later
*/
/*  Copyright 2013 TechGasp  (email : info@techgasp.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(!class_exists('soundcloud_master')) :

// DEFINE PLUGIN ID
define('SOUNDCLOUD_MASTER_ID', 'soundcloud-master');

// DEFINE PLUGIN NICK
define('SOUNDCLOUD_MASTER_NICK', 'SoundCloud Master');

// HOOK WIDGET
require_once('includes/soundcloud-master-widget.php');

// HOOK INVITATION

// HOOK SHORTCODE

	class soundcloud_master{
		/** function/method
		* Usage: return absolute file path
		* Arg(1): string
		* Return: string
		*/
		public static function file_path($file)
		{
			return ABSPATH.'wp-content/plugins/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).$file;
		}
		/** function/method
		* Usage: hooking the plugin options/settings
		* Arg(0): null
		* Return: void
		*/
		public static function soundcloud_master_register()
		{
			register_setting(SOUNDCLOUD_MASTER_ID, 'tsm_quote');
		}
		/** function/method
		* Usage: hooking (registering) the plugin menu
		* Arg(0): null
		* Return: void
		*/
		public static function menu()
		{
			// Create menu tab
			add_options_page(SOUNDCLOUD_MASTER_NICK.' Plugin Options', SOUNDCLOUD_MASTER_NICK, 'manage_options', SOUNDCLOUD_MASTER_ID.'-admin', array('soundcloud_master', 'options_page'));
			add_filter( 'plugin_action_links', array('soundcloud_master', 'soundcloud_master_link'), 10, 2 );
		}
		/** function/method
		* Usage: show options/settings form page
		* Arg(0): null
		* Return: void
		*/
		public static function options_page()
		{
			if (!current_user_can('manage_options'))
			{
				wp_die( __('You do not have sufficient permissions to access this page.') );
			}
			$plugin_id = SOUNDCLOUD_MASTER_ID;
			// display options page
			include(self::file_path('includes/soundcloud-master-admin.php'));
		}
		/** function/method
                * Usage: show options/settings form page
                * Arg(0): null
                * Return: void
                */
		 public static function soundcloud_master_widget()
                {
                        // display widget page
                        include(self::file_path('includes/soundcloud-master-widget.php'));
                }
		/** function/method
		* Usage: filtering the content
		* Arg(1): string
		* Return: string
		*/
		public static function content_with_quote($content)
		{
			$quote = '<p>' . get_option('tsm_quote') . '</p>';
			return $content . $quote;
		}
		// Add settings link on plugin page
		public static function soundcloud_master_link($links, $file) {
			static $this_plugin;
			if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);
			if ($file == $this_plugin){
				$settings_link = '<a href="' . admin_url( 'options-general.php?page='.SOUNDCLOUD_MASTER_ID).'-admin' . '">' . __( 'Settings' ) . '</a>';
				array_unshift($links, $settings_link);
			}
		return $links;
		}
		// Advanced Updater
	}
	if ( is_admin() )
		{
		add_action('admin_init', array('soundcloud_master', 'soundcloud_master_register'));
		add_action('admin_menu', array('soundcloud_master', 'menu'));
		
		}
	add_filter('the_content', array('soundcloud_master', 'content_with_quote'));
endif;
?>