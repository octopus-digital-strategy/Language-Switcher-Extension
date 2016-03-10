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
                $imgURL       = \MslsOptions::instance()->get_flag_url($language);
                $thePermalink = get_blog_permalink($site->userblog_id, $post->ID);
                $linkText     = $this->getLanguageTranslation($site->get_description());

                if( !empty( $imgURL ) && is_string($imgURL) ) {
                    $translations[$language] = array(
                        'url'      => $thePermalink,
                        'flagURL'  => $imgURL,
                        'flag'     => "<img src=\"{$imgURL}\" alt=\"{$site->get_description()}\"/>",
                        'htmlLink' => "<a href=\"{$thePermalink}\" class=\"translationLink\"><img src=\"{$imgURL}\" alt=\"{$site->get_description()}\"> {$linkText}</a>",
                        'linkText' => $linkText,
                    );
                }
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

    public static function getLanguageTranslation( $languageKey )
    {
        if( $languageKey == 'es' ) {
            $languageKey = 'es_MX';
        }

        switch( strtolower($languageKey) ) {
            case "es_mx":
                $translation = __('es_MX', 'lsex');
                break;
            case "es_es":
                $translation = __('es_ES', 'lsex');
                break;
            case "fr_fr":
                $translation = __('fr_FR', 'lsex');
                break;
            default:
                $translation = __('en_EN', 'lsex');
        }

        return $translation;
    }

}