<?php


namespace LanguageSwitcherExtension\UI;


use WPExpress\Abstractions\SettingsPage;


class OptionsPage extends SettingsPage
{

    public function __construct()
    {
        parent::__construct( __( 'Append Tranlations to Menus', 'lsex' ), 'manage_options', 'lsex-menu-options' );

        $description = __( 'Language Switcher Extension', 'lsex' );
        $this->addMyFields()
            ->setPageDescription( $description )
            ->setPageTitle( __( 'Email Tool', 'lsex' ) )
            ->registerPage( 'options' );

    }

    public function addMyFields()
    {
        $atts = array('style' => 'min-width: 400px;', 'readonly' => false);
        $this->registerMetaField( 'menu_slugs', __( 'Append Translations to Menus', 'lsex' ), 'text', '', $atts );
        $this->registerMetaField( 'menu_slugs_no_flag', __( 'Append Translations to Menus - No Flag', 'lsex' ), 'text', '', $atts );

        return $this;
    }
}