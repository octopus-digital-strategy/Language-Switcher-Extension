<?php


namespace LanguageSwitcherExtension\CustomFilters;


use LanguageSwitcherExtension\Translations;
use LanguageSwitcherExtension\Admin\OptionsPage;
use LanguageSwitcherExtension\UI;
use WPExpress\UI\RenderEngine;


class Menu
{

    public function __construct()
    {
        //add_filter('wp_get_nav_menu_items', array( $this, 'filterNavigationMenuItems' ), 10, 3);
        $options  = new OptionsPage();
        $menuSlug = $options->getOptionValue('menu_slugs');
        if( !empty( $menuSlug ) ) {
            add_filter("wp_nav_menu_{$menuSlug}_items", array( $this, 'renderMenuItemsForAvailableTranslations' ), 10, 2);
        }

        $menuSlug = $options->getOptionValue('menu_slugs_no_flag');
        if( !empty( $menuSlug ) ) {
            add_filter("wp_nav_menu_{$menuSlug}_items", array( $this, 'renderMenuItemsForAvailableTranslationsWithoutFlags' ), 10, 2);
        }
    }

    public function renderMenuItemsForAvailableTranslations( $items, $arguments )
    {
        $items .= $this->renderMenuItems();
        return $items;
    }

    public function renderMenuItemsForAvailableTranslationsWithoutFlags( $items, $arguments )
    {
        $items .= $this->renderMenuItems(false);
        return $items;
    }

    private function renderMenuItems( $showFlags = true )
    {
        // Only if the Multisite Language Switcher Plugin is installed and active
        $raw = '';
        if( function_exists('the_msls') ) {

            $templateName = apply_filters('lsex-list-item-template-name', 'list-item-template');
            $translations = new Translations();
            $engine       = new RenderEngine(UI::getResourceDirectory('', 'templates'));

            foreach( $translations->getTranslations() as $index => $t ) {
                $context = array(
                    'listItemClass'   => apply_filters('lsex-list-item-classes', ''),
                    'linkURL'         => $t['url'],
                    'flagURL'         => ( $showFlags ? $t['flagURL'] : null ),
                    'class'           => 'translationLink',
                    'linkDescription' => $t['linkText'],
                    'linkText'        => $t['linkText'],
                );
                $raw .= $engine->renderTemplate($templateName, $context);
            }

        }

        return $raw;
    }

    public function filterNavigationMenuItems( $items, $menu, $args )
    {
        // Only if the Multisite Language Switcher Plugin is installed and active
        if( function_exists('the_msls') ) {

            $options = new OptionsPage();

            $menuSlugs = $options->getValue('menu_slugs');

            if( $menuSlugs == $menu->term_id ) {

                $translations = new Translations();

                foreach( $translations->getTranslations() as $index => $t ) {
                    $new_item             = new \stdClass;
                    $new_item->menu_order = count($items);
                    $new_item->url        = $t['url'];
                    $new_item->title      = $t['htmlLink'];
                    $items[]              = $new_item;
                }

            }

        }

        return $items;
    }

    public static function getMenus()
    {
        $list = array();

        foreach( wp_get_nav_menus() as $m ) {
            $item       = new \stdClass();
            $item->ID   = $m->term_id;
            $item->name = $m->name;
            $item->slug = $m->slug;
            $list[]     = $item;
        }

        return $list;
    }

}