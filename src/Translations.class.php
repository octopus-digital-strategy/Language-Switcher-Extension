<?php


namespace LanguageSwitcherExtension;


class Translations
{

    private $translations;

    public function __construct()
    {
        $this->setTranslations();
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

    private function setTranslations()
    {
        global $post;
        $options = new \MslsOptionsPost(get_queried_object_id());

        $languages    = $options->get_arr();
        $translations = array();

        foreach( $languages as $language => $postID ) {
            $site = $this->getSiteByLanguage($language);

            if( $site !== false ) {
                $imgURL                  = \MslsOptions::instance()->get_flag_url($language);
                $translations[$language] = array(
                    'url'      => get_blog_permalink($site->userblog_id, $post->ID),
                    'htmlLink' => "<img src=\"{$imgURL}\" alt=\"{$site->get_description()}\"/>",
                );
            }
        }

        $this->translations = $translations;
    }

    public function getTranslations( $targetLanguage = '' )
    {
        if( empty( $targetLanguage ) ) {
            return empty( $this->translations ) ? array() : $this->translations;
        }
        return isset( $this->translations[$targetLanguage] ) ? $this->translations[$targetLanguage] : array();
    }

}