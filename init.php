<?php
/**
 * Plugin name: Multisite Language Switcher Extension
 * Plugin URI: https://github.com/octopus-digital-strategy/Language-Switcher-Extension
 * Description: This plugin extends the functionality of the plugin Multisite Language Switcher. Adding a couple of shortcodes and an easy way to append translation to menus
 * Version: 0.8.1
 * Author: Page-Carbajal
 * Author URI: http://pagecarbajal.com
 */

// No direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Composer implementation
require_once('vendor/autoload.php');

// Instance the Setup
// Requires other plugins
function setupLSExPlugin()
{
    new \LanguageSwitcherExtension\SetupPlugin();
}
add_action('plugins_loaded', 'setupLSExPlugin');