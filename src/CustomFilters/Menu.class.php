<?php


namespace LanguageSwitcherExtension\CustomFilters;


use LanguageSwitcherExtension\UI\OptionsPage;

class Menu
{

    public function __construct()
    {
        add_filter( 'wp_get_nav_menu_items', array($this, 'filterNavigationMenuItems'), 10, 3 );
    }

    public function filterNavigationMenuItems( $items, $menu, $args )
    {
        // Only if the Multisite Language Switcher Plugin is installed and active
        if( function_exists( 'the_msls' ) ) {

            $options = new OptionsPage();

            $menuSlugs = $options->getValue( 'menu_slugs' );

            if( $menuSlugs == $menu->term_id ) {
                global $post;
                $sites = \MslsBlogCollection::instance()->get();
                foreach( \MslsOptions::instance()->create()->get_arr() as $language => $postID ) {
                    foreach( $sites as $siteID => $site ) {
                        if( $site->get_language() == $language ) {
                            $link = \MslsLink::create( $siteID );
                            $link->src = \MslsOptions::instance()->get_flag_url( $language );
                            $link->alt = $site->get_description();
                            $link->txt = $site->get_description();

                            $new_item = new \stdClass;
                            $new_item->menu_order = count( $items );
                            $new_item->url = get_blog_permalink( $siteID, $post->ID );
                            $new_item->title = (string)$link;
                            $items[] = $new_item;
                        }
                    }
                }

            }

        }

        return $items;
    }

    public static function getMenus()
    {
        $list = array();

        foreach( wp_get_nav_menus() as $m ) {
            $item = new \stdClass();
            $item->ID = $m->term_id;
            $item->name = $m->name;
            $item->slug = $m->slug;
            $list[] = $item;
        }

        return $list;
    }

}