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
                $options = new \MslsOptionsPost( get_queried_object_id() );

                foreach( $options->get_arr() as $language => $postID ) {

                    $site = $this->getSiteByLanguage( $language );

                    if( $site !== false ) {
                        $link = \MslsLink::create( $site->userblog_id );
                        $link->src = \MslsOptions::instance()->get_flag_url( $language );
                        $link->alt = $site->get_description();
                        $link->txt = "&nbsp;";

                        $new_item = new \stdClass;
                        $new_item->menu_order = count( $items );
                        $new_item->url = get_blog_permalink( $site->userblog_id, $post->ID );
                        $new_item->title = (string)$link;
                        $items[] = $new_item;

                    }

                }

            }

        }

        return $items;
    }

    private function getSiteByLanguage( $language )
    {
        $sites = \MslsBlogCollection::instance()->get();
        foreach( $sites as $id => $s ) {
            if( $language == $s->get_language() ) {
                return $sites[$id];
            }
        }
        return false;
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