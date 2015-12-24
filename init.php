<?php
/**
 * Plugin name: Language Switcher Extension
 * Plugin URI: https://github.com/octopus-digital-strategy/Language-Switcher-Extension
 * Description: Additional functionality for Multisite Language Switcher
 * Version: 0.4
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