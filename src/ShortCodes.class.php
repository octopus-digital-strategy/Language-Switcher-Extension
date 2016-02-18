<?php


namespace LanguageSwitcherExtension;


use WPExpress\UI\RenderEngine;
use LanguageSwitcherExtension\UI;


class ShortCodes
{

    public function __construct()
    {
        $this->registerShortCodes();
    }

    public function registerFilters()
    {
        add_filter('msls_output_get', array( $this, 'linkOutputOverride' ), 10, 3);
    }

    public function registerShortCodes()
    {
        if( function_exists('the_msls') ) {
//            the_msls();
            add_shortcode('lsex-get-language-url', array( $this, 'getLanguageURL' ));
            add_shortcode('lsex-link-to-language', array( $this, 'linkToLanguage' ));
            add_shortcode('lsex-translation-links', array( $this, 'translationLinks' ));
        }

        return $this;
    }

    public function translationLinks()
    {
        $output = '';
        $t = new Translations();
        foreach( $t->getTranslations() as $bean ){
            $output = "{$output} {$bean['htmlLink']}";
        }
        return $output;
    }

    public function getLanguageURL( $atts )
    {
        $properties = array(
            'language' => 'en_EN',
        );

        $properties = shortcode_atts($properties, $atts);

        $translations = new Translations();

        $languageLink = $translations->getTranslations($properties['language']);

        return ( isset( $languageLink['url'] ) ? $languageLink['url'] : false );
    }

    public function linkToLanguage( $atts, $content = '' )
    {

        $properties = array(
            'language' => 'en_EN',
        );

        $properties = shortcode_atts($properties, $atts);

        $context = array(
            'hasClass' => ( !empty( $properties['link-class'] ) ),
            'class'    => $properties['link-class'],
            'linkText' => $content,
            'linkURL'  => $this->getLanguageURL($properties),
        );

        $engine = new RenderEngine(UI::getResourceDirectory('', 'templates/mustache'));

        return $engine->renderTemplate('link-to-language', $context);
    }

    public function linkOutputOverride( $url, $link, $current )
    {
        if( !is_front_page() && ( empty( $url ) || ( count(explode('/', $url)) < 4 ) ) ) {
            return null;
        }

        $translation = '';
        switch( $link->txt ) {
            case "es_MX":
                $translation = __('es_MX', 'lsex');
                break;
            case "es_ES":
                $translation = __('es_ES', 'lsex');
                break;
            case "fr_FR":
                $translation = __('fr_FR', 'lsex');
                break;
            default:
                $translation = __('en_EN', 'lsex');
        }

        $context = array(
            'url'        => $url,
            'text'       => $translation,
            'isCurrent'  => ( $current ? ' class="current" ' : '' ),
            'anchorText' => ( (string)$link ),
        );

        $engine = new RenderEngine(UI::getResourceDirectory('', 'templates/mustache'));

        return $engine->renderTemplate('link-output.mustache', $context);

    }


}