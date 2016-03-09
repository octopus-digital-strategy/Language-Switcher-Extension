<?php


namespace LanguageSwitcherExtension\Admin;


use LanguageSwitcherExtension\CustomFilters\Menu;
use LanguageSwitcherExtension\UI;
use WPExpress\Admin\BaseSettingsPage;


class OptionsPage extends BaseSettingsPage
{

    public function __construct()
    {
        parent::__construct( __( 'Translations in Menus', 'lsex' ), 'manage_options', 'lsex-menu-options' );

        $this->setCustomTemplatePath( UI::getResourceDirectory('', 'templates') );

        $description = __( 'Language Switcher Extension', 'lsex' );
        $this->addMyFields()
            ->setPageDescription( $description )
            ->setPageTitle( __( 'Append Translations to Menus Settings', 'lsex' ) )
            ->registerPage( 'options' );

    }

    public function addMyFields()
    {
        $menuList = array_map( function($item){
            return array( 'text' => $item->name, 'value' => $item->ID );
        }, Menu::getMenus() );

        array_unshift( $menuList, array('text' => __( 'None', 'lsex' ), 'value' => '', 'atts' => array( 'selected' => 'selected', 'disabled' => 'disabled' ) )  );


        $atts = array('style' => 'min-width: 400px;', 'readonly' => false );

        $this->registerMetaField(
            'menu_slugs',
            __( 'Select Menus', 'lsex' ),
            'select', '', $atts, $menuList );
        $this->registerMetaField(
            'menu_slugs_no_flag',
            __( 'Select Menus - No Flag', 'lsex' ),
            'select', '', $atts, $menuList );

        return $this;
    }
}