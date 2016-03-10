<?php


namespace LanguageSwitcherExtension\Admin;


use LanguageSwitcherExtension\CustomFilters\Menu;
use LanguageSwitcherExtension\UI;
use WPExpress\Admin\BaseSettingsPage;


class OptionsPage extends BaseSettingsPage
{

    public function __construct()
    {
        // Set Type of Page
        $this->pageType = 'management';
        // Invoke parent to register page
        parent::__construct(__('Translations in Menus', 'lsex'), 'manage_options', 'lsex-menu-options');
        // Custom path to template folder
        $this->setCustomTemplatePath(UI::getResourceDirectory('', 'templates'));
        // Page Description
        $this->setPageDescription(__('A Language Switcher Extension', 'lsex'));
        // Page Title
        $this->setPageTitle(__('Append Translations Items to Menus', 'lsex'));
        // Add custom options
        $this->addPageOptions();
    }

    public function addPageOptions()
    {
        $menuList = array_map(function ( $item ) {
            return array( 'text' => $item->name, 'value' => $item->slug );
        }, Menu::getMenus());

        $menuList[] = array( 'text' => 'N/A', 'value' => '', 'selected' => 1 );

        $menuWithFlags = $this->getOptionValue('menu_slugs');
        $this->fields->addSelect('menu_slugs', $menuList);
        $this->fields->setValue($menuWithFlags);
        $this->fields->addLabel(__('Append Flag + Text to', 'lsex'));

        // 2 Lines
        $menuNoFlags = $this->getOptionValue('menu_slugs_no_flag');
        $this->fields->addSelect('menu_slugs_no_flag', $menuList)->addLabel(__('Append Text-Only item to', 'lsex'))->setValue($menuNoFlags);

        return $this;
    }

}