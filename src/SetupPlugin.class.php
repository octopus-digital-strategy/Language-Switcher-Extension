<?php


namespace LanguageSwitcherExtension;


use LanguageSwitcherExtension\CustomFilters\Menu;
use LanguageSwitcherExtension\UI\OptionsPage;


class SetupPlugin
{

    public function __construct()
    {
        $this->registerStylesAndScripts()->registerTextDomain()->registerFilters();
        // Options Page
        new OptionsPage();
        // Register Shortcodes
        new ShortCodes();
    }

    public function registerFilters()
    {
        new Menu();
        return $this;
    }

    public function registerStylesAndScripts()
    {
        // Load scripts for the front end
        add_filter( 'admin_enqueue_scripts', array(__CLASS__, 'enqueueStyles') );
        add_filter( 'admin_enqueue_scripts', array(__CLASS__, 'enqueueScripts') );
        return $this;
    }

    public function registerTextDomain()
    {
        add_filter( 'plugins_loaded', array($this, 'registerPluginTextDomain') );
        return $this;
    }

    public function registerPluginTextDomain()
    {
        if( $path = UI::getResourceDirectory( '', 'languages' ) ) {
            load_plugin_textdomain( 'lsex', false, $path );
        }
    }

    // Static methods
    public static function enqueueStyles()
    {
        if( $stylePath = UI::getResourceURL( 'select2.min.css', 'bower_components/select2/dist/css' ) ) {
            wp_enqueue_style( 'select2-css', $stylePath );
        }
    }

    public static function enqueueScripts()
    {
        if( $scriptPath = UI::getResourceURL( 'select2.min.js', 'bower_components/select2/dist/js' ) ) {
            wp_enqueue_script( 'select2-js', $scriptPath, array('jquery') );
        }
    }

}
