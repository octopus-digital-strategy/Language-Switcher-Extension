<?php


namespace LanguageSwitcherExtension\CustomFilters;


use LanguageSwitcherExtension\Translations;
use LanguageSwitcherExtension\UI\OptionsPage;


class Menu
{

    public function __construct()
    {
        add_filter('wp_get_nav_menu_items', array( $this, 'filterNavigationMenuItems' ), 10, 3);
    }

    public function filterNavigationMenuItems( $items, $menu, $args )
    {
        // Only if the Multisite Language Switcher Plugin is installed and active
        if( function_exists('the_msls') ) {

            $options = new OptionsPage();

            $menuSlugs = $options->getValue('menu_slugs');

            if( $menuSlugs == $menu->term_id ) {

                $translations = new Translations();

                foreach( $translations->getTranslations() as $index => $t ){
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