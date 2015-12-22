<?php


namespace LanguageSwitcherExtension;



use WPExpress\UI\RenderEngine;

class ShortCodes
{

    public function __construct()
    {
        $this->registerShortCodes();
    }

    public function registerShortCodes()
    {
        if( function_exists( 'the_msls' ) ){
            add_shortcode( 'lsex-get-language-link', array( $this, 'getLanguageLink' ) );
        }

        return $this;
    }

    public function getLanguageLink()
    {
        $obj = new \MslsOutput;
        $context = array(
            'text' => implode( '',  $obj->get( 0 ) ),
        );

        $engine = new RenderEngine( UI::getResourceDirectory( '', 'templates/mustache' ) );

        return $engine->renderTemplate( 'link-template.mustache', $context );

    }

}