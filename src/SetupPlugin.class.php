<?php


namespace LanguageSwitcherExtension;



class SetupPlugin
{

    public function __construct()
    {
        $this->registerTextDomain();
        // Register Shortcodes
        new ShortCodes();
    }

    public function registerStylesAndScripts()
    {
        // Load scripts for the front end
        add_filter( 'wp_enqueue_scripts', array( __CLASS__, 'enqueueStyles' ) );
        add_filter( 'wp_enqueue_scripts', array( __CLASS__, 'enqueueScripts' ) );
        return $this;
    }

    public function registerTextDomain()
    {
        add_filter('plugins_loaded', array($this, 'registerPluginTextDomain') );
        return $this;
    }

    public function registerPluginTextDomain()
    {
        if( $path = UI::getResourceDirectory( '', 'languages' ) ){
            load_plugin_textdomain( 'lsex', false, $path );
        }
    }

    // Static methods
    public static function enqueueStyles()
    {
        if( $stylePath = UI::getResourceURL( 'language-switcher-extension.css', 'css' ) ){
            wp_enqueue_style( 'language-switcher-extension-css', $stylePath );
        }
    }

    public static function enqueueScripts()
    {
        if( $scriptPath = UI::getResourceURL( 'language-switcher-extension.js', 'javascript' ) ){
            wp_enqueue_script( 'language-switcher-extension-js', $scriptPath, array( 'jquery' ) );
        }
    }

}
