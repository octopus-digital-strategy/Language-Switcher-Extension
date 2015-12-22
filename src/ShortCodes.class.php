<?php


namespace LanguageSwitcherExtension;


use WPExpress\UI\RenderEngine;

class ShortCodes
{

    public function __construct()
    {
        $this->registerShortCodes();
    }

    public function registerFilters()
    {
        add_filter( 'msls_output_get', array($this, 'linkOutputOverride'), 10, 3 );
    }

    public function registerShortCodes()
    {
        if( function_exists( 'the_msls' ) ) {
            add_shortcode( 'lsex-get-language-link', array($this, 'getLanguageLink') );
        }

        return $this;
    }

    public function getLanguageLink()
    {
        $obj = new \MslsOutput;
        $context = array(
            'text' => implode( '', $obj->get( 0 ) ),
        );

        $engine = new RenderEngine( UI::getResourceDirectory( '', 'templates/mustache' ) );

        return $engine->renderTemplate( 'link-template.mustache', $context );

    }

    public function linkOutputOverride( $url, $link, $current )
    {

        if( !is_front_page() && (empty($url) || (count( explode( '/', $url ) ) < 4)) ) {
            return null;
        }

        $translation = '';
        switch( $link->txt ) {
            case "es_MX":
                $translation = __( 'es_MX', 'lsex' );
                break;
            case "es_ES":
                $translation = __( 'es_ES', 'lsex' );
                break;
            case "fr_FR":
                $translation = __( 'fr_FR', 'lsex' );
                break;
            default:
                $translation = __( 'en_EN', 'lsex' );
        }

        $context = array(
            'url'        => $url,
            'text'       => $translation,
            'isCurrent'  => ($current ? ' class="current" ' : ''),
            'anchorText' => ((string)$link),
        );

        $engine = new RenderEngine( UI::getResourceDirectory( '', 'templates/mustache' ) );

        return $engine->renderTemplate( 'link-output.mustache', $context );

    }


}