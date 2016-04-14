<?php


namespace LanguageSwitcherExtension;


use LanguageSwitcherExtension\Admin\MetaBox;
use LanguageSwitcherExtension\CustomFilters\Menu;
use LanguageSwitcherExtension\Admin\OptionsPage;


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
//        if( is_admin() ){
//            add_action('admin_init', array( $this, 'registerMetaBox' ));
//        }
        return $this;
    }

//    public function registerMetaBox()
//    {
//        new MetaBox();
//    }

    public function registerStylesAndScripts()
    {
        // Load scripts for the front end
        add_filter('admin_enqueue_scripts', array( __CLASS__, 'enqueueStyles' ));
        add_filter('admin_enqueue_scripts', array( __CLASS__, 'enqueueScripts' ));
        return $this;
    }

    public function registerTextDomain()
    {
        $locale = get_locale();
        $moFile = UI::getResourceDirectory("lsex-{$locale}.mo", 'languages');
        if( false !== $moFile ) {
            $pluginFilePath = plugin_basename(__FILE__);
            $filePath       = explode('/', $pluginFilePath);

            load_plugin_textdomain('lsex', false, "{$filePath[0]}/resources/languages/");
        }
        return $this;
    }

    // Static methods
    public static function enqueueStyles()
    {
        if( $stylePath = UI::getResourceURL('select2.min.css', 'bower_components/select2/dist/css') ) {
            wp_enqueue_style('select2-css', $stylePath);
        }
    }

    public static function enqueueScripts()
    {
        if( $scriptPath = UI::getResourceURL('select2.min.js', 'bower_components/select2/dist/js') ) {
            wp_enqueue_script('select2-js', $scriptPath, array( 'jquery' ));
        }
    }

}
