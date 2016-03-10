<?php


namespace LanguageSwitcherExtension;


use WPExpress\UI\BaseResources;


class UI extends BaseResources
{
    public function getBaseDirectory()
    {
        return untrailingslashit( plugin_dir_path(__FILE__) ) . "/../resources/";
    }

    public function getBaseURL()
    {
        return untrailingslashit(plugin_dir_url( __FILE__ )) . "/../resources/";
    }
}